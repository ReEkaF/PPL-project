<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use App\Models\pengumpulan_tugas;
use App\Models\PenilaianEkstrakurikuler;
use App\Models\Siswa;
use App\Services\Akademik\RaporService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RaporController extends Controller
{
    public function __construct(
        protected RaporService $raporService
    ) {}

    public function index(Request $request, ?string $id_siswa = null): View
    {
        $search = $request->input('search');
        $kelasId = $request->input('kelas');
        $sort = $request->input('sort', 'nama_siswa');
        $order = $request->input('order', 'asc');

        $data = $this->raporService->getRaporIndexData($search, $kelasId, $sort, $order, $id_siswa);

        return view('staff_akademik.rapor.index', [
            'siswaList' => $data['siswaList']->appends($request->except('page')),
            'kelasList' => $data['kelasList'],
            'detailSiswa' => $data['detailSiswa'],
        ]);
    }

    public function showDetail(string $id): JsonResponse
    {
        $data = $this->raporService->getSiswaDetail($id);

        return response()->json([
            'id_siswa' => $data['siswa']->id_siswa,
            'nama_siswa' => $data['siswa']->nama_siswa,
            'nama_kelas' => $data['siswa']->nama_kelas,
            'nisn' => $data['siswa']->nisn,
            'nilai_matpel' => $data['nilai_matpel'],
            'nilai_ekstra' => $data['nilai_ekstra'],
            'tahun_ajaran' => $data['tahun_ajaran']->tahun_mulai.' - '.$data['tahun_ajaran']->tahun_selesai,
            'semester' => $data['tahun_ajaran']->semester,
        ]);
    }

    public function insertNilaiSiswa(string $id_siswa): void
    {
        $raporId = DB::table('rapor')
            ->where('siswa_id', $id_siswa)
            ->value('id_rapor');

        $nilaiMatpel = pengumpulan_tugas::with(['siswa.tugas.kelasMataPelajaran.mataPelajaran'])
            ->where('pengumpulan_tugas.siswa_id', $id_siswa)
            ->select('tugas_id', 'nilai')
            ->get()
            ->groupBy('tugas.kelasMataPelajaran.mataPelajaran.id_matpel');

        $nilaiEkstra = PenilaianEkstrakurikuler::with(['siswa'])
            ->where('penilaian_ekstrakurikuler.id_siswa', $id_siswa)
            ->select('id_ekstrakurikuler', 'penilaian')
            ->get();

        foreach ($nilaiMatpel as $matpelId => $tugasItems) {
            $rataNilai = $tugasItems->avg('nilai');
            DB::table('nilai_matpel')->insert([
                'id_nilai_matpel' => (string) Str::uuid(),
                'rapor_id' => $raporId,
                'matpel_id' => $matpelId,
                'nilai_rata_rata_matpel' => $rataNilai,
                'pesan' => 'bagus',
            ]);
        }

        foreach ($nilaiEkstra as $nilai) {
            $pesan = DB::table('laporan_penilaian_ekstrakurikuler')
                ->where('id_siswa', $id_siswa)
                ->where('id_ekstrakurikuler', $nilai->id_ekstrakurikuler)
                ->value('isi_laporan');

            DB::table('nilai_ekstra')->insert([
                'id_nilai_ekstra' => (string) Str::uuid(),
                'rapor_id' => $raporId,
                'ekstrakurikuler_id' => $nilai->id_ekstrakurikuler,
                'nilai_rata_rata_ekstra' => $nilai->penilaian,
                'pesan' => $pesan,
            ]);
        }
    }

    public function updateNilai(): void
    {
        DB::table('nilai_ekstra')->delete();
        DB::table('nilai_matpel')->delete();
        DB::table('rapor')->delete();
        $siswaList = Siswa::all();
        $tahunAjaranAktif = DB::table('tahun_ajaran')->where('aktif', 1)->first();

        if ($tahunAjaranAktif) {
            foreach ($siswaList as $siswa) {
                DB::table('rapor')->insert([
                    'id_rapor' => (string) Str::uuid(),
                    'siswa_id' => $siswa->id_siswa,
                    'tahun_ajaran_id' => $tahunAjaranAktif->id_tahun_ajaran,
                ]);
                $this->insertNilaiSiswa($siswa->id_siswa);
            }
        }
    }

    public function downloadPDF(string $id): Response
    {
        $data = $this->raporService->getSiswaDetail($id);
        $pdfData = [
            'nama_siswa' => $data['siswa']->nama_siswa,
            'kelas' => $data['siswa']->nama_kelas,
            'nisn' => $data['siswa']->nisn,
            'nilai_matpel' => $data['nilai_matpel'],
            'nilai_ekstra' => $data['nilai_ekstra'],
            'tahun_ajaran' => $data['tahun_ajaran']->tahun_mulai.' - '.$data['tahun_ajaran']->tahun_selesai,
            'semester' => $data['tahun_ajaran']->semester,
        ];

        $pdf = Pdf::loadView('staff_akademik.rapor.rapor-pdf', $pdfData);

        return $pdf->download('rapor_'.$data['siswa']->nama_siswa.'.pdf');
    }
}
