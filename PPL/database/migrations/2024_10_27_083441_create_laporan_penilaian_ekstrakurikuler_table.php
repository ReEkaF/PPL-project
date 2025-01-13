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
        Schema::disableForeignKeyConstraints();

        Schema::create('laporan_penilaian_ekstrakurikuler', function (Blueprint $table) {
            $table->uuid('id_laporan')->primary();
            $table->uuid('id_siswa');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa');
            $table->uuid('id_ekstrakurikuler');
            $table->foreign('id_ekstrakurikuler')->references('id_ekstrakurikuler')->on('ekstrakurikuler');
            $table->text('isi_laporan');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_penilaian_ekstrakurikuler');
    }
};
