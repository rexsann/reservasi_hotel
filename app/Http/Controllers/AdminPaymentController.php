<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    /*
    |-----------------------------------
    | APPROVE PAYMENT
    |-----------------------------------
    */
    public function approve($id)
    {
        $payment = Payment::findOrFail($id);

        // update payment
        $payment->status = 'APPROVED';
        $payment->save();

        // update reservation
        $reservation = $payment->reservation;

        $reservation->status = 'CONFIRMED';
        $reservation->paid_at = now();

        // generate invoice kalau belum ada
        if (!$reservation->invoice_code) {
            $reservation->invoice_code = $this->generateInvoice();
        }

        $reservation->save();

        return redirect()->back()->with('success', 'Payment approved & reservation confirmed');
    }

    /*
    |-----------------------------------
    | REJECT PAYMENT
    |-----------------------------------
    */
    public function reject($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->status = 'REJECTED';
        $payment->save();

        // rollback reservation
        $reservation = $payment->reservation;
        $reservation->status = 'PENDING_PAYMENT';
        $reservation->save();

        return redirect()->back()->with('error', 'Payment rejected');
    }

    /*
    |-----------------------------------
    | GENERATE INVOICE
    |-----------------------------------
    */
    private function generateInvoice()
    {
        return 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
    }
}