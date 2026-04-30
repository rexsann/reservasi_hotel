<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // 🔥 HALAMAN ADMIN PEMBAYARAN
    public function index()
    {
        $pembayaran = [
            [
                'id' => 1,
                'kode' => 'PAY-001',
                'nama' => 'Budi Santoso',
                'total' => 2475000,
                'status' => 'pending',
                'bukti' => 'https://via.placeholder.com/400'
            ],
            [
                'id' => 2,
                'kode' => 'PAY-002',
                'nama' => 'Andi Wijaya',
                'total' => 1800000,
                'status' => 'success',
                'bukti' => 'https://via.placeholder.com/400'
            ],
        ];

        return view('admin.pembayaran', compact('pembayaran'));
    }

    // 🔥 UPDATE STATUS
    public function updateStatus(Request $request, $id)
    {
        $status = $request->status;

        // nanti sambung DB di sini

        return response()->json([
            'message' => 'Status berhasil diupdate',
            'status' => $status
        ]);
    }
}