<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('reservation', function (Blueprint $table) {
        $table->dropUnique('reservation_reservation_code_unique');
    });
}

public function down()
{
    Schema::table('reservation', function (Blueprint $table) {
        $table->unique('reservation_code');
    });
}
};
