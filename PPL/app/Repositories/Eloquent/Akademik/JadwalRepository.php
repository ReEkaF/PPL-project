<?php

namespace App\Repositories\Eloquent\Akademik;

use App\Models\kelas_mata_pelajaran;
use App\Repositories\Contracts\Akademik\JadwalRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JadwalRepository extends BaseRepository implements JadwalRepositoryInterface
{
    public function __construct(kelas_mata_pelajaran $model)
    {
        parent::__construct($model);
    }

    public function getJadwalForKelas(?string $kelasId = null): Collection
    {
        $query = DB::table('kelas_mata_pelajaran')
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->join('tahun_ajaran', 'kelas_mata_pelajaran.tahun_ajaran_id', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select(
                'kelas_mata_pelajaran.id_kelas_mata_pelajaran',
                'kelas_mata_pelajaran.kelas_id',
                'kelas.nama_kelas',
                'kelas_mata_pelajaran.mata_pelajaran_id',
                'mata_pelajaran.nama_matpel',
                'kelas_mata_pelajaran.guru_id',
                'guru.nip',
                'guru.nama_guru',
                'kelas_mata_pelajaran.hari_id',
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'kelas_mata_pelajaran.tahun_ajaran_id',
                'tahun_ajaran.tahun_mulai',
                'tahun_ajaran.tahun_selesai',
                'tahun_ajaran.semester',
                'tahun_ajaran.aktif'
            )
            ->where('tahun_ajaran.aktif', 1);

        if ($kelasId) {
            $query->where('kelas_mata_pelajaran.kelas_id', $kelasId);
        }

        return $query->orderBy('hari.id_hari')
            ->orderBy('kelas_mata_pelajaran.waktu_mulai')
            ->get();
    }

    public function getJadwalForGuru(string $guruId): Collection
    {
        return DB::table('kelas_mata_pelajaran')
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->join('tahun_ajaran', 'kelas_mata_pelajaran.tahun_ajaran_id', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select(
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'mata_pelajaran.nama_matpel',
                'kelas.nama_kelas'
            )
            ->where('tahun_ajaran.aktif', 1)
            ->where('kelas_mata_pelajaran.guru_id', $guruId)
            ->orderBy('hari.id_hari')
            ->orderBy('kelas_mata_pelajaran.waktu_mulai')
            ->get();
    }

    public function checkBentrokGuru(
        string $guruId,
        string $hariId,
        string $tahunAjaranId,
        string $waktuMulai,
        string $waktuSelesai,
        ?string $excludeId = null
    ): bool {
        $query = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', $guruId)
            ->where('hari_id', $hariId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                $q->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                    ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                    ->orWhere(function ($sub) use ($waktuMulai, $waktuSelesai) {
                        $sub->where('waktu_mulai', '<=', $waktuMulai)
                            ->where('waktu_selesai', '>=', $waktuSelesai);
                    });
            });

        if ($excludeId) {
            $query->where('id_kelas_mata_pelajaran', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function checkBentrokKelas(
        string $kelasId,
        string $hariId,
        string $tahunAjaranId,
        string $waktuMulai,
        string $waktuSelesai,
        ?string $excludeId = null
    ): bool {
        $query = DB::table('kelas_mata_pelajaran')
            ->where('kelas_id', $kelasId)
            ->where('hari_id', $hariId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                $q->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                    ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                    ->orWhere(function ($sub) use ($waktuMulai, $waktuSelesai) {
                        $sub->where('waktu_mulai', '<=', $waktuMulai)
                            ->where('waktu_selesai', '>=', $waktuSelesai);
                    });
            });

        if ($excludeId) {
            $query->where('id_kelas_mata_pelajaran', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function createJadwal(array $data): Model
    {
        if (! isset($data['id_kelas_mata_pelajaran'])) {
            $data['id_kelas_mata_pelajaran'] = (string) Str::uuid();
        }

        return $this->model->create($data);
    }

    public function updateJadwal(string $id, array $data): bool
    {
        $jadwal = $this->find($id);
        if ($jadwal) {
            return (bool) $jadwal->update($data);
        }

        return false;
    }

    public function deleteJadwal(string $id): bool
    {
        $jadwal = $this->find($id);
        if ($jadwal) {
            return (bool) $jadwal->delete();
        }

        return false;
    }
}
