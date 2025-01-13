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
        Schema::create('topik', function (Blueprint $table) {
            $table->uuid('id_topik')->primary();
            $table->uuid('mata_pelajaran_id');
            $table->string('judul_topik');
            $table->uuid('kelas_mata_pelajaran_id');
            $table->timestamps();
            $table->foreign('mata_pelajaran_id')->references('id_matpel')->on('mata_pelajaran');
            $table->foreign('kelas_mata_pelajaran_id')->references('id_kelas_mata_pelajaran')->on('kelas_mata_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topik');
    }
};
