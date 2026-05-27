<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();

        foreach ($users as $user)
        {
            $user->total_reservations =
                Reservation::where('email', $user->email)->count();
        }

        return view('admin.user_management', compact('users'));
    }
}