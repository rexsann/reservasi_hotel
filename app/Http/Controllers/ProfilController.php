<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfilController extends Controller
{
    public function index()
    {
        // ambil user dari session login
        $user = User::find(session('user_id'));

        return view('pages.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $user = User::find(session('user_id'));

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        // update session juga
        session([
            'user_name' => $user->name
        ]);

        return back()->with('success', 'Profile berhasil diupdate');
    }
}