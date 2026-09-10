<?php

namespace App\Jobs;

use App\Models\NotifikasiTugas;
use App\Models\Siswa;
use App\Models\tugas;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class NotifikasiTenggatTugas implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    // public $tries = 3;
    // public $timeout = 120;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        // ambil tugas yang deadline sehari
        $tugas = tugas::where('deadline', '<=', Carbon::now()->addDay())
            ->where('deadline', '>=', Carbon::now())
            ->get();

        foreach ($tugas as $t) {
            $siswaBelumMengumpulkan = Siswa::whereNotIn('id_siswa', function ($query) use ($t) {
                $query->select('siswa_id')
                    ->from('pengumpulan_tugas')
                    ->where('tugas_id', $t->id_tugas);
            })->get();

            foreach ($siswaBelumMengumpulkan as $siswa) {
                $notifikasiSudahDikirim = NotifikasiTugas::where('tugas_id', $t->id_tugas)
                    ->where('siswa_id', $siswa->id_siswa)
                    ->exists();

                if (! $notifikasiSudahDikirim) {
                    // Kirim notifikasi
                    $this->kirimNotifikasi($siswa, $t);

                    // Catat bahwa notifikasi sudah dikirim
                    NotifikasiTugas::create([
                        'tugas_id' => $t->id_tugas,
                        'siswa_id' => $siswa->id_siswa,
                    ]);
                }
            }
        }
    }

    private function kirimNotifikasi($siswa, $tugas)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsappNumber = 'whatsapp:'.env('TWILIO_WHATSAPP_NUMBER');

        $pesan = "⚠️ *Halo {$siswa->nama_siswa}* ⚠️\n\n".
        "*Tugas:* {$tugas->judul}\n".
        '⏰ *Deadline:* '.Carbon::parse($tugas->deadline)->format('d M Y H:i')."\n\n".
        "Segera kerjakan dan kumpulkan tugas di website sekolah sebelum *deadline* agar tidak terlambat! 💪\n\n".
        'Jangan lupa, semangat terus ya! ✨';

        $client = new Client($twilioSid, $twilioAuthToken);
        try {
            $client->messages->create(
                'whatsapp:'.$siswa->nomor_wa_siswa,
                [
                    'from' => $twilioWhatsappNumber,
                    'body' => $pesan,
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim notifikasi: '.$e->getMessage());
        }
    }
}
