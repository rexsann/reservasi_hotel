<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // tampilkan halaman login
    public function index()
    {
        return view('login');
    }

    // proses login
    public function authenticate(Request $request)
    {
        // validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // cek user + password (WAJIB pakai Hash::check)
        if ($user && Hash::check($request->password, $user->password)) {

            // simpan session
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);

            // redirect ke home
            return redirect('/home')->with('success', 'Login berhasil!');
        }

        // kalau gagal
        return back()->with('error', 'Email atau password salah!');
    }

    // logout
    public function logout()
    {
        Session::flush(); // hapus semua session
        return redirect('/login')->with('success', 'Berhasil logout!');
    }
}