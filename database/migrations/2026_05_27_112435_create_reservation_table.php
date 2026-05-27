<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation', function (Blueprint $table) {

            $table->id();

            $table->string('reservation_code')->nullable()->unique();

            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            $table->foreignId('room_id')
                ->nullable()
                ->constrained('rooms')
                ->onDelete('cascade');

            $table->string('room_name');
            $table->string('room_type');

            $table->string('offer');

            $table->date('check_in');
            $table->date('check_out');

            $table->integer('guest_total')->default(1);

            $table->decimal('total_price', 12, 2);

            $table->string('payment_method')->nullable();

            $table->enum('payment_status', [
                'Pending',
                'Paid',
                'Failed',
                'Refund'
            ])->default('Pending');

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
public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};