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
        Schema::create('kelas_siswas', function (Blueprint $table) {
            $table->uuid('id_kelas_siswa')->primary();
            $table->uuid('id_kelas');
            $table->uuid('id_siswa');
            $table->uuid('tahun_ajaran');
            $table->uuid('wali_kelas')->nullable(); // Menambahkan kolom wali_kelas
            $table->foreign('wali_kelas')->references('id_guru')->on('guru')->onDelete('set null');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa');
            $table->foreign('tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_siswas');
    }
};
