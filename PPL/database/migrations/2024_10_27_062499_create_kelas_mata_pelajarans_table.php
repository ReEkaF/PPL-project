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
        Schema::create('kelas_mata_pelajaran', function (Blueprint $table) {
            $table->uuid('id_kelas_mata_pelajaran')->primary();
            $table->uuid('kelas_id');
            $table->uuid('mata_pelajaran_id');
            $table->uuid('guru_id');
            $table->uuid('hari_id')->nullable();
            $table->string('waktu_mulai')->nullable();
            $table->string('waktu_selesai')->nullable();
            $table->uuid('tahun_ajaran_id');
            $table->timestamps();
            $table->foreign('kelas_id')->references('id_kelas')->on('kelas');
            $table->foreign('mata_pelajaran_id')->references('id_matpel')->on('mata_pelajaran');
            $table->foreign('guru_id')->references('id_guru')->on('guru');
            $table->foreign('tahun_ajaran_id')->references('id_tahun_ajaran')->on('tahun_ajaran');
            $table->foreign('hari_id')->references('id_hari')->on('hari');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_mata_pelajaran');
    }
};
