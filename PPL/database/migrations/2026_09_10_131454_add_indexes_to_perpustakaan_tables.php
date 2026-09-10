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
        Schema::table('transaksi_peminjaman', function (Blueprint $table) {
            $table->index('kode_peminjam', 'idx_trans_kode_peminjam');
            $table->index('status_pengembalian', 'idx_trans_status_pengembalian');
            $table->index('tgl_awal_peminjaman', 'idx_trans_tgl_awal');
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->index('judul_buku', 'idx_buku_judul');
            $table->index('tgl_ditambahkan', 'idx_buku_tgl_tambah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_peminjaman', function (Blueprint $table) {
            $table->dropIndex('idx_trans_kode_peminjam');
            $table->dropIndex('idx_trans_status_pengembalian');
            $table->dropIndex('idx_trans_tgl_awal');
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->dropIndex('idx_buku_judul');
            $table->dropIndex('idx_buku_tgl_tambah');
        });
    }
};
