<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyOtpRequest;
use App\Models\PasswordResetOtp;
use Illuminate\Support\Facades\Session;

class CodeVerificationController extends Controller
{
    // GET /verification
    public function index()
    {
        if (!Session::has('reset_email')) {
            return redirect()->route('lupapassword.form');
        }

        return view('auth.codeverification');
    }

    // POST /verification (Route: verification.post)
    public function verify(VerifyOtpRequest $request)
    {
        $email = Session::get('reset_email');
        $inputOtp = $request->otp;

        // Cari OTP terbaru berdasarkan email
        $otp = PasswordResetOtp::where('email', $email)
            ->where('otp_code', $inputOtp)
            ->latest()
            ->first();

        // OTP tidak ditemukan
        if (!$otp) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak valid.'
            ]);
        }

        // OTP sudah digunakan sebelumnya
        if ($otp->is_used) {
            return back()->withErrors([
                'otp' => 'Kode OTP sudah digunakan.'
            ]);
        }

        // OTP kadaluarsa
        if ($otp->isExpired()) {
            return back()->withErrors([
                'otp' => 'Kode OTP telah kadaluarsa.'
            ]);
        }

        // OTP valid! Tandai sebagai sudah digunakan
        $otp->update(['is_used' => true]);

        // Simpan ke session bahwa email sudah terverifikasi
        Session::put('verified_reset_email', $email);

        return redirect()->route('resetpassword')
            ->with('success', 'OTP berhasil diverifikasi.');
    }
}