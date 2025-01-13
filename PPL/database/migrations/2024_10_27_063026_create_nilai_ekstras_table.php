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
        Schema::create('nilai_ekstra', function (Blueprint $table) {
            $table->uuid('id_nilai_ekstra')->primary();
            $table->uuid('ekstrakurikuler_id');
            $table->uuid('rapor_id');
            $table->string('nilai_rata_rata_ekstra');
            $table->string('pesan')->nullable();
            $table->timestamps();
            $table->foreign('ekstrakurikuler_id')->references('id_ekstrakurikuler')->on('ekstrakurikuler');
            $table->foreign('rapor_id')->references('id_rapor')->on('rapor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_ekstra');
    }
};
