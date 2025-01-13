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
        Schema::create('staffakademik', function (Blueprint $table) {
            $table->uuid('id_staff_akademik')->primary();    
            $table->string('username');
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('nama_staff_akademik')->nullable();
            $table->string('wa_staff_akademik')->nullable();
            $table->string('alamat_staff_akademik')->nullable();
            $table->string('google_id')->nullable();
            $table->string('google_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffakademik');
    }
};
