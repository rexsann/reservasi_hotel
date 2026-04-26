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
        Session::put('user_id', null);
        return view('login');
    }

    // ini proses login
    public function authenticate(Request $request)
    {
        // ini validasi inputan
        $request->validate([
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.required'     => 'The email field is required.',
            'email.email'        => 'The email must be a valid email address.',
            'password.required'  => 'The password field is required.',
            'password.min'       => 'The password must be at least 6 characters.',
        ]);

        // ini untuk mencari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // ini untuk mengecek user + password (WAJIB pakai Hash::check)
        if ($user && Hash::check($request->password, $user->password)) {

            // ini buat simpan session
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_role', $user->role);

            // redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard')->with('success', 'Selamat datang Admin!');
            }

            // redirect ke home
            return redirect('/home')->with('success', 'success!');
        }

        // kalau gagal
        return back()->withErrors([
            'email' => 'The email or password is incorrect.'
        ])->withInput();
    }

    // logout
    public function logout()
    {
        Session::flush(); // hapus semua session
        return redirect('/login')->with('success', 'Berhasil logout!');
    }
}
