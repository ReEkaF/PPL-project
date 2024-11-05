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
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa');
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