<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        // sementara dummy data biar sesuai login kamu
        $user = (object)[
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '08123456789'
        ];

        return view('profil', compact('user'));
    }
}