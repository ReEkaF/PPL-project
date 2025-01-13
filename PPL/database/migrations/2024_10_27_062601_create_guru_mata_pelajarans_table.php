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
        Schema::create('guru_mata_pelajaran', function (Blueprint $table) {
            $table->uuid('id_guru_mata_pelajaran')->primary();
            $table->uuid('guru_id');
            $table->uuid('matpel_id');
            $table->timestamps();
            $table->foreign('guru_id')->references('id_guru')->on('guru');
            $table->foreign('matpel_id')->references('id_matpel')->on('mata_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_mata_pelajaran');
    }
};
