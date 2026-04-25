<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    // Tampilkan halaman reset password
    public function index()
    {
        // Cegah akses kalau belum verifikasi OTP
        if (!Session::has('email')) {
            return redirect('/forgot-password')->with('error', 'Akses tidak valid!');
        }

        return view('resetpassword');
    }

    // Proses reset password
    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $email = Session::get('email');

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect('/forgot-password')->with('error', 'User tidak ditemukan!');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus session setelah berhasil
        Session::forget(['otp', 'email']);

        return redirect('/login')->with('success', 'Password berhasil direset!');
    }
}