<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Offer;
use App\Models\Facility;
use App\Models\Reservation;
use App\Models\RoomType;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $checkIn  = $request->check_in;
        $checkOut = $request->check_out;

        $bookedTypes = [];

        if ($checkIn && $checkOut) {
            $bookedTypes = Reservation::whereIn('status', ['confirmed', 'pending'])
                ->where(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<', $checkOut)
                      ->where('check_out', '>', $checkIn);
                })
                ->pluck('room_type_id')
                ->toArray();
        }

        $offers     = Offer::with('roomType')->get();
        $facilities = Facility::all();
        $types      = RoomType::orderBy('name')->get();

        return view(
            'pages.home',
            compact(
                'offers',
                'facilities',
                'bookedTypes',
                'checkIn',
                'checkOut',
                'types'
            )
        );
    }
}