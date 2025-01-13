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
        Schema::create('prestasi', function (Blueprint $table) {
            $table->uuid('id_prestasi')->primary();
            $table->uuid('siswa_id');
            $table->string('nama_prestasi');
            $table->string('bukti_prestasi');
            $table->string('deskripsi_prestasi');
            $table->boolean('status_prestasi');
            $table->timestamps();
            $table->foreign('siswa_id')->references('id_siswa')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
