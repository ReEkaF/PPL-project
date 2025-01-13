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
        Schema::create('file_tugas', function (Blueprint $table) {
            $table->uuid('id_file_tugas')->primary();
            $table->uuid('tugas_id');
            $table->string('file_path');
            $table->string('original_name');
            $table->string('file_type');
            $table->string('upload_at');
            $table->timestamps();
            $table->foreign('tugas_id')->references('id_tugas')->on('tugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_tugas');
    }
};
