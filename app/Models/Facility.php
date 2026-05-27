<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class Facility extends Model
{
    protected $fillable = [
    'room_type',
    'name'
];

   
}