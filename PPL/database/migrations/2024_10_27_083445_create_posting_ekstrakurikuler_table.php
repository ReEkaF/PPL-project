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

        Schema::create('posting_ekstrakurikuler', function (Blueprint $table) {
            $table->uuid('id_posting')->primary();
            $table->uuid('id_ekstrakurikuler');
            $table->foreign('id_ekstrakurikuler')->references('id_ekstrakurikuler')->on('ekstrakurikuler');
            $table->uuid('id_pengurus');
            $table->foreign('id_pengurus')->references('id_pengurus_ekstra')->on('pengurus_ekstra');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('gambar');
            $table->timestamp('tgl_uploud')->useCurrent();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posting_ekstrakurikuler');
    }
};
