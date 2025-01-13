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
        Schema::create('pengumpulan_tugas_file', function (Blueprint $table) {
            $table->uuid('id_pengumpulan_tugas_file')->primary();
            $table->uuid('pengumpulan_tugas_id');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('original_name');
            $table->foreign('pengumpulan_tugas_id')->references('id_pengumpulan_tugas')->on('pengumpulan_tugas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas_files');
    }
};
