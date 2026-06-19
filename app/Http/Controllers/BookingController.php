<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\RoomType;
use App\Models\Offer;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $roomTypeIds = $request->input('room_type_ids', []);
        $offerIds    = $request->input('offer_ids', []);

        // Fallback kalau masih single (format lama)
        if (empty($roomTypeIds) && $request->room_type_id) {
            $roomTypeIds = [$request->room_type_id];
            $offerIds    = [$request->offer_id];
        }

        $rooms = [];
        foreach ($roomTypeIds as $i => $typeId) {
            $rooms[] = [
                'roomType' => RoomType::find($typeId),
                'offer'    => Offer::find($offerIds[$i] ?? null),
            ];
        }

        $checkIn    = $request->check_in;
        $checkOut   = $request->check_out;
        $guestTotal = $request->guest_total ?? 2;
        $totalPrice = $request->total_price ?? 0;

        return view('pages.booking', compact('rooms', 'checkIn', 'checkOut', 'guestTotal', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|max:255',
        ]);

        $roomTypeIds = $request->input('room_type_ids', []);
        $offerIds    = $request->input('offer_ids', []);
        $groupCode   = 'RSV-' . strtoupper(uniqid());
        $name        = trim($request->first_name . ' ' . $request->last_name);

        $firstReservation = null;

        foreach ($roomTypeIds as $i => $typeId) {
            $reservation = Reservation::create([
                // ✅ Fix
                'reservation_code' => $groupCode,
                'name'             => $name,
                'email'            => $request->email,
                'room_id'          => null,
                'room_type_id'     => $typeId,
                'offer_id'         => $offerIds[$i] ?? null,
                'check_in'         => $request->check_in,
                'check_out'        => $request->check_out,
                'guest_total'      => $request->guest_total,
                'total_price'      => $request->total_price,
                'payment_status'   => 'unpaid',
                'status'           => 'Pending Payment',
            ]);

            if ($i === 0) $firstReservation = $reservation;
        }

        return redirect()->route('payment.show', ['reservation' => $firstReservation->id]);
    }
}
