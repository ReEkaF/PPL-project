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
        Schema::create('rapor', function (Blueprint $table) {
            $table->uuid('id_rapor')->primary();
            $table->uuid('siswa_id');
            $table->uuid('tahun_ajaran_id');
            $table->timestamps();
            $table->foreign('siswa_id')->references('id_siswa')->on('siswa');
            $table->foreign('tahun_ajaran_id')->references('id_tahun_ajaran')->on('tahun_ajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapor');
    }
};
