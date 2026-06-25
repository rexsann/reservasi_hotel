<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Mail\InvoiceMail;
use App\Mail\RejectionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PembayaranController extends Controller
{
    public function index()
{
    $pembayaran = Payment::with(['reservation.roomType'])
        ->latest()
        ->get()
        ->map(function ($payment) {
            $payment->groupReservations = Reservation::with('roomType')
                ->where('reservation_code', $payment->reservation->reservation_code)
                ->get();
            return $payment;
        });

    return view('admin.pembayaran', compact('pembayaran'));
}

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;

        if ($request->status === 'Paid') {
            $payment->paid_at = now();
        }

        $payment->save();

        $reservation     = $payment->reservation;
        $reservationCode = $reservation->reservation_code;

        if ($request->status === 'Paid') {
            // Update SEMUA reservation dalam group yang sama (multi-room),
            // bukan cuma reservation yang nempel langsung ke Payment
            Reservation::where('reservation_code', $reservationCode)
                ->update(['status' => 'Confirmed']);

            // Kirim invoice ke email guest
            Mail::to($reservation->email)
                ->send(new InvoiceMail($payment));

        } elseif ($request->status === 'Rejected') {
            Reservation::where('reservation_code', $reservationCode)
                ->update(['status' => 'Cancelled']);

            // Kirim email penolakan ke tamu
            Mail::to($reservation->email)
                ->send(new RejectionMail($payment, $request->alasan));
        }

        return response()->json(['message' => 'Status updated']);
    }
}