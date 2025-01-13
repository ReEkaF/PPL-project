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
        Schema::create('tugas', function (Blueprint $table) {
            $table->uuid('id_tugas')->primary();
            $table->string('judul');
            $table->text('deskripsi');
            $table->uuid('topik_id')->nullable();
            $table->dateTime('deadline');
            $table->uuid('kelas_mata_pelajaran_id');
            $table->timestamps();
            $table->foreign('topik_id')->references('id_topik')->on('topik')->onDelete('set null');
            $table->foreign('kelas_mata_pelajaran_id')->references('id_kelas_mata_pelajaran')->on('kelas_mata_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
