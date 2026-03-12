<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($id)
    {
        $nama = "Agus";
        $alamat = "Bandung";
        $notelp = "08123456789";
        $jurusan = "Teknik Informatika";
        return view('dashboard', compact('id', 'nama', 'alamat', 'notelp', 'jurusan'));
    }
}
