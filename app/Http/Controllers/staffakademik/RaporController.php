<?php

namespace App\Http\Controllers\staffakademik;

use ZipArchive;
use App\Models\kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class RaporController extends Controller
{
    private function getSiswaData($id)
    {
        $siswa = DB::table('siswa')
            ->join('kelas_siswas', 'siswa.id_siswa', '=', 'kelas_siswas.id_siswa')
            ->join('kelas', 'kelas_siswas.id_kelas', '=', 'kelas.id_kelas')
            ->where('siswa.id_siswa', $id)
            ->select('siswa.nama_siswa', 'siswa.id_siswa', 'kelas.nama_kelas', 'siswa.nisn')
            ->first();

        $nilaiMatpel = DB::table('nilai_matpel')
            ->join('mata_pelajaran', 'nilai_matpel.matpel_id', '=', 'mata_pelajaran.id_matpel')
            ->whereIn('nilai_matpel.rapor_id', function ($query) use ($id) {
                $query->select('id_rapor')
                    ->from('rapor')
                    ->where('siswa_id', $id);
            })
            ->select('mata_pelajaran.nama_matpel', 'nilai_matpel.nilai_rata_rata_matpel', 'nilai_matpel.pesan')
            ->get();

        $nilaiEkstra = DB::table('nilai_ekstra')
            ->join('ekstrakurikuler', 'nilai_ekstra.ekstrakurikuler_id', '=', 'ekstrakurikuler.id_ekstrakurikuler')
            ->whereIn('nilai_ekstra.rapor_id', function ($query) use ($id) {
                $query->select('id_rapor')
                    ->from('rapor')
                    ->where('siswa_id', $id);
            })
            ->select('ekstrakurikuler.nama_ekstrakurikuler', 'nilai_ekstra.nilai_rata_rata_ekstra')
            ->get();

        $tahunAjaran = DB::table('tahun_ajaran')->where('aktif', 1)->first();

        // Ambil data bobot grade
        $bobotGrades = DB::table('bobot_grades')->get();

        // Tambahkan predikat ke nilai mapel
        foreach ($nilaiMatpel as $matpel) {
            $matpel->predikat = $this->getPredikat($matpel->nilai_rata_rata_matpel, $bobotGrades);
        }

        // Tambahkan predikat ke nilai ekstra
        foreach ($nilaiEkstra as $ekstra) {
            $ekstra->predikat = $this->getPredikat($ekstra->nilai_rata_rata_ekstra, $bobotGrades);
        }

        return [
            'siswa' => $siswa,
            'nilai_matpel' => $nilaiMatpel,
            'nilai_ekstra' => $nilaiEkstra,
            'tahun_ajaran' => $tahunAjaran,
            'bobot_grades' => $bobotGrades
        ];
    }

    public function index(Request $request, $id_siswa = null)
    {
        $kelasList = kelas::all();

        $search = $request->input('search');
        $kelasId = $request->input('kelas');
        $sort = $request->input('sort', 'nama_siswa'); // Default sort by nama_siswa
        $order = $request->input('order', 'asc'); // Default order is ascending

        $siswaList = DB::table('siswa')
            ->join('rapor', 'siswa.id_siswa', '=', 'rapor.siswa_id')
            ->join('nilai_matpel', 'rapor.id_rapor', '=', 'nilai_matpel.rapor_id')
            ->join('kelas_siswas', 'siswa.id_siswa', '=', 'kelas_siswas.id_siswa')
            ->join('kelas', 'kelas_siswas.id_kelas', '=', 'kelas.id_kelas')
            ->select(
                'siswa.nama_siswa',
                'siswa.id_siswa',
                'kelas.nama_kelas',
                DB::raw('AVG(nilai_matpel.nilai_rata_rata_matpel) as nilai_rata_rata')
            )
            ->groupBy('siswa.id_siswa', 'siswa.nama_siswa', 'kelas.nama_kelas');

        // Filter pencarian nama siswa
        if ($search) {
            $siswaList->where('siswa.nama_siswa', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan kelas
        if ($kelasId) {
            $siswaList->where('kelas.id_kelas', '=', $kelasId);
        }

        // Sorting berdasarkan kolom dan order
        $allowedSorts = ['nama_siswa', 'nama_kelas', 'nilai_rata_rata'];
        if (in_array($sort, $allowedSorts)) {
            $siswaList->orderBy($sort, $order);
        }

        // Pagination
        $siswaList = $siswaList->paginate(16)->appends($request->except('page'));

        // Jika ada id_siswa, ambil data detailnya
        $detailSiswa = null;
        if ($id_siswa) {
            $detailSiswa = $this->showDetail($id_siswa);
        }

        return view('staff_akademik.rapor.index', compact('siswaList', 'kelasList', 'detailSiswa'));
    }



    public function showDetail($id)
    {
        $data = $this->getSiswaData($id);
        return response()->json([
            'id_siswa' => $data['siswa']->id_siswa,
            'nama_siswa' => $data['siswa']->nama_siswa,
            'nama_kelas' => $data['siswa']->nama_kelas,
            'nisn' => $data['siswa']->nisn,
            'nilai_matpel' => $data['nilai_matpel'],
            'nilai_ekstra' => $data['nilai_ekstra'],
            'tahun_ajaran' => $data['tahun_ajaran']->tahun_mulai . ' - ' . $data['tahun_ajaran']->tahun_selesai,
            'semester' => $data['tahun_ajaran']->semester
        ]);
    }


    public function downloadPDF($id)
    {
        $data = $this->getSiswaData($id);

        $pdfData = [
            'nama_siswa' => $data['siswa']->nama_siswa,
            'kelas' => $data['siswa']->nama_kelas,
            'nisn' => $data['siswa']->nisn,
            'nilai_matpel' => $data['nilai_matpel'],
            'nilai_ekstra' => $data['nilai_ekstra'],
            'tahun_ajaran' => $data['tahun_ajaran']->tahun_mulai . ' - ' . $data['tahun_ajaran']->tahun_selesai,
            'semester' => $data['tahun_ajaran']->semester
        ];

        $pdf = Pdf::loadView('staff_akademik.rapor.rapor-pdf', $pdfData);
        return $pdf->download('rapor_' . $data['siswa']->nama_siswa . '.pdf');
    }

    private function getPredikat($nilai, $bobotGrades)
    {
        foreach ($bobotGrades as $grade) {
            if ($nilai >= $grade->minimal && $nilai <= $grade->maksimal) {
                return $grade->grade;
            }
        }
        return 'E';
    }
}
