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

    public function index()
    {
        // dummy data (nanti ganti dari database)
        $reservasi = [
            [
                'id' => 1,
                'kode' => 'RES-240501-001',
                'kamar' => 'Deluxe Room - 101',
                'tanggal' => '01 Mei 2024 - 03 Mei 2024',
                'total' => 2475000,
                'status' => 'pending'
            ],
            [
                'id' => 2,
                'kode' => 'RES-240430-002',
                'kamar' => 'Superior Room - 202',
                'tanggal' => '28 April 2024 - 30 April 2024',
                'total' => 1800000,
                'status' => 'success'
            ],
            [
                'id' => 3,
                'kode' => 'RES-240420-003',
                'kamar' => 'Standard Room - 303',
                'tanggal' => '20 April 2024 - 21 April 2024',
                'total' => 750000,
                'status' => 'rejected'
            ],
        ];

        return view('pages.riwayat', compact('reservasi'));
    }

    // 🔥 HALAMAN HASIL CEK BOOKING (TANPA DATABASE)
public function cek_reservasi(Request $request)
{
    $code = $request->code;
    $email = $request->email;

    // dummy data (sementara)
    $data = [
        'kode' => $code,
        'email' => $email,
        'nama' => 'Budi Santoso',
        'kamar' => 'Deluxe Room - 101',
        'tanggal' => '01 Mei 2024 - 03 Mei 2024',
        'durasi' => '2 Malam',
        'status' => 'confirmed'
    ];

    return view('pages.cek_reservasi', compact('data'));
}
    // 🔥 HALAMAN PEMBAYARAN
    public function pembayaran($id)
    {
        // dummy data
        $data = [
            'id' => $id,
            'kode' => 'RES-240501-001',
            'total' => 2475000,
            'status' => 'pending'
        ];

        return view('pages.pembayaran', compact('data'));
    }

    // 🔥 CEK STATUS (UNTUK AJAX / FETCH)
    public function cekStatus($id)
    {
        // simulasi (nanti dari database)
        return response()->json([
            'status' => 'success' // pending / success / rejected
        ]);
    }
}
