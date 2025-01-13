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
        Schema::create('absensi_siswa', function (Blueprint $table) {
            $table->uuid('id_absensi_siswa')->primary();
            $table->uuid('siswa_id');
            $table->uuid('pertemuan_id');
            $table->enum('status_absensi', ['Hadir', 'Izin', 'Sakit', 'Alpa']);
            $table->timestamps();
            $table->foreign('siswa_id')->references('id_siswa')->on('siswa');
            $table->foreign('pertemuan_id')->references('id_pertemuan')->on('pertemuan');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_siswa');
    }
};
