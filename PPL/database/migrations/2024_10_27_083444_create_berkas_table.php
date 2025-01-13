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
        Schema::disableForeignKeyConstraints();

        Schema::create('berkas', function (Blueprint $table) {
            $table->uuid('id_berkas')->primary();
            $table->uuid('id_registrasi');
            $table->foreign('id_registrasi')->references('id_registrasi')->on('registrasi_ekstrakurikuler');
            $table->string('surat_izin_ortu');
            $table->string('surat_riwayat_penyakit');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
