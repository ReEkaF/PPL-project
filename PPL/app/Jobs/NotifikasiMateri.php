<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class NotifikasiMateri implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $materi;
    protected $kelas_mata_pelajaran;
    protected $nomorWhatsApps;
    protected $status;

    public function __construct($materi, $kelas_mata_pelajaran, $nomorWhatsApps, $status)
    {
        $this->materi = $materi;
        $this->kelas_mata_pelajaran = $kelas_mata_pelajaran;
        $this->nomorWhatsApps = $nomorWhatsApps;
        $this->status = $status;
    }


    public function sendWhatsApp($client, $to, $from, $message)
    {
        try {
            $client->messages->create(
                $to,
                ['from' => $from, 'body' => $message]
            );
        } catch (\Exception $e) {
            // Log error atau handle kegagalan
            \Log::error('Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
            // dd('Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
        }
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $nomorWhatsApps = $this->nomorWhatsApps;
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsappNumber = 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER');

        if ($this->status == 'store') {
            $message = "📔 *Materi Baru Diupload!* 📔 \n\n" .
                "📕 *Materi:* " . $this->materi->judul_materi . "\n" .
                "📚 *Mata Pelajaran:* " . $this->kelas_mata_pelajaran->mataPelajaran->nama_matpel . "\n" .
                "🎓 *Kelas:* " . $this->kelas_mata_pelajaran->kelas->nama_kelas . "\n" .
                "📅 *Tanggal Upload:* " . $this->materi->created_at->format('d M Y') . "\n\n" .
                "Silahkan cek materi di website sekolah dan jangan lupa dipelajari ya✨ \n\n";
        } else {
            $message = "📔 *Materi Diupdate!* 📔 \n\n" .
                "📕 *Materi:* " . $this->materi->judul_materi . "\n" .
                "📚 *Mata Pelajaran:* " . $this->kelas_mata_pelajaran->mataPelajaran->nama_matpel . "\n" .
                "🎓 *Kelas:* " . $this->kelas_mata_pelajaran->kelas->nama_kelas . "\n" .
                "📅 *Tanggal Update:* " . $this->materi->updated_at->format('d M Y') . "\n\n" .
                "Silahkan cek materi di website sekolah dan jangan lupa dipelajari ya✨ \n\n";
        }

        $client = new Client($twilioSid, $twilioAuthToken);

        foreach ($nomorWhatsApps as $nomor) {
            $to = 'whatsapp:' . $nomor;
            $this->sendWhatsApp($client, $to, $twilioWhatsappNumber, $message);
        }
    }
}
