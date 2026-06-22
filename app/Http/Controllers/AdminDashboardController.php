<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ======================
        // ROOM STATS
        // ======================

        $totalRooms = Room::count();

        $availableRooms = Room::where('status', 'Available')->count();

        $occupiedRooms = Room::where('status', 'Occupied')->count();

        $maintenanceRooms = Room::where('status', 'Maintenance')->count();

        // ======================
        // RESERVATION STATS
        // ======================

        $activeReservations = Reservation::whereIn('status', [
            'Pending',
            'Confirmed',
            'Checked In'
        ])->count();

        $confirmedReservations = Reservation::where('status', 'Confirmed')->count();

        $pendingReservations = Reservation::where('status', 'Pending')->count();

        // ======================
        // TOTAL INCOME
        // ====================== 

        // Sesudah ✅
        $income = Reservation::whereIn('status', [
            'Confirmed',
            'Checked In',
            'Checked Out'
        ])->sum('total_price');

        $cancelledReservations = Reservation::where('status', 'Cancelled')->count();

        // ======================
        // LATEST RESERVATION
        // ======================

        $latestReservations = Reservation::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',

            'activeReservations',
            'confirmedReservations',
            'pendingReservations',

            'income',
            'cancelledReservations',

            'latestReservations'
        ));
    }
}
