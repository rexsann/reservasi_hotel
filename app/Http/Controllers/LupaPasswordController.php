<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LupaPasswordController extends Controller
{
    // Tampilkan halaman lupa password
    public function index()
    {
        return view('auth.lupapassword');
    }

    // Proses kirim OTP
    public function sendOtp(Request $request)
    {
        // Validasi email
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email tidak terdaftar.',
            'email.exists'   => 'Email tidak ditemukan.',
        ]);

        $email = $request->email;

        // Simpan ke session
        Session::put('email', $email);

        // Simulasi kirim email (sementara)
        // Nanti bisa pakai Mail Laravel

        return redirect()->route('verification')
            ->with('success', "Kode OTP dikirim ke $email");
    }
}