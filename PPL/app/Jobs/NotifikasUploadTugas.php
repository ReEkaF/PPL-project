<?php

namespace App\Jobs;

use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifikasUploadTugas implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $namaTugas;
    protected $namaMataPelajaran;
    protected $deadline;
    protected $nomorWhatsApps;

    public function __construct($namaTugas, $namaMataPelajaran, $deadline, $nomorWhatsApps)
    {
        $this->namaTugas = $namaTugas;
        $this->namaMataPelajaran = $namaMataPelajaran;
        $this->deadline = $deadline;
        $this->nomorWhatsApps = $nomorWhatsApps;
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
    public function handle(): void
    {

        $nomorWhatsApps = $this->nomorWhatsApps;
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsappNumber = 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER');


        $message = "🚨 *Tugas Baru Telah Diupload!* 🚨\n\n" .
            "*Tugas:* {$this->namaTugas}\n" .
            "📚 *Mata Pelajaran:* " . $this->namaMataPelajaran . "\n" .
            "📅 *Deadline:* " . Carbon::parse($this->deadline)->format('d M Y H:i') . "\n\n" .
            "*Silahkan cek tugas di website sekolah dan kerjakan sebelum deadline.* ⏰\n\n" .
            "Jangan sampai terlewat ya! Semangat! 💪✨";
        $client = new Client($twilioSid, $twilioAuthToken);

        foreach ($nomorWhatsApps as $nomor) {
            $to = 'whatsapp:' . $nomor;
            $this->sendWhatsApp($client, $to, $twilioWhatsappNumber, $message);
        }

        // try {
        //     $client->messages->create(
        //         $to,
        //         ['from' => $twilioWhatsappNumber, 'body' => $message]
        //     );

        // } catch (\Exception $e) {
        //     // Log error atau handle kegagalan
        //     \Log::error('Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
        //     // dd('Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
        // }
    }
}
