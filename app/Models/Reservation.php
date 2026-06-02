<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservation';

    protected $fillable = [
    'reservation_code',
    'invoice_code',
    'name',
    'email',
    'room_id',
    'room_name',
    'room_type',
    'offer',
    'check_in',
    'check_out',
    'guest_total',
    'total_price',
    'status',
    'paid_at',
    'checked_in_at',
    'checked_out_at',
    'cancelled_at',
];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->reservation_code = 'RES-' . strtoupper(uniqid());
        });
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}
}