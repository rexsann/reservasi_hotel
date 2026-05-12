<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function index()
    {
        if (!Session::has('email')) {
            return redirect('/forgot-password')->with('error', 'Akses tidak valid!');
        }

        return view('auth.resetpassword');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $email = Session::get('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect('/forgot-password')->with('error', 'User tidak ditemukan!');
        }

        $user->password = Hash::make($request->password);
        $user->save();


        Session::forget(['otp', 'email']);

        return redirect('/login')->with('success', 'Password berhasil direset!');
    }
}