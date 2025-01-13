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

        Schema::create('registrasi_ekstrakurikuler', function (Blueprint $table) {
            $table->uuid('id_registrasi')->primary();
            $table->uuid('id_siswa');
            $table->uuid('id_ekstrakurikuler');
            $table->string('riwayat_penyakit')->nullable();
            $table->text('alasan')->nullable();
            $table->char('no_ortu')->nullable();
            $table->enum('status', ["diterima","ditolak","menunggu"])->nullable();
            $table->timestamp('tgl_registrasi')->useCurrent();
            $table->foreign('id_ekstrakurikuler')->references('id_ekstrakurikuler')->on('ekstrakurikuler');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_ekstrakurikuler');
    }
};
