<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $room = (object)[
            'id'    => null,
            'name'  => $request->room_name,
            'type'  => $request->room_type,
            'offer' => $request->offer,
            'image' => null,
        ];

        $checkIn    = $request->check_in;
        $checkOut   = $request->check_out;
        $guestTotal = $request->guest_total ?? 1;
        $totalPrice = $request->total_price ?? 0;

        return view('pages.booking', compact('room', 'checkIn', 'checkOut', 'guestTotal', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|max:255',
        ]);

        $reservation = Reservation::create([
            'reservation_code' => 'RSV-' . strtoupper(uniqid()),
            'name'           => trim($request->first_name . ' ' . $request->last_name),
            'email'          => $request->email,
            'room_id'        => $request->room_id,
            'room_name'      => $request->room_name,
            'room_type'      => $request->room_type,
            'offer'          => $request->offer,
            'check_in'       => $request->check_in,
            'check_out'      => $request->check_out,
            'guest_total'    => $request->guest_total,
            'total_price'    => $request->total_price,
            'payment_status' => 'unpaid',
            'status'         => 'Pending Payment',
        ]);

        // Sesudah ✅
        return redirect()->route('payment.show', ['reservation' => $reservation->id]);
    }
}
