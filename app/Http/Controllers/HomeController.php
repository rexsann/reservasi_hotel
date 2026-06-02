<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Offer;
use App\Models\Facility;
use App\Models\Reservation;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $checkIn  = $request->check_in;
        $checkOut = $request->check_out;

        // Cari room_type yang sudah terisi di rentang tanggal
        $bookedTypes = [];

        if ($checkIn && $checkOut) {
            $bookedTypes = Reservation::whereIn('status', ['confirmed', 'pending'])
                ->where(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
                })
                ->pluck('room_type')
                ->toArray();
        }

        $offers     = Offer::all();
        $facilities = Facility::all();
        $types = Offer::distinct()->pluck('room_type'); // ambil dari DB

        return view('pages.home', compact('offers', 'facilities', 'bookedTypes', 'checkIn', 'checkOut', 'types'));
    }
}
