<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // simpan session tambahan kalau masih dipakai di tempat lain
            Session::put('user_id',   $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_role', $user->role);

            if ($user->role === 'admin') {
                return redirect('/admin/dashboard')
                    ->with('success', 'Selamat datang Admin!');
            }

            return redirect('/home')
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Berhasil logout!');
    }
}