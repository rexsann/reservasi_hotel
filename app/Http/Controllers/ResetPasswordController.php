<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    // GET /resetpassword
    public function index()
    {
        if (!Session::has('verified_reset_email')) {
            return redirect()->route('lupapassword.form')
                ->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        return view('auth.resetpassword');
    }

    // POST /resetpassword (Route: resetpassword.post)
    public function update(ResetPasswordRequest $request)
    {
        // Validasi langsung (TANPA MIDDLEWARE)
        if (!Session::has('verified_reset_email')) {
            return redirect()->route('lupapassword.form')
                ->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        $email = Session::get('verified_reset_email');

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('lupapassword.form');
        }

        // Update password (di-hash untuk keamanan)
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Tandai semua OTP untuk email ini sebagai sudah digunakan
        PasswordResetOtp::where('email', $email)
            ->update(['is_used' => true]);

        // Hapus session yang sudah tidak perlu
        Session::forget([
            'reset_email',
            'verified_reset_email',
            'otp_sent_time'
        ]);

        return redirect('/login')
            ->with('success', 'Password berhasil diperbarui. Silakan login dengan password baru.');
    }
}