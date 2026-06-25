<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function showPayment(Request $request)
{
    $reservation = Reservation::with('roomType')->findOrFail($request->reservation);

    // Ambil semua kamar dalam group yang sama
    $groupReservations = Reservation::with('roomType')
        ->where('reservation_code', $reservation->reservation_code)
        ->get();

    $totalPrice = $groupReservations->sum('total_price');

    return view('booking.payment', compact('reservation', 'totalPrice', 'groupReservations'));
}

    public function upload(Request $request)
    {
        try {
            $request->validate([
                'proof_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:3072',
                'reservation_id' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first(),
                'errors'  => $e->errors(),
            ], 422);
        }

        $reservation = Reservation::findOrFail($request->reservation_id);

// Cegah upload ulang jika sudah Waiting Verification atau Confirmed
if (in_array($reservation->status, ['Waiting Verification', 'Confirmed'])) {
    return response()->json([
        'success' => false,
        'message' => 'Proof of payment has already been submitted.',
    ], 403);
}

        // Sum semua kamar dalam group yang sama
        $total = Reservation::where('reservation_code', $reservation->reservation_code)
            ->sum('total_price');

        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        Payment::create([
            'reservation_id' => $reservation->id,
            'payment_method' => 'Transfer Bank',
            'proof_image'    => $path,
            'amount'         => $total,
            'status'         => 'Waiting Verification',
            'paid_at'        => now(),
        ]);

        // Update semua reservasi dalam group yang sama
        Reservation::where('reservation_code', $reservation->reservation_code)
            ->update([
                'status'  => 'Waiting Verification',
                'paid_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diupload!',
            'status'  => $reservation->fresh()->status,
        ]);
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

        Reservation::where('reservation_code', $reservation->reservation_code)
            ->update(['status' => 'Cancelled']);

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