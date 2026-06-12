<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::query()->with('roomType');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('check_in', $request->date);
        }

        $reservations = $query->latest()->get();

        $aktif   = $reservations->whereIn('status', [
            'Pending Payment',
            'Waiting Verification',
            'Confirmed',
            'Checked In'
        ]);

        $riwayat = $reservations->whereIn('status', [
            'Checked Out',
            'Cancelled'
        ]);

        $total     = $reservations->count();
        $confirmed = $reservations->where('status', 'Confirmed')->count();
        $pending   = $reservations->where('status', 'Pending Payment')->count();
        $canceled  = $reservations->where('status', 'Cancelled')->count();

        $income = $reservations->where('status', 'Checked Out')->sum('total_price');
        $lost   = $reservations->where('status', 'Cancelled')->sum('total_price');

        $roomTypes = RoomType::all();
        $offers    = Offer::all();

        return view('admin.admin_reservation', compact(
            'reservations',
            'aktif',
            'riwayat',
            'total',
            'confirmed',
            'pending',
            'canceled',
            'income',
            'lost',
            'roomTypes',
            'offers'
        ));
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'room_type_id' => 'required|integer|exists:room_types,id',
            'offer_id'     => 'required|integer|exists:offers,id',
            'check_in'     => 'required|date|after_or_equal:today',
            'check_out'    => 'required|date|after:check_in',
        ]);

        $offer  = Offer::findOrFail($request->offer_id);
        $nights = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));

        Reservation::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'room_name'    => null,
            'room_id'      => null,
            'room_type_id' => $request->room_type_id,
            'offer_id'     => $request->offer_id,
            'check_in'     => $request->check_in,
            'check_out'    => $request->check_out,
            'guest_total'  => 1,
            'total_price'  => $offer->price * $nights,
            'status'       => 'Pending Payment',
        ]);

        return response()->json(['success' => true]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => collect($e->errors())->flatten()->first(),
        ], 422);
    } catch (\Throwable $e) {
        Log::error('Store reservation failed: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

    public function update(Request $request, $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            $data = [
                'status' => $request->status,
            ];

            // Assign room number if provided
            if ($request->room_id) {
                $newRoom = Room::find($request->room_id);

                if ($newRoom) {
                    // Free up old room if different
                    if ($reservation->room_id && $reservation->room_id != $newRoom->id) {
                        Room::where('id', $reservation->room_id)->update(['status' => 'Available']);
                    }

                    $data['room_id']      = $newRoom->id;
                    $data['room_name']    = $newRoom->room_name;
                    $data['room_type_id'] = $newRoom->room_type_id;

                    Room::where('id', $newRoom->id)->update(['status' => 'Occupied']);
                }
            }

            // Free up room when checked out or cancelled
            if (in_array($request->status, ['Checked Out', 'Cancelled'])) {
                if ($reservation->room_id) {
                    Room::where('id', $reservation->room_id)->update(['status' => 'Available']);
                }
            }

            // Auto timestamps based on status
            if ($request->status === 'Waiting Verification') {
                $data['paid_at'] = now();
            }

            if ($request->status === 'Checked In') {
                $data['checked_in_at'] = now();
            }

            if ($request->status === 'Checked Out') {
                $data['checked_out_at'] = now();
            }

            if ($request->status === 'Cancelled') {
                $data['cancelled_at'] = now();
            }

            $reservation->update($data);

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Update reservation #' . $id . ' failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Reservation::findOrFail($id)->delete();

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Delete reservation #' . $id . ' failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function availableRooms(Request $request)
    {
        $checkin   = $request->checkin;
        $checkout  = $request->checkout;
        $excludeId = $request->exclude_reservation;
        $typeId    = $request->type; // room_type_id (integer)

        if (!$checkin || !$checkout) {
            return response()->json(['rooms' => []]);
        }

        $bookedRoomIds = Reservation::where('id', '!=', $excludeId)
            ->whereNotIn('status', ['Cancelled', 'Checked Out'])
            ->whereNotNull('room_id')
            ->where(function ($q) use ($checkin, $checkout) {
                $q->where('check_in', '<', $checkout)
                  ->where('check_out', '>', $checkin);
            })
            ->pluck('room_id')
            ->unique()
            ->values();

        $rooms = Room::where('status', 'Available')
            ->whereNotIn('id', $bookedRoomIds)
            ->when($typeId, fn($q) => $q->where('room_type_id', $typeId))
            ->select('id', 'room_name', 'room_type_id')
            ->orderBy('id')
            ->get();

        return response()->json(['rooms' => $rooms]);
    }
}