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

        // Ambil semua rows dalam group (multi-room support)
        $rooms = Reservation::with(['roomType', 'offer'])
            ->where('reservation_code', $code)
            ->where('email', $email)
            ->get();

        if ($rooms->isEmpty()) {
            return redirect()->back()->with('error', 'Reservasi tidak ditemukan.');
        }

        // Data utama dari row pertama
        $data = $rooms->first();
        $data->rooms_detail = $rooms; // semua kamar dalam group

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

    public function invoice(Request $request)
{
    $code  = $request->query('code');
    $email = $request->query('email');

    $rooms = Reservation::with(['roomType', 'offer'])
        ->where('reservation_code', $code)
        ->where('email', $email)
        ->get();

    if ($rooms->isEmpty()) {
        abort(404);
    }

    $data = $rooms->first();
    $data->rooms_detail = $rooms;

    return view('pages.invoice', compact('data'));
}
}