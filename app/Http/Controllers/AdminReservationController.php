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

        $total    = $reservations->count();
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
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'room_name'  => 'required|string',
            'room_type'  => 'required|string',
            'check_in'   => 'required|date|after_or_equal:today',
            'check_out'  => 'required|date|after:check_in',
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

        $reservation->update([
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}