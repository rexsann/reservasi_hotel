<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::query();

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

        $aktif   = $reservations->whereIn('status', ['Pending Payment', 'Waiting Verification', 'Confirmed', 'Checked In']);
        $riwayat = $reservations->whereIn('status', ['Checked Out', 'Cancelled']);

        $total     = $reservations->count();
        $confirmed = $reservations->where('status', 'Confirmed')->count();
        $pending   = $reservations->where('status', 'Pending Payment')->count();
        $canceled  = $reservations->where('status', 'Cancelled')->count();

        $income = $reservations->where('status', 'Checked Out')->sum('total_price');
        $lost   = $reservations->where('status', 'Cancelled')->sum('total_price');

        return view('admin.admin_reservation', compact(
            'reservations',
            'aktif',
            'riwayat',
            'total',
            'confirmed',
            'pending',
            'canceled',
            'income',
            'lost'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'room_name'   => 'required|string',
            'room_type'   => 'required|string',
            'check_in'    => 'required|date|after_or_equal:today',
            'check_out'   => 'required|date|after:check_in',
            'total_price' => 'required|numeric',
        ]);

        Reservation::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'room_name'   => $request->room_name,
            'room_type'   => $request->room_type,
            'offer'       => $request->offer,
            'check_in'    => $request->check_in,
            'check_out'   => $request->check_out,
            'guest_total' => $request->guest_total ?? 1,
            'total_price' => $request->total_price,
            'status'      => 'Pending Payment',
        ]);

        return response()->json(['success' => true]);
    }

   public function update(Request $request, $id)
{
    $reservation = Reservation::findOrFail($id);

    $data = ['status' => $request->status];

    // Kalau ganti kamar
    if ($request->room_id) {
        $newRoom = Room::find($request->room_id);
        if ($newRoom) {
            // Kamar lama dikembalikan jadi Available (kalau beda kamar)
            if ($reservation->room_id && $reservation->room_id != $newRoom->id) {
                Room::where('id', $reservation->room_id)
                    ->update(['status' => 'Available']);
            }

            $data['room_id']   = $newRoom->id;
            $data['room_name'] = $newRoom->room_name;
            $data['room_type'] = $newRoom->type;

            // Kamar baru jadi Occupied
            $newRoom->update(['status' => 'Occupied']);
        }
    }

    // Kalau reservasi selesai/dibatalkan, kembalikan kamar jadi Available
    if (in_array($request->status, ['Checked Out', 'Cancelled'])) {
        if ($reservation->room_id) {
            Room::where('id', $reservation->room_id)
                ->update(['status' => 'Available']);
        }
    }

    $reservation->update($data);

    return response()->json(['success' => true]);
}

    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    // Method baru: ambil kamar tersedia sesuai tanggal reservasi
    public function availableRooms(Request $request)
{
    $checkin   = $request->checkin;
    $checkout  = $request->checkout;
    $excludeId = $request->exclude_reservation;
    $type      = $request->type; // filter by room type

    $bookedRoomIds = Reservation::where('id', '!=', $excludeId)
        ->whereNotIn('status', ['Cancelled', 'Checked Out'])
        ->where('check_in', '<', $checkout)
        ->where('check_out', '>', $checkin)
        ->pluck('room_id');

    $rooms = Room::whereNotIn('id', $bookedRoomIds)
        ->where('status', 'Available')
        ->when($type, fn($q) => $q->where('type', $type)) // filter type
        ->select('id', 'room_name', 'type', 'offer', 'price_per_night')
        ->orderBy('id')
        ->get();

    return response()->json(['rooms' => $rooms]);
}
}