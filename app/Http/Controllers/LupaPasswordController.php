<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOtpRequest;
use App\Mail\ResetPasswordOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class LupaPasswordController extends Controller
{
    // GET /lupapassword
    public function index()
    {
        return view('auth.lupapassword');
    }

    // POST /lupapassword (Route: lupapassword)
    public function sendOtp(SendOtpRequest $request)
    {
        $email = $request->email;

        // Cek berapa banyak OTP yang dikirim dalam 1 jam terakhir
        $otpCount = PasswordResetOtp::where('email', $email)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        // Limit 5 OTP per jam
        if ($otpCount >= 5) {
            return back()->withErrors([
                'email' => 'Anda sudah mencapai batas maksimal pengiriman OTP. Coba lagi dalam 1 jam.'
            ]);
        }

        // Generate OTP random 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Tandai OTP lama sebagai sudah dipakai
        PasswordResetOtp::where('email', $email)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Cari user
        $user = User::where('email', $email)->first();

        // Simpan OTP baru ke database
        PasswordResetOtp::create([
            'user_id' => $user->id,
            'email' => $email,
            'otp_code' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
            'is_used' => false
        ]);

        // Kirim email
        Mail::to($email)->send(new ResetPasswordOtpMail($otp));

        // Simpan email di session
        Session::put('reset_email', $email);
        Session::put('otp_sent_time', now());

        return redirect()->route('verification')
            ->with('success', 'OTP telah dikirim ke email Anda.');
    }

    // Resend OTP
    public function resendOtp()
    {
        $email = Session::get('reset_email');

        if (!$email) {
            return redirect()->route('lupapassword.form')
                ->with('error', 'Email tidak ditemukan.');
        }

        // Cek cooldown resend 60 detik
        $lastSentTime = Session::get('otp_sent_time');
        $timeElapsed = now()->diffInSeconds($lastSentTime);

        if ($timeElapsed < 60) {
            return back()->with('error', 'Tunggu ' . (60 - $timeElapsed) . ' detik sebelum resend OTP.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('lupapassword.form');
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::where('email', $email)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        PasswordResetOtp::create([
            'user_id' => $user->id,
            'email' => $email,
            'otp_code' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
            'is_used' => false
        ]);

        Mail::to($email)->send(new ResetPasswordOtpMail($otp));

        Session::put('otp_sent_time', now());

        return back()->with('success', 'OTP baru telah dikirim ke email Anda.');
    }
}