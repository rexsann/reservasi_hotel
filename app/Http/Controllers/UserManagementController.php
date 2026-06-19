<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
class UserManagementController extends Controller
{
   public function index(Request $request)
{
    $search = $request->search;

    $users = User::query()

        ->when($search, function ($query) use ($search) {

            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
                  

        })

        ->withCount('reservations')
        ->latest()
        ->get();

    return view('admin.user_management', compact('users'));
}
}