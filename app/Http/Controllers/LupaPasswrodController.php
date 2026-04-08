<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LupaPasswrodController extends Controller
{
    public function index()
    {
        return view('lupapassword');
    }

    public function resetPassword(Request $request)
    {
        $nohp = $request->nohp;
        
        return back()->with('success', 'Link reset password telah dikirim ke nomor HP Anda.');
    }
}
