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
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->dateTime('tgl_mulai_pendaftaran')->nullable()->after('status');
            $table->dateTime('tgl_selesai_pendaftaran')->nullable()->after('tgl_mulai_pendaftaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->dropColumn(['tgl_mulai_pendaftaran', 'tgl_selesai_pendaftaran']);
        });
    }
};
