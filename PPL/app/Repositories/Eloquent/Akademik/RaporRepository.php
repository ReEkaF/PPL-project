<?php

namespace App\Repositories\Eloquent\Akademik;

use App\Models\Rapor;
use App\Repositories\Contracts\Akademik\RaporRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RaporRepository extends BaseRepository implements RaporRepositoryInterface
{
    public function __construct(Rapor $model)
    {
        parent::__construct($model);
    }

    public function getPaginatedSiswaRapor(
        ?string $search = null,
        ?string $kelasId = null,
        string $sort = 'nama_siswa',
        string $order = 'asc',
        int $perPage = 16
    ): LengthAwarePaginator {
        $query = DB::table('siswa')
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

        if ($search) {
            $query->where('siswa.nama_siswa', 'like', '%'.$search.'%');
        }

        if ($kelasId) {
            $query->where('kelas.id_kelas', '=', $kelasId);
        }

        $allowedSorts = ['nama_siswa', 'nama_kelas', 'nilai_rata_rata'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $order);
        }

        return $query->paginate($perPage);
    }

    public function getSiswaRaporDetail(string $siswaId): array
    {
        $siswa = DB::table('siswa')
            ->join('kelas_siswas', 'siswa.id_siswa', '=', 'kelas_siswas.id_siswa')
            ->join('kelas', 'kelas_siswas.id_kelas', '=', 'kelas.id_kelas')
            ->where('siswa.id_siswa', $siswaId)
            ->select('siswa.nama_siswa', 'siswa.id_siswa', 'kelas.nama_kelas', 'siswa.nisn')
            ->first();

        $nilaiMatpel = DB::table('nilai_matpel')
            ->join('mata_pelajaran', 'nilai_matpel.matpel_id', '=', 'mata_pelajaran.id_matpel')
            ->whereIn('nilai_matpel.rapor_id', function ($query) use ($siswaId) {
                $query->select('id_rapor')
                    ->from('rapor')
                    ->where('siswa_id', $siswaId);
            })
            ->select('mata_pelajaran.nama_matpel', 'nilai_matpel.nilai_rata_rata_matpel', 'nilai_matpel.pesan')
            ->get();

        $nilaiEkstra = DB::table('nilai_ekstra')
            ->join('ekstrakurikuler', 'nilai_ekstra.ekstrakurikuler_id', '=', 'ekstrakurikuler.id_ekstrakurikuler')
            ->whereIn('nilai_ekstra.rapor_id', function ($query) use ($siswaId) {
                $query->select('id_rapor')
                    ->from('rapor')
                    ->where('siswa_id', $siswaId);
            })
            ->select('ekstrakurikuler.nama_ekstrakurikuler', 'nilai_ekstra.nilai_rata_rata_ekstra')
            ->get();

        $tahunAjaran = DB::table('tahun_ajaran')->where('aktif', 1)->first();
        $bobotGrades = DB::table('bobot_grades')->get();

        foreach ($nilaiMatpel as $matpel) {
            $matpel->predikat = $this->getPredikat($matpel->nilai_rata_rata_matpel, $bobotGrades);
        }

        foreach ($nilaiEkstra as $ekstra) {
            $ekstra->predikat = $this->getPredikat($ekstra->nilai_rata_rata_ekstra, $bobotGrades);
        }

        return [
            'siswa' => $siswa,
            'nilai_matpel' => $nilaiMatpel,
            'nilai_ekstra' => $nilaiEkstra,
            'tahun_ajaran' => $tahunAjaran,
            'bobot_grades' => $bobotGrades,
        ];
    }

    protected function getPredikat(?float $nilai, Collection $bobotGrades): string
    {
        if ($nilai === null) {
            return '-';
        }

        foreach ($bobotGrades as $grade) {
            if ($nilai >= $grade->minimal && $nilai <= $grade->maksimal) {
                return $grade->grade;
            }
        }

        return 'E';
    }
}
