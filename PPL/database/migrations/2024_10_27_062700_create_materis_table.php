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
        Schema::create('materi', function (Blueprint $table) {
            $table->uuid('id_materi')->primary();
            $table->string('judul_materi');
            $table->text('deskripsi')->nullable();
            $table->uuid('topik_id')->nullable();
            $table->uuid('kelas_mata_pelajaran_id');
            $table->boolean('status');
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
        Schema::dropIfExists('materi');
    }
};
