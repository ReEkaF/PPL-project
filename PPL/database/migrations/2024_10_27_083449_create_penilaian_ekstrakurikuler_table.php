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

        Schema::create('penilaian_ekstrakurikuler', function (Blueprint $table) {
            $table->uuid('id_penilaian_ekstrakurikuler')->primary();
            $table->uuid('id_ekstrakurikuler');
            $table->foreign('id_ekstrakurikuler')->references('id_ekstrakurikuler')->on('ekstrakurikuler');
            $table->uuid('id_siswa');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa');
            $table->uuid('id_tahun_ajaran');
            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran');
            $table->uuid('id_laporan');
            $table->foreign('id_laporan')->references('id_laporan')->on('laporan_penilaian_ekstrakurikuler');
            $table->enum('penilaian', ["A", "B", "C", "D", "E"]);
            $table->timestamp('tgl_penilaian')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_ekstrakurikuler');
    }
};
