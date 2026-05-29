<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'payments'; // tetap pakai tabel payments

    protected $fillable = [
        'reservation_id',
        'kode',
        'total',
        'status',
        'bukti',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pembayaran) {

            $date = now()->format('ymd');

            $last = self::whereDate('created_at', now()->toDateString())
                ->orderBy('id', 'desc')
                ->first();

            $next = $last ? ((int) substr($last->kode, -3)) + 1 : 1;

            $pembayaran->kode = 'PAY-' . $date . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);
        });
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}