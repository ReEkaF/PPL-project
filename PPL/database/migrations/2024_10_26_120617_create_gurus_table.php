<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->uuid('id_guru')->primary();
            $table->string('nip')->nullable();
            $table->string('nama_guru')->nullable();
            $table->string('email')->nullable();
            $table->string('google_id')->nullable();
            $table->string('google_token')->nullable();
            $table->string('foto_guru')->nullable();
            $table->string('nomor_wa_guru')->nullable();
            $table->string('username')->default('guru');
            $table->string('password')->default(Hash::make('guru'));
            $table->string('alamat_guru')->nullable();
            $table->enum('role_guru',['guru','pembina','wali_kelas'])->default('guru');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
