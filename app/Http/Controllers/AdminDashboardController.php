<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $totalReservations = Reservation::count();
        $customers = User::count();
        $revenue = Reservation::sum('total_price');

        $latestReservations = Reservation::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'totalReservations',
            'customers',
            'revenue',
            'latestReservations'
        ));
    }
}