<?php

// 📁 LOKASI: database/migrations/xxxx_add_room_type_id_to_rooms.php
// 💡 Buat dengan: php artisan make:migration add_room_type_id_to_rooms

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── STEP 1: Tambah kolom room_type_id (nullable dulu) ──
        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('room_type_id')->nullable()->after('type');
        });

        // ── STEP 2: Isi room_type_id dari matching kolom type ──
        // Ambil semua room_types lalu cocokkan dengan kolom type di rooms
        $roomTypes = DB::table('room_types')->get();

        foreach ($roomTypes as $rt) {
            DB::table('rooms')
                ->whereRaw('LOWER(TRIM(type)) = ?', [strtolower(trim($rt->name))])
                ->update(['room_type_id' => $rt->id]);
        }

        // ── STEP 3: Set NOT NULL + FK constraint ───────────────
        Schema::table('rooms', function (Blueprint $table) {
            // Ubah jadi NOT NULL setelah data sudah terisi
            $table->unsignedBigInteger('room_type_id')->nullable(false)->change();

            // Pasang foreign key
            $table->foreign('room_type_id')
                  ->references('id')
                  ->on('room_types')
                  ->onUpdate('cascade')   // kalau id room_type berubah, ikut berubah
                  ->onDelete('restrict'); // tidak bisa hapus tipe kalau masih ada kamar
        });

        // ── STEP 4: Hapus kolom type lama ──────────────────────
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }

    public function down(): void
    {
        // Balikkan semua perubahan kalau rollback

        // Tambah kembali kolom type
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('type')->nullable()->after('room_name');
        });

        // Isi ulang kolom type dari room_type_id
        $rooms = DB::table('rooms')->get();
        foreach ($rooms as $room) {
            $rt = DB::table('room_types')->find($room->room_type_id);
            if ($rt) {
                DB::table('rooms')
                    ->where('id', $room->id)
                    ->update(['type' => $rt->name]);
            }
        }

        // Hapus FK dan kolom room_type_id
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['room_type_id']);
            $table->dropColumn('room_type_id');
        });
    }
};