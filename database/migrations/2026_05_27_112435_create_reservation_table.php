<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {

            $table->id();

            $table->string('reservation_code')->nullable()->unique();
            $table->string('invoice_code')->nullable()->unique();

            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            $table->foreignId('room_id')
                ->nullable()
                ->constrained('rooms')
                ->nullOnDelete();

            $table->string('room_name');
            $table->string('room_type');
 $table->string('offer')->nullable();

            $table->date('check_in');
            $table->date('check_out');

            $table->integer('guest_total')->default(1);

            $table->decimal('total_price', 12, 2);

            $table->enum('status', [
                'Pending Payment',
                'Waiting Verification',
                'Confirmed',
                'Checked In',
                'Checked Out',
                'Cancelled',
                'Expired'
            ])->default('Pending Payment');

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }
     public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};