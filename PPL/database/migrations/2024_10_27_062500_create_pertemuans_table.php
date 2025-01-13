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
        Schema::create('pertemuan', function (Blueprint $table) {
            $table->uuid('id_pertemuan')->primary();
            $table->uuid('kelas_mata_pelajaran_id');
            $table->date('tanggal_pertemuan');
            $table->string('qr_code');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Tidak Aktif');
            $table->timestamps();
            $table->foreign('kelas_mata_pelajaran_id')->references('id_kelas_mata_pelajaran')->on('kelas_mata_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan');
    }
};
