<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'room_name',
        'room_type_id',
        'offer_id',
        'status',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}