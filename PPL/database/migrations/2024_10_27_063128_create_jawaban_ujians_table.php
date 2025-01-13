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
        Schema::create('jawaban_ujian', function (Blueprint $table) {
            $table->uuid('id_jawaban_ujian')->primary();
            $table->uuid('pengumpulan_ujian_id');
            $table->uuid('soal_id');
            $table->string('jawaban_dipilih');
            $table->timestamps();
            $table->foreign('pengumpulan_ujian_id')->references('id_pengumpulan_ujian')->on('pengumpulan_ujian');
            $table->foreign('soal_id')->references('id_soal_ujian')->on('soal_ujian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_ujian');
    }
};
