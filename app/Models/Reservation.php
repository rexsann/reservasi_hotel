<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservation';

    protected $fillable = [

        'guest_name',
        'email',

        'room_name',
        'room_type',
        'offer',

        'check_in',
        'check_out',

        'total_nights',

        'total_price',

        'status'
    ];
}