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
        Schema::create('superadmin', function (Blueprint $table) {
            $table->uuid('id_admin')->primary();
            $table->string('username');
            $table->string('password');
            $table->string('nama_superadmin')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('google_id')->nullable();
            $table->string('google_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superadmin');
    }
};
