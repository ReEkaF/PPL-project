<?php

namespace App\Console\Commands;

use App\Models\transaksi_peminjaman;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Ramsey\Uuid\Type\Integer;

class CalculateDenda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-denda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghitung denda untuk peminjaman yang terlambat dikembalikan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hariIni = Carbon::now();
        $peminjamanTerlambat = transaksi_peminjaman::where('tgl_pengembalian', '<', $hariIni)
            ->where('status_pengembalian', 0)
            ->get();

        if ($peminjamanTerlambat->count() > 0) {
            foreach ($peminjamanTerlambat as $peminjaman) {
                $tanggalPengembalian = Carbon::parse($peminjaman->tgl_pengembalian);
                $hariTerlambat = intval($hariIni->diffInDays($tanggalPengembalian)) * -1;

                // Hitung denda 5000 per Hari
                $denda = $hariTerlambat * 5000;

                // Update denda di database
                $peminjaman->update(['denda' => $denda]);
            }

            $this->info("Denda Keterlambatan Pengembalian Buku Telah Diupdate !!");
        }
    }
}
