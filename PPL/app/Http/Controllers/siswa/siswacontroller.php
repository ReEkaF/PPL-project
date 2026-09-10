<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\kelas;
use App\Models\kelas_mata_pelajaran;
use App\Models\Tugas;
use App\Models\Ujian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web-siswa')->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $idSiswa = $user->id_siswa;

        // 1. Kelas Siswa
        $kelasSiswa = DB::table('kelas_siswas')
            ->join('kelas', 'kelas_siswas.id_kelas', '=', 'kelas.id_kelas')
            ->where('kelas_siswas.id_siswa', $idSiswa)
            ->select('kelas.id_kelas', 'kelas.nama_kelas')
            ->first();

        // 2. Tahun Ajaran Aktif
        $tahunAjaran = DB::table('tahun_ajaran')->where('aktif', 1)->first()
            ?? DB::table('tahun_ajaran')->orderByDesc('tahun_mulai')->first();

        // 3. Kelas Mata Pelajaran (KMP) untuk kelas siswa
        $kelasId = $kelasSiswa?->id_kelas;
        $kmpList = $kelasId
            ? kelas_mata_pelajaran::where('kelas_id', $kelasId)
                ->when($tahunAjaran, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaran->id_tahun_ajaran))
                ->with(['mataPelajaran', 'guru', 'hari'])
                ->get()
            : collect();

        // 4. Hari & Jadwal Hari Ini
        Carbon::setLocale('id');
        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $todayEnglish = date('l');
        $todayName = $hariMap[$todayEnglish] ?? 'Senin';
        $tanggalHariIni = Carbon::now()->translatedFormat('l, d F Y');

        $jadwalHariIni = $kmpList->filter(function ($item) use ($todayName) {
            return strcasecmp($item->hari?->nama_hari ?? '', $todayName) === 0;
        })->sortBy('waktu_mulai')->values();

        // Jika hari ini libur atau tidak ada jadwal, ambil preview jadwal hari berikutnya
        $previewJadwal = $jadwalHariIni->isEmpty()
            ? $kmpList->sortBy(['hari.id_hari', 'waktu_mulai'])->take(4)->values()
            : $jadwalHariIni;

        // Status Presensi Hari Ini
        $presensiHariIni = DB::table('absensi_siswa')
            ->join('pertemuan', 'absensi_siswa.pertemuan_id', '=', 'pertemuan.id_pertemuan')
            ->where('absensi_siswa.siswa_id', $idSiswa)
            ->whereDate('pertemuan.tanggal_pertemuan', Carbon::today()->toDateString())
            ->select('absensi_siswa.status_absensi', 'pertemuan.tanggal_pertemuan')
            ->first();

        // 5. Statistik Presensi Keseluruhan
        $absensiRecords = DB::table('absensi_siswa')
            ->where('siswa_id', $idSiswa)
            ->get();
        $totalPertemuan = $absensiRecords->count();
        $hadirCount = $absensiRecords->where('status_absensi', 'Hadir')->count();
        $izinCount = $absensiRecords->where('status_absensi', 'Izin')->count();
        $sakitCount = $absensiRecords->where('status_absensi', 'Sakit')->count();
        $alpaCount = $absensiRecords->where('status_absensi', 'Alpa')->count();
        $persenKehadiran = $totalPertemuan > 0 ? round(($hadirCount / $totalPertemuan) * 100) : 100;

        // 6. Tugas LMS
        $kmpIds = $kmpList->pluck('id_kelas_mata_pelajaran');
        $allTugas = Tugas::whereIn('kelas_mata_pelajaran_id', $kmpIds)
            ->with(['kelasMataPelajaran.mataPelajaran'])
            ->orderByDesc('created_at')
            ->get();

        $submittedTugas = DB::table('pengumpulan_tugas')
            ->where('siswa_id', $idSiswa)
            ->pluck('status', 'tugas_id');

        $pendingTugasList = $allTugas->filter(fn ($t) => ! isset($submittedTugas[$t->id_tugas]) || $submittedTugas[$t->id_tugas] !== 'diserahkan')->values();
        $pendingTugasCount = $pendingTugasList->count();
        $selesaiTugasCount = $allTugas->count() - $pendingTugasCount;

        // 7. CBT & Ujian
        $allUjians = Ujian::whereIn('kelas_mata_pelajaran_id', $kmpIds)
            ->with(['kelasMataPelajaran.mataPelajaran', 'soalUjian'])
            ->orderByDesc('created_at')
            ->get();

        $submittedUjian = DB::table('pengumpulan_ujian')
            ->where('siswa_id', $idSiswa)
            ->pluck('nilai', 'ujian_id');

        $pendingUjians = $allUjians->filter(fn ($u) => ! isset($submittedUjian[$u->id_ujian]))->values();
        $pendingUjianCount = $pendingUjians->count();
        $selesaiUjianCount = $allUjians->count() - $pendingUjianCount;

        // 8. Perpustakaan (Buku yang sedang dipinjam)
        $transaksiBuku = DB::table('transaksi_peminjaman')
            ->join('buku', 'transaksi_peminjaman.id_buku', '=', 'buku.id_buku')
            ->where('kode_peminjam', $user->nisn)
            ->select(
                'transaksi_peminjaman.*',
                'buku.judul_buku',
                'buku.foto_buku',
                'buku.author_buku'
            )
            ->orderByDesc('transaksi_peminjaman.tgl_awal_peminjaman')
            ->get();
        $sedangDipinjamCount = $transaksiBuku->where('status_pengembalian', 0)->count();

        return view('siswa.dashboard', compact(
            'user',
            'kelasSiswa',
            'tahunAjaran',
            'todayName',
            'tanggalHariIni',
            'jadwalHariIni',
            'previewJadwal',
            'presensiHariIni',
            'totalPertemuan',
            'hadirCount',
            'izinCount',
            'sakitCount',
            'alpaCount',
            'persenKehadiran',
            'allTugas',
            'pendingTugasList',
            'pendingTugasCount',
            'selesaiTugasCount',
            'allUjians',
            'pendingUjians',
            'pendingUjianCount',
            'selesaiUjianCount',
            'transaksiBuku',
            'sedangDipinjamCount'
        ));
    }

    public function show($id_kelas, $id_siswa)
    {
        // Menggunakan alias untuk kolom id_siswa agar tidak terjadi ambiguitas
        $kelas = kelas::with(['siswa' => function ($query) use ($id_siswa) {
            $query->where('kelas_siswas.id_siswa', $id_siswa); // Menambahkan alias 'kelas_siswas.id_siswa'
        }])->findOrFail($id_kelas);

        $siswa = $kelas->siswa->first();

        if (! $siswa) {
            abort(403, 'Akses ditolak: Siswa tidak ditemukan di kelas ini.');
        }

        return view('guru.kelas.profil_siswa', compact('siswa', 'kelas'));
    }
}
