<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\hari;
use App\Models\kelas_mata_pelajaran;
use App\Models\materi;
use App\Models\pengumpulan_tugas;
use App\Models\tugas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Auth::guard('web-guru')->user();

        // Nama hari hari ini dalam bahasa Indonesia
        $daysMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $namaHariIni = $daysMap[Carbon::now()->format('l')] ?? 'Senin';
        $hariRecord = hari::whereRaw('LOWER(nama_hari) = ?', [strtolower($namaHariIni)])->first();

        // Jadwal Mengajar Hari Ini
        $jadwalHariIni = collect();
        if ($hariRecord) {
            $jadwalHariIni = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'hari'])
                ->where('guru_id', $guru->id_guru)
                ->where('hari_id', $hariRecord->id_hari)
                ->orderBy('waktu_mulai')
                ->get();
        }

        // Kumpulan jadwal & kelas yang diampu oleh guru
        $kmpList = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id_guru)
            ->get();
        $kmpIds = $kmpList->pluck('id_kelas_mata_pelajaran');

        // Metrik Statistik
        $totalKelas = $kmpList->pluck('kelas_id')->unique()->count();
        $totalJadwalSeminggu = $kmpList->count();
        $totalMateri = materi::whereIn('kelas_mata_pelajaran_id', $kmpIds)->count();

        $tugasIds = tugas::whereIn('kelas_mata_pelajaran_id', $kmpIds)->pluck('id_tugas');
        $totalTugas = $tugasIds->count();
        $tugasPerluDinilai = pengumpulan_tugas::whereIn('tugas_id', $tugasIds)
            ->whereNull('nilai')
            ->count();

        // Data Perwalian Kelas
        $kelasWali = $guru->kelas()->first();
        $jumlahSiswaWali = $kelasWali ? $guru->kelasSiswas()->count() : 0;

        // Data Ekstrakurikuler yang dibina (jika role pembina)
        $ekskulBinaan = $guru->role_guru === 'pembina' ? $guru->ekstrakurikuler : collect();

        // Materi & Tugas Terbaru
        $materiTerbaru = materi::whereIn('kelas_mata_pelajaran_id', $kmpIds)
            ->with(['kelasMataPelajaran.mataPelajaran', 'kelasMataPelajaran.kelas'])
            ->latest('created_at')
            ->take(4)
            ->get();

        $tugasTerbaru = tugas::whereIn('kelas_mata_pelajaran_id', $kmpIds)
            ->with(['kelasMataPelajaran.mataPelajaran', 'kelasMataPelajaran.kelas'])
            ->withCount(['pengumpulantugas as total_pengumpulan'])
            ->latest('created_at')
            ->take(4)
            ->get();

        return view('guru.dashboard', compact(
            'guru',
            'namaHariIni',
            'jadwalHariIni',
            'totalKelas',
            'totalJadwalSeminggu',
            'totalMateri',
            'totalTugas',
            'tugasPerluDinilai',
            'kelasWali',
            'jumlahSiswaWali',
            'ekskulBinaan',
            'materiTerbaru',
            'tugasTerbaru'
        ));
    }

    public function daftarSiswaWali()
    {
        // Mendapatkan data guru yang sedang login
        $guru = Auth::guard('web-guru')->user();

        // Mendapatkan kelas yang diwalikan
        $kelasList = $guru->kelas;
        $kelasWali = $kelasList->first();

        // Mendapatkan semua siswa di kelas yang diwalikan
        $siswaList = $guru->kelasSiswas->load('siswa');

        // Statistik gender perwalian
        $totalSiswa = $siswaList->count();
        $totalLaki = $siswaList->filter(fn($ks) => strtolower($ks->siswa->jenis_kelamin_siswa ?? '') === 'laki-laki')->count();
        $totalPerempuan = $siswaList->filter(fn($ks) => strtolower($ks->siswa->jenis_kelamin_siswa ?? '') === 'perempuan')->count();

        return view('guru.kelas.daftar_siswa_wali', compact(
            'guru',
            'kelasList',
            'kelasWali',
            'siswaList',
            'totalSiswa',
            'totalLaki',
            'totalPerempuan'
        ));
    }

    public function daftarKelasDanJadwal()
    {
        $guru = Auth::guard('web-guru')->user();

        $kelasMataPelajaran = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'guru', 'hari'])
            ->where('guru_id', $guru->id_guru)
            ->get()
            ->sortBy(function ($item) {
                return ($item->hari->id_hari ?? 99) . '_' . ($item->waktu_mulai ?? '00:00');
            });

        return view('guru.kelas.jadwal_pelajaran_kelas', compact('guru', 'kelasMataPelajaran'));
    }
}
