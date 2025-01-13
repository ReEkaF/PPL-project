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

        Schema::create('histori_inventaris', function (Blueprint $table) {
            $table->uuid('id_histori')->primary();
            $table->uuid('id_inventaris');
            $table->text('keterangan');
            $table->bigInteger('jumlah');
            $table->foreign('id_inventaris')->references('id_inventaris')->on('inventaris_ekstrakurikuler');
            $table->timestamp('histori_keluar')->nullable();
            $table->timestamp('histori_masuk')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_inventaris');
    }
};
