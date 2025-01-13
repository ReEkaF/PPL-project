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
        Schema::create('notifikasi_tugas', function (Blueprint $table) {
            $table->uuid('id_notifikasi_tugas')->primary();
            $table->uuid('tugas_id');
            $table->uuid('siswa_id');
            $table->timestamps();

            $table->foreign('tugas_id')->references('id_tugas')->on('tugas')->cascadeOnDelete();
            $table->foreign('siswa_id')->references('id_siswa')->on('siswa')->cascadeOnDelete();
            $table->unique(['tugas_id', 'siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi_tugas');
    }
};
