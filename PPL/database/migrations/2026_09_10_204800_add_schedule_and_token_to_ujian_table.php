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
        Schema::table('ujian', function (Blueprint $table) {
            $table->dateTime('waktu_mulai')->nullable()->after('tanggal_dibuat');
            $table->dateTime('waktu_selesai')->nullable()->after('waktu_mulai');
            $table->integer('durasi_menit')->default(60)->after('waktu_selesai');
            $table->string('token', 10)->nullable()->after('durasi_menit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujian', function (Blueprint $table) {
            $table->dropColumn(['waktu_mulai', 'waktu_selesai', 'durasi_menit', 'token']);
        });
    }
};
