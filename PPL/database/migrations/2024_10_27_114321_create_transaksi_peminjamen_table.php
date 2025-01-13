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
        Schema::create('transaksi_peminjaman', function (Blueprint $table) {
            $table->uuid('id_transaksi_peminjaman')->primary();
            $table->uuid('id_buku');
            $table->foreign('id_buku')->references('id_buku')->on('buku');
            $table->string('kode_peminjam');
            $table->dateTime('tgl_awal_peminjaman');
            $table->dateTime('tgl_pengembalian');
            $table->integer('denda');
            $table->integer('status_pengembalian');
            $table->integer('jenis_peminjam');
            $table->integer('status_denda');
            $table->integer('stok')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_peminjaman');
    }
};
