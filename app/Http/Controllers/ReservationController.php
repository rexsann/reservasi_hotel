<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    // Cek booking berdasarkan kode & email
    public function check(Request $request)
    {
        $request->validate([
            'code'  => 'required',
            'email' => 'required|email'
        ]);

        return redirect()->route('reservation.cek', [
            'code'  => $request->code,
            'email' => $request->email,
        ]);
    }

    // Halaman riwayat reservasi
    public function index()
    {
        $reservasi = Reservation::latest()->get();

        return view('pages.riwayat', compact('reservasi'));
    }

    // Halaman hasil cek booking
    public function cek_reservasi(Request $request)
    {
        $code  = $request->query('code');
        $email = $request->query('email');

        $data = Reservation::where('reservation_code', $code)
                            ->where('email', $email)
                            ->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Reservasi tidak ditemukan.');
        }

        return view('pages.cek_reservasi', compact('data'));
    }

    // Halaman pembayaran
    public function pembayaran($id)
    {
        $data = Reservation::findOrFail($id);

        return view('pages.pembayaran', compact('data'));
    }

    // Cek status reservasi (untuk AJAX)
    public function cekStatus($id)
    {
        $data = Reservation::findOrFail($id);

        return response()->json([
            'status' => $data->status
        ]);
    }
}