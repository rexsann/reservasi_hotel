<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    // Field yang boleh diisi langsung (mass assignment)
    protected $fillable = [
        'user_id',
        'email',
        'otp_code',
        'expires_at',
        'is_used'
    ];

    // Cast tipe data
    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method helper: cek apakah OTP sudah kadaluarsa
    public function isExpired()
    {
        return now() > $this->expires_at;
    }

    // Method helper: cek apakah OTP masih valid
    public function isValid()
    {
        return !$this->is_used && !$this->isExpired();
    }
}