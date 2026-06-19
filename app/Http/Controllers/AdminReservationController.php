<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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

        $reservations = $query->latest()->get();

        $grouped = $reservations->groupBy('reservation_code')->map(function ($group) {
    $first = $group->first();

    $first->room_types_list = $group
        ->map(fn($r) => ($r->room_name ? $r->room_name . ' · ' : '') . ($r->roomType?->name ?? ''))
        ->filter()
        ->join(', ');

    $first->room_count = $group->count();

    // Jumlahkan total_price semua kamar dalam group
    $first->total_price = $group->sum('total_price');

    $first->group_members = $group->map(fn($r) => [
        'id'           => $r->id,
        'room_id'      => $r->room_id,
        'room_type_id' => $r->room_type_id,
        'room_name'    => $r->room_name ?? '—',
        'room_type'    => $r->roomType?->name ?? '—',
    ])->values()->toJson();

    return $first;
})->values();
        $aktif   = $grouped->whereIn('status', [
            'Pending Payment', 'Waiting Verification', 'Confirmed', 'Checked In'
        ])->values();

        $riwayat = $grouped->whereIn('status', [
            'Checked Out', 'Cancelled'
        ])->values();

        $confirmed = $grouped->where('status', 'Confirmed')->count();
        $pending   = $grouped->where('status', 'Pending Payment')->count();
        $canceled  = $grouped->where('status', 'Cancelled')->count();

        $income = $grouped->where('status', 'Checked Out')->sum('total_price');
        $lost   = $grouped->where('status', 'Cancelled')->sum('total_price');

        $roomTypes = RoomType::all();
        $offers    = Offer::all();

        return view('admin.admin_reservation', compact(
            'reservations', 'aktif', 'riwayat',
            'confirmed', 'pending', 'canceled',
            'income', 'lost', 'roomTypes', 'offers'
        ));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'                   => 'required|string|max:255',
                'email'                  => 'required|email|max:255',
                'check_in'               => 'required|date|after_or_equal:today',
                'check_out'              => 'required|date|after:check_in',
                'rooms'                  => 'required|array|min:1',
                'rooms.*.room_type_id'   => 'required|integer|exists:room_types,id',
                'rooms.*.offer_id'       => 'required|integer|exists:offers,id',
            ]);

            $nights          = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));
            $reservationCode = 'RSV-' . strtoupper(uniqid());

            foreach ($request->rooms as $room) {
                $offer = Offer::findOrFail($room['offer_id']);

                Reservation::create([
                    'name'             => $request->name,
                    'email'            => $request->email,
                    'reservation_code' => $reservationCode,
                    'room_name'        => null,
                    'room_id'          => null,
                    'room_type_id'     => $room['room_type_id'],
                    'offer_id'         => $room['offer_id'],
                    'check_in'         => $request->check_in,
                    'check_out'        => $request->check_out,
                    'guest_total'      => 1,
                    'total_price'      => $offer->price * $nights,
                    'status'           => 'Pending Payment',
                ]);
            }

            return response()->json(['success' => true]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Store reservation failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $status      = $request->status;
            $assignments = $request->assignments;

            $timestamps = [];
            if ($status === 'Waiting Verification') $timestamps['paid_at']        = now();
            if ($status === 'Checked In')           $timestamps['checked_in_at']  = now();
            if ($status === 'Checked Out')          $timestamps['checked_out_at'] = now();
            if ($status === 'Cancelled')            $timestamps['cancelled_at']   = now();

            // ── MODE A: multi-room assignments ───────────────────────────────────
            if (!empty($assignments) && is_array($assignments)) {

                foreach ($assignments as $a) {
                    $res    = Reservation::findOrFail($a['reservation_id']);
                    $roomId = $a['room_id'] ?? null;

                    $data = array_merge(['status' => $status], $timestamps);

                    if ($roomId) {
                        $newRoom = Room::find($roomId);
                        if ($newRoom) {
                            if ($res->room_id && $res->room_id != $newRoom->id) {
                                Room::where('id', $res->room_id)->update(['status' => 'Available']);
                            }
                            $data['room_id']      = $newRoom->id;
                            $data['room_name']    = $newRoom->room_name;
                            $data['room_type_id'] = $newRoom->room_type_id;
                            Room::where('id', $newRoom->id)->update(['status' => 'Occupied']);
                        }
                    }

                    if (in_array($status, ['Checked Out', 'Cancelled']) && $res->room_id) {
                        Room::where('id', $res->room_id)->update(['status' => 'Available']);
                    }

                    $res->update($data);
                }

                return response()->json(['success' => true]);
            }

            // ── MODE B: single room_id (backward-compatible) ─────────────────────
            $data = array_merge(['status' => $status], $timestamps);

            if ($request->room_id) {
                $newRoom = Room::find($request->room_id);
                if ($newRoom) {
                    if ($reservation->room_id && $reservation->room_id != $newRoom->id) {
                        Room::where('id', $reservation->room_id)->update(['status' => 'Available']);
                    }
                    $data['room_id']      = $newRoom->id;
                    $data['room_name']    = $newRoom->room_name;
                    $data['room_type_id'] = $newRoom->room_type_id;
                    Room::where('id', $newRoom->id)->update(['status' => 'Occupied']);
                }
            }

            if (in_array($status, ['Checked Out', 'Cancelled'])) {
                if ($reservation->room_id) {
                    Room::where('id', $reservation->room_id)->update(['status' => 'Available']);
                }
            }

            $sameGroup = Reservation::where('reservation_code', $reservation->reservation_code)->get();
            foreach ($sameGroup as $r) {
                $r->update($data);
            }

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {
            Log::error('Update reservation #' . $id . ' failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            Reservation::where('reservation_code', $reservation->reservation_code)->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Delete reservation #' . $id . ' failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function availableRooms(Request $request)
    {
        $checkin   = $request->checkin;
        $checkout  = $request->checkout;
        $excludeId = $request->exclude_reservation;
        $typeId    = $request->type;

        if (!$checkin || !$checkout) {
            return response()->json(['rooms' => []]);
        }

        $excludeIds = collect([$excludeId]);
        if ($excludeId) {
            $res = Reservation::find($excludeId);
            if ($res && $res->reservation_code) {
                $excludeIds = Reservation::where('reservation_code', $res->reservation_code)
                    ->pluck('id');
            }
        }

        $bookedRoomIds = Reservation::whereNotIn('id', $excludeIds)
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