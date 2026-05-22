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
        return view('auth.login');
    }

    // ini proses login
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_role', $user->role);

            // redirect admin
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard')
                    ->with('success', 'Selamat datang Admin!');
            }

            // redirect user
            return redirect('/home')
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->withInput();
    }

    // logout
    public function logout()
    {
        Session::flush(); // hapus semua session
        return redirect('/login')->with('success', 'Berhasil logout!');
    }
}
