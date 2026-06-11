<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'room_type_id',
        'name'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}