<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiTugas;
use App\Models\Siswa;
use App\Models\tugas;
use Carbon\Carbon;
use Twilio\Rest\Client;

use Illuminate\Http\Request;

class CeKController extends Controller
{
    public function __invoke()
    {
        $now = Carbon::now();
        $tugas = Tugas::all();
        foreach ($tugas as $tugas) {
            echo $tugas->judul . " deadline " . $tugas->deadline . " sekarang adalah " . now()  . "<br>";
        }
        echo "<br>";

        $tugas = tugas::where("deadline", "<=", Carbon::now()->addDay())
            ->where('deadline', ">=", Carbon::now())
            ->get();
        foreach ($tugas as $tugas) {
            echo $tugas->judul . " deadline " . $tugas->deadline . " sekarang adalah " . now()  . "<br>";
        }
    }



    private function kirimNotifikasi($siswa, $tugas)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsappNumber = 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER');

        $pesan = "Halo {$siswa->nama_siswa}, Kamu punya tugas {$tugas->judul} yang akan segera deadline pada " . Carbon::parse($tugas->deadline)->format('d M Y H:i') . ". Segera kerjakan dan kumpulkan blok";

        $client = new Client($twilioSid, $twilioAuthToken);
        try {
            $client->messages->create(
                'whatsapp:' . $siswa->no_whatsapp,
                [
                    'from' => $twilioWhatsappNumber,
                    'body' => $pesan
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim notifikasi: ' . $e->getMessage());
        }
    }
}
