<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // kalau user ditemukan & password cocok
        if ($user && $user->password === $request->password) {

            // simpan session login
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);

            return redirect('/home')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Email atau password salah!');
    }
}