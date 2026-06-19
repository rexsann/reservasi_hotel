<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {

            $table->foreignId('offer_id')
                  ->nullable()
                  ->after('room_type_id')
                  ->constrained('offers')
                  ->nullOnDelete();

            $table->dropColumn('price_per_night');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {

            $table->dropForeign(['offer_id']);
            $table->dropColumn('offer_id');

            $table->decimal('price_per_night', 12, 2)
                  ->after('room_type_id');
        });
    }
};
