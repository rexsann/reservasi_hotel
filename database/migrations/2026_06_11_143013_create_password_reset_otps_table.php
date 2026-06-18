<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_reset_otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('email');
            $table->string('otp_code'); // Kode OTP 6 digit
            $table->timestamp('expires_at'); // Waktu expired OTP
            $table->boolean('is_used')->default(false); // Apakah OTP sudah digunakan
            $table->timestamps(); // created_at & updated_at
            
            // Index untuk pencarian cepat
            $table->index('email');
            $table->index('otp_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_reset_otps');
    }
};