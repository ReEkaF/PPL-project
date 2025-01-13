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
        Schema::create('pengumpulan_ujian', function (Blueprint $table) {
            $table->uuid('id_pengumpulan_ujian')->primary();
            $table->uuid('ujian_id');
            $table->uuid('siswa_id');
            $table->string('tanggal_pengumpulan');
            $table->string('nilai');
            $table->timestamps();
            $table->foreign('ujian_id')->references('id_ujian')->on('ujian');
            $table->foreign('siswa_id')->references('id_siswa')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_ujians');
    }
};
