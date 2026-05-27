<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservation', function (Blueprint $table) {

    $table->id();

    // kode reservasi
    $table->string('reservation_code')->unique();

    // data tamu
    $table->string('name');
    $table->string('email');
    $table->string('phone');

    // kamar
    $table->foreignId('room_id')
        ->constrained('rooms')
        ->onDelete('cascade');

    $table->string('room_name');
    $table->string('room_type');

    // offer yang dipilih
    $table->string('offer');

    // tanggal inap
    $table->date('check_in');
    $table->date('check_out');

    // jumlah tamu
    $table->integer('guest_total')->default(1);

    // pembayaran
    $table->decimal('total_price', 12, 2);

    // metode pembayaran
    $table->string('payment_method')->nullable();

    // status pembayaran
    $table->enum('payment_status', [
        'Pending',
        'Paid',
        'Failed',
        'Refund'
    ])->default('Pending');

    // status reservasi hotel
    $table->enum('status', [
        'Pending',
        'Confirmed',
        'Checked In',
        'Checked Out',
        'Cancelled'
    ])->default('Pending');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};
