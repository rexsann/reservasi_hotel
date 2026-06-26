<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // ✅ Ambil reservasi milik user yang login, terbaru dulu
        $reservasi = Reservation::where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('pages.history', compact('reservasi'));
    }
}
