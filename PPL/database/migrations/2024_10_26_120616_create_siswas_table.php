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
        Schema::create('siswa', function (Blueprint $table) {
            $table->uuid('id_siswa')->primary();
            $table->string('nisn')->nullable();
            $table->string('nama_siswa')->nullable();
            $table->date('tgl_lahir_siswa')->nullable();
            $table->enum('jenis_kelamin_siswa', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('alamat_siswa')->nullable();
            $table->string('foto_siswa')->nullable();
            $table->string('nomor_wa_siswa')->nullable();
            $table->enum('role_siswa',['siswa','pengurus'])->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('google_id')->nullable();
            $table->string('google_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
