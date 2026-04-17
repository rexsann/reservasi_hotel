<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function check(Request $request)
    {
        // Validasi input
        $request->validate([
            'code' => 'required',
            'email' => 'required|email'
        ]);

        $code = $request->code;
        $email = $request->email;

        // Contoh sementara (belum pakai database)
        return "Kode: $code | Email: $email";
    }
}
