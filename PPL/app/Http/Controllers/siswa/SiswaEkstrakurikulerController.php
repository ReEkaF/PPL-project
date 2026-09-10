<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ekstrakurikuler\RegisterEkstraRequest;
use App\Models\Ekstrakurikuler;
use App\Models\PenilaianEkstrakurikuler;
use App\Models\PostingEkstrakurikuler;
use App\Models\PrestasiEkstrakurikuler;
use App\Models\RegistrasiEkstrakurikuler;
use App\Models\Siswa;
use App\Services\Ekstrakurikuler\EkstrakurikulerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SiswaEkstrakurikulerController extends Controller
{
    public function __construct(
        protected EkstrakurikulerService $ekstraService
    ) {}

    /**
     * Tampilkan katalog seluruh ekstrakurikuler
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $statusFilter = $request->query('status');

        $query = Ekstrakurikuler::with('pembinaEkstra')
            ->withCount(['registrasiekstra as total_anggota' => function ($q) {
                $q->where('status', 'diterima');
            }]);

        if ($search) {
            $query->where('nama_ekstrakurikuler', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        if ($statusFilter === 'buka') {
            $query->pendaftaranBuka();
        } elseif ($statusFilter === 'tutup') {
            $query->where(function ($q) {
                $q->where('status', 'tidak buka')
                    ->orWhere(function ($sub) {
                        $sub->whereNotNull('tgl_selesai_pendaftaran')
                            ->where('tgl_selesai_pendaftaran', '<', now());
                    });
            });
        }

        $ekstrakurikulers = $query->orderBy('nama_ekstrakurikuler', 'asc')->get();

        // Ambil postingan dokumentasi terbaru
        $postinganTerbaru = PostingEkstrakurikuler::with(['ekstrakurikuler', 'pengurus.siswa'])
            ->latest('tgl_uploud')
            ->take(6)
            ->get();

        // Statistik ringkas untuk banner siswa
        $totalEkskul = Ekstrakurikuler::count();
        $ekskulBuka = Ekstrakurikuler::pendaftaranBuka()->count();
        
        $siswaId = Auth::guard('web-siswa')->user()->id_siswa;
        $totalEkskulDiikuti = RegistrasiEkstrakurikuler::where('id_siswa', $siswaId)
            ->where('status', 'diterima')
            ->count();

        return view('siswa.ekstrakurikuler.index', compact(
            'ekstrakurikulers',
            'postinganTerbaru',
            'totalEkskul',
            'ekskulBuka',
            'totalEkskulDiikuti',
            'search',
            'statusFilter'
        ));
    }

    /**
     * Tampilkan detail ekstrakurikuler tertentu
     */
    public function show(string $id): View
    {
        $ekstrakurikuler = Ekstrakurikuler::with('pembinaEkstra')
            ->withCount(['registrasiekstra as total_anggota' => function ($q) {
                $q->where('status', 'diterima');
            }])
            ->findOrFail($id);

        $prestasiList = DB::table('prestasi_ektrakurikuler')
            ->where('id_ekstrakurikuler', $id)
            ->get();

        $postingan = PostingEkstrakurikuler::where('id_ekstrakurikuler', $id)
            ->orderBy('tgl_uploud', 'desc')
            ->get();

        $siswaId = Auth::guard('web-siswa')->user()->id_siswa;
        $statusPendaftaranSiswa = RegistrasiEkstrakurikuler::where('id_siswa', $siswaId)
            ->where('id_ekstrakurikuler', $id)
            ->latest('tgl_registrasi')
            ->first();

        return view('siswa.ekstrakurikuler.detail', compact(
            'ekstrakurikuler',
            'prestasiList',
            'postingan',
            'statusPendaftaranSiswa'
        ));
    }

    /**
     * Tampilkan formulir pendaftaran ekstrakurikuler
     */
    public function pendaftaran(Request $request): View
    {
        $siswaId = Auth::guard('web-siswa')->user()->id_siswa;
        $siswa = Siswa::with('kelas')->findOrFail($siswaId);

        // Ekstrakurikuler yang dibuka saat ini sesuai rentang tanggal pendaftaran
        $ekstrakurikulerList = Ekstrakurikuler::pendaftaranBuka()
            ->orderBy('nama_ekstrakurikuler', 'asc')
            ->get();

        // Ekskul yang sudah didaftarkan / sedang diikuti siswa
        $registeredEkstraIds = RegistrasiEkstrakurikuler::where('id_siswa', $siswaId)
            ->pluck('id_ekstrakurikuler')
            ->toArray();

        // Opsi pilihan awal jika diarahkan dari tombol "Daftar Ekskul Ini" pada halaman detail
        $selectedId = $request->query('pilih');

        return view('siswa.ekstrakurikuler.pendaftaran', compact(
            'siswa',
            'ekstrakurikulerList',
            'registeredEkstraIds',
            'selectedId'
        ));
    }

    /**
     * Simpan pengajuan pendaftaran ekstrakurikuler
     */
    public function storePendaftaran(RegisterEkstraRequest $request): RedirectResponse
    {
        $siswaId = Auth::guard('web-siswa')->user()->id_siswa;

        // Validasi ekstrakurikuler yang dipilih apakah memang sedang dalam masa pendaftaran
        $pilihEkskul = $request->input('pilih_ekskul', []);
        $availableIds = Ekstrakurikuler::pendaftaranBuka()->pluck('id_ekstrakurikuler')->toArray();

        foreach ($pilihEkskul as $idEkstra) {
            if (!in_array($idEkstra, $availableIds)) {
                return redirect()->back()
                    ->withErrors(['pilih_ekskul' => 'Salah satu ekstrakurikuler yang Anda pilih saat ini sedang tidak membuka pendaftaran.'])
                    ->withInput();
            }
        }

        $fileIzin = $request->file('surat_izin_orang_tua');
        $fileDokter = $request->file('surat_keterangan_dokter');

        $this->ekstraService->submitRegistration(
            $siswaId,
            $request->validated(),
            $fileIzin,
            $fileDokter
        );

        return redirect()->route('siswa.ekstrakurikuler.saya')
            ->with('success', 'Pendaftaran ekstrakurikuler berhasil diajukan! Menunggu konfirmasi dari pengurus/pembina.');
    }

    /**
     * Tampilkan halaman Ekskul Saya (status pendaftaran, keanggotaan aktif & nilai)
     */
    public function ekskulSaya(): View
    {
        $siswaId = Auth::guard('web-siswa')->user()->id_siswa;

        $registrasiList = RegistrasiEkstrakurikuler::with([
                'ekstrakurikuler.pembinaEkstra',
                'berkas'
            ])
            ->where('id_siswa', $siswaId)
            ->latest('tgl_registrasi')
            ->get();

        $penilaianList = PenilaianEkstrakurikuler::with([
                'ekstrakurikuler',
                'tahunAjaran'
            ])
            ->where('id_siswa', $siswaId)
            ->get();

        $totalDiterima = $registrasiList->where('status', 'diterima')->count();
        $totalMenunggu = $registrasiList->where('status', 'menunggu')->count();
        $totalDitolak = $registrasiList->where('status', 'ditolak')->count();

        return view('siswa.ekstrakurikuler.saya', compact(
            'registrasiList',
            'penilaianList',
            'totalDiterima',
            'totalMenunggu',
            'totalDitolak'
        ));
    }
}
