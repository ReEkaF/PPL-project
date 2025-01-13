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
        Schema::create('buku', function (Blueprint $table) {
            $table->uuid('id_buku')->primary();
            $table->uuid('id_kategori_buku');
            $table->foreign('id_kategori_buku')->references('id_kategori_buku')->on('kategori_buku');
            $table->uuid('id_jenis_buku');
            $table->foreign('id_jenis_buku')->references('id_jenis_buku')->on('jenis_buku');
            $table->string('author_buku');
            $table->string('publisher_buku');
            $table->string('judul_buku');
            $table->text('foto_buku');
            $table->string('tahun_terbit');
            $table->string('bahasa_buku');
            $table->integer('stok_buku');
            $table->integer('rak_buku');
            $table->integer('harga_buku');
            $table->dateTime('tgl_ditambahkan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
