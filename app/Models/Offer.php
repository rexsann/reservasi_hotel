<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'name',
        'room_type_id',
        'price',
        'benefits'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}