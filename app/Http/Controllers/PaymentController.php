<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function showPayment(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation);

        return view('booking.payment', compact('reservation'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'proof_image'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'reservation_id' => 'required',
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);

        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        Payment::create([
            'reservation_id' => $reservation->id,
            'payment_method' => 'Transfer Bank',
            'proof_image'    => $path,
            'amount'         => $reservation->total_price,
            'status'         => 'Waiting Verification',
            'paid_at'        => now(),
        ]);

        $reservation->update(['status' => 'Waiting Verification']);

        return back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }

    public function order(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation_id);
        $reservation->update(['status' => 'Waiting Verification']);

        return redirect()->route('payment.confirmation', ['reservation' => $reservation->id]);
    }

    public function cancel(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation_id);
        $reservation->update(['status' => 'Cancelled']);

        return redirect('/');
    }

    public function confirmation(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation);

        return view('pages.confirmation', compact('reservation'));
    }

    public function checkStatus(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation);

        return response()->json([
            'status' => $reservation->status
        ]);
    }
}