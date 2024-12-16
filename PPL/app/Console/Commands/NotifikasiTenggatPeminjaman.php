<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Siswa;
use Twilio\Rest\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotifikasiTenggatPeminjaman extends Command
{
    protected $signature = 'app:notifikasi-tenggat-peminjaman';
    protected $description = 'Mengirim notifikasi tenggat pengembalian buku kepada peminjam.';

    public function handle()
    {
        $besok = Carbon::tomorrow();

        // Ambil transaksi yang pengembaliannya besok
        $peminjamanBesok = DB::table('transaksi_peminjaman')
            ->join('buku', 'transaksi_peminjaman.id_buku', '=', 'buku.id_buku')
            ->leftJoin('siswa', 'transaksi_peminjaman.kode_peminjam', '=', 'siswa.nisn')
            ->leftJoin('guru', 'transaksi_peminjaman.kode_peminjam', '=', 'guru.nip')
            ->where('transaksi_peminjaman.tgl_pengembalian', '<=', $besok)
            ->where('transaksi_peminjaman.status_pengembalian', 0)
            ->get();

        if ($peminjamanBesok->count() > 0) {
            foreach ($peminjamanBesok as $peminjaman) {
                $this->kirimNotifikasi($peminjaman);
            }

            $this->info("Notifikasi tenggat pengembalian buku besok telah dikirimkan melalui WhatsApp!");
        } else {
            $this->info("Tidak ada transaksi peminjaman yang tenggatnya besok.");
        }
    }

    private function kirimNotifikasi($peminjaman)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsappNumber = 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER');

        try {
            if ($peminjaman->nip == null) {  // Jika peminjam adalah siswa
                $nama = $peminjaman->nama_siswa;
                $wa = $peminjaman->nomor_wa_siswa;
            } else {  // Jika peminjam adalah guru
                $nama = $peminjaman->nama_guru;
                $wa = $peminjaman->nomor_wa_guru;
            }

            // Pesan yang akan dikirim
            $pesan = "⚠️ *Halo {$nama}* ⚠️\n\n" .
                "*Tenggat Pengembalian Buku:* {$peminjaman->judul_buku}\n" .
                "⏰ *Tenggat Waktu Pengembalian:* " . Carbon::parse($peminjaman->tgl_pengembalian)->format('d M Y') . "\n\n" .
                "Segera kembalikan buku tersebut agar tidak terlambat! 💪\n\n" .
                "Jangan lupa, semangat terus ya! ✨";

            // Membuat instance Twilio client
            $client = new Client($twilioSid, $twilioAuthToken);

            // Mengirim pesan WhatsApp
            $client->messages->create(
                'whatsapp:' . $wa,  // Use the fetched WhatsApp number
                [
                    'from' => $twilioWhatsappNumber,
                    'body' => $pesan
                ]
            );
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
        }
    }
}
