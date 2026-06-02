<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Payment::with('reservation')
            ->latest()
            ->get();

        return view('admin.pembayaran', compact('pembayaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();

        if ($request->status === 'Paid') {
            $payment->reservation->update(['status' => 'Confirmed']);

            // Kirim invoice ke email guest
            Mail::to($payment->reservation->email)
                ->send(new InvoiceMail($payment));

        } elseif ($request->status === 'Rejected') {
            $payment->reservation->update(['status' => 'Pending Payment']);
        }

        return response()->json(['message' => 'Status updated']);
    }
}