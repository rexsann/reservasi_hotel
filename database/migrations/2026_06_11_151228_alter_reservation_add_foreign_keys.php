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
    Schema::table('reservation', function (Blueprint $table) {

        $table->unsignedBigInteger('room_type_id')->nullable()->after('room_id');
        $table->unsignedBigInteger('offer_id')->nullable()->after('room_type_id');

        $table->foreign('room_type_id')
              ->references('id')
              ->on('room_types')
              ->onDelete('set null');

        $table->foreign('offer_id')
              ->references('id')
              ->on('offers')
              ->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
