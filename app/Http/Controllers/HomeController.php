<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        // data dummy (nanti bisa dari database)
        $rooms = [
            [
                'name' => 'Deluxe Room',
                'desc' => 'Nyaman dan elegan',
                'image' => 'https://source.unsplash.com/400x300/?hotel-room'
            ],
            [
                'name' => 'Executive Room',
                'desc' => 'Lebih luas dan mewah',
                'image' => 'https://source.unsplash.com/400x300/?luxury-hotel'
            ],
            [
                'name' => 'Suite Room',
                'desc' => 'Fasilitas premium',
                'image' => 'https://source.unsplash.com/400x300/?suite-hotel'
            ]
        ];

        return view('home', compact('rooms'));
    }
}

