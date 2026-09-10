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
        Schema::create('ujian', function (Blueprint $table) {
            $table->uuid('id_ujian')->primary();
            $table->string('judul');
            $table->string('jenis_ujian');
            $table->string('deskripsi');
            $table->uuid('topik_id');
            $table->uuid('kelas_mata_pelajaran_id');
            $table->date('tanggal_dibuat');
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->integer('durasi_menit')->default(60);
            $table->string('token', 10)->nullable();
            $table->timestamps();
            $table->foreign('topik_id')->references('id_topik')->on('topik');
            $table->foreign('kelas_mata_pelajaran_id')->references('id_kelas_mata_pelajaran')->on('kelas_mata_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian');
    }
};
