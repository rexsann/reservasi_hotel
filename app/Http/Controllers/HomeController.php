<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = [
            [
                'name' => 'Superior Twin',
                'image' => 'https://source.unsplash.com/600x400/?hotel-room',
                'bed' => '2 beds',
                'guest' => '2 guests',
                'amenities' => ['Free WiFi', 'AC', 'Mini Fridge', 'TV'],
                'prices' => [
                    [
                        'title' => 'MyValue Offer',
                        'features' => ['Breakfast', 'Online Payment', 'Non-refundable'],
                        'old_price' => 1100000,
                        'price' => 950000,
                        'highlight' => true
                    ],
                    [
                        'title' => 'Regular Offer',
                        'features' => ['Breakfast', 'Free Cancel'],
                        'price' => 1100000
                    ],
                    [
                        'title' => 'Promo Hemat',
                        'features' => ['No Breakfast', 'Non-refundable'],
                        'price' => 850000
                    ],
                    [
                        'title' => 'Flexible Stay',
                        'features' => ['Breakfast', 'Free Cancel Anytime'],
                        'price' => 1250000
                    ],
                ]
            ],

            [
                'name' => 'Superior Hollywood',
                'image' => 'https://source.unsplash.com/600x400/?hotel-bedroom',
                'bed' => '1 king bed',
                'guest' => '2 guests',
                'amenities' => ['Free WiFi', 'AC', 'Smart TV', 'Mini Bar'],
                'prices' => [
                    [
                        'title' => 'Special Offer',
                        'features' => ['Breakfast', 'Free Cancel'],
                        'price' => 1250000
                    ]
                ]
            ],

            [
                'name' => 'Deluxe Room',
                'image' => 'https://source.unsplash.com/600x400/?luxury-room',
                'bed' => 'King bed',
                'guest' => '2 guests',
                'amenities' => ['Free WiFi', 'Bathtub', 'AC', 'Mini Bar'],
                'prices' => [
                    [
                        'title' => 'Deluxe Offer',
                        'features' => ['Breakfast', 'Free Cancel'],
                        'price' => 1500000
                    ]
                ]
            ],
        ];

        return view('/pages/home', compact('rooms'));
    }
}
