<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // ini untuk mengambil halaman login
    public function index()
    {
        return view('login');
    }

    // ini proses login
    public function authenticate(Request $request)
    {
        // ini validasi inputan
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // ini untuk mencari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // ini untuk mengecek user + password (WAJIB pakai Hash::check)
        if ($user && Hash::check($request->password, $user->password)) {

            // ini buat simpan session
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