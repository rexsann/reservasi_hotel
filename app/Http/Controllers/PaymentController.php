<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Step 1 – Tampilkan form isi data
    public function fillData()
    {
        return view('booking.fill-data');
    }

    // Step 1 – Submit form → ke halaman payment
    public function index()
    {
        return redirect()->route('payment.show');
    }

    // Step 2 – Tampilkan halaman payment
    public function showPayment()
    {
        return view('payment');
    }

    // Step 2 – Tombol Order → ke confirmation
    public function order()
    {
        return redirect()->route('payment.confirmation');
    }

    // Step 2 – Tombol Cancel → ke home
    public function cancel()
    {
        return redirect()->route('home');
    }

    // Step 3 – Tampilkan halaman confirmation
    public function confirmation()
{
    $status = session('status', 'pending'); // default pending
    return view('confirmation', compact('status'));
}

public function checkStatus()
{
    // simulasi status berubah jadi confirmed
    return redirect()->route('payment.confirmation')->with('status', 'confirmed');
}
}