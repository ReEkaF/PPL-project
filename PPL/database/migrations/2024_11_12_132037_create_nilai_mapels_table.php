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
        Schema::create('nilai_matpel', function (Blueprint $table) {
            $table->uuid("id_nilai_matpel")->primary();
            $table->uuid("matpel_id");
            $table->uuid("rapor_id");
            $table->float('nilai_rata_rata_matpel');
            $table->string('pesan')->nullable();
            $table->timestamps();
            $table->foreign('matpel_id')->references('id_matpel')->on('mata_pelajaran');
            $table->foreign('rapor_id')->references('id_rapor')->on('rapor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_matpel');
    }
};
