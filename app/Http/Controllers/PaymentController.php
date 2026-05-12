<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function fillData()
    {
        return view('booking.fill-data');
    }

    public function index()
    {
        return redirect()->route('payment.show');
    }

    public function showPayment()
    {
        return view('booking.payment');
    }

    public function order()
    {
        return redirect()->route('payment.confirmation');
    }

    public function cancel()
    {
        return redirect()->route('home');
    }

    public function confirmation()
{
    $status = session('status', 'pending');
    return view('booking.confirmation', compact('status'));
}

public function checkStatus()
{
    //simulasi
    return redirect()->route('payment.confirmation')->with('status', 'confirmed');
}
}