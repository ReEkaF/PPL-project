<?php

namespace App\Http\Controllers\pembinaekstra;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\InventarisEkstrakurikuler;
use App\Models\PenilaianEkstrakurikuler;
use App\Models\RegistrasiEkstrakurikuler;
use App\Models\tahun_ajaran;
use Illuminate\View\View;

class PembinaekstraController extends Controller
{
    public function index(): View
    {
        $guru = auth()->guard('web-guru')->user();
        $guruId = $guru?->id_guru;

        // Ambil data ekstrakurikuler yang dibina oleh guru ini
        $ekstra = Ekstrakurikuler::where('guru_id', $guruId)->first();

        $totalAnggota = 0;
        $totalDinilai = 0;
        $totalInventaris = 0;
        $anggotaTerbaru = collect();
        $inventarisList = collect();
        $tahunAjaranAktif = tahun_ajaran::where('aktif', '1')->first();

        if ($ekstra) {
            $idEkstra = $ekstra->id_ekstrakurikuler;

            // Total anggota diterima
            $registrasi = RegistrasiEkstrakurikuler::with('siswa')
                ->where('id_ekstrakurikuler', $idEkstra)
                ->where('status', 'diterima')
                ->latest('tgl_registrasi')
                ->get();

            $totalAnggota = $registrasi->count();
            $anggotaTerbaru = $registrasi->take(5);

            // Total siswa yang sudah dinilai
            $siswaIds = $registrasi->pluck('id_siswa')->toArray();
            $totalDinilai = PenilaianEkstrakurikuler::whereIn('id_siswa', $siswaIds)->count();

            // Total inventaris
            $inventaris = InventarisEkstrakurikuler::where('id_ekstrakurikuler', $idEkstra)->get();
            $totalInventaris = $inventaris->count();
            $inventarisList = $inventaris->take(5);
        }

        return view('pembina_ekstra.dashboard', compact(
            'guru',
            'ekstra',
            'totalAnggota',
            'totalDinilai',
            'totalInventaris',
            'anggotaTerbaru',
            'inventarisList',
            'tahunAjaranAktif'
        ));
    }
}
