<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CodeVerificationController extends Controller
{
    // Menampilkan halaman verifikasi
    public function index()
    {
        Session::put('otp', '123456');
        return view('codeverification');
    }

    // Proses verifikasi OTP
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits'   => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        $inputOtp = $request->otp;
        $sessionOtp = Session::get('otp');

        if ($inputOtp == $sessionOtp) {
            return redirect()->route('resetpassword');
        }

        return back()->with('error', 'Kode OTP salah!');
    }
}