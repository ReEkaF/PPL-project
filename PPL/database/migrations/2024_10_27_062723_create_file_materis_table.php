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
        Schema::create('file_materi', function (Blueprint $table) {
            $table->uuid('id_file_materi')->primary();
            $table->uuid('materi_id');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('upload_at');
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('materi_id')->references('id_materi')->on('materi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_materi');
    }
};
