<?php

namespace App\Repositories\Eloquent\Akademik;

use App\Models\kelas;
use App\Repositories\Contracts\Akademik\KelasRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KelasRepository extends BaseRepository implements KelasRepositoryInterface
{
    public function __construct(kelas $model)
    {
        parent::__construct($model);
    }

    public function getPaginatedClasses(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->when($search, fn ($query, $s) => $query->where('nama_kelas', 'like', '%'.$s.'%'))
            ->orderBy('nama_kelas', 'asc')
            ->paginate($perPage);
    }

    public function getAllWithStudentCount(): Collection
    {
        return $this->model
            ->withCount('siswa')
            ->orderByRaw('CAST(SUBSTRING(nama_kelas, 7) AS SIGNED)')
            ->orderBy('nama_kelas', 'asc')
            ->get();
    }

    public function findWithStudentsAndWali(string $idKelas): ?Model
    {
        return $this->model
            ->with(['siswa', 'waliKelas'])
            ->find($idKelas);
    }

    public function attachStudent(string $idKelas, string $idSiswa, string $tahunAjaranId): void
    {
        $kelas = $this->find($idKelas);
        if ($kelas) {
            $kelas->siswa()->attach($idSiswa, [
                'id_kelas_siswa' => (string) Str::uuid(),
                'tahun_ajaran' => $tahunAjaranId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function detachStudent(string $idKelas, string $idSiswa): void
    {
        $kelas = $this->find($idKelas);
        if ($kelas) {
            $kelas->siswa()->detach($idSiswa);
        }
    }

    public function detachStudents(string $idKelas, array $siswaIds): void
    {
        $kelas = $this->find($idKelas);
        if ($kelas && ! empty($siswaIds)) {
            $kelas->siswa()->detach($siswaIds);
        }
    }

    public function updateWaliKelas(string $idKelas, ?string $guruId): int
    {
        return DB::table('kelas_siswas')
            ->where('id_kelas', $idKelas)
            ->update(['wali_kelas' => $guruId]);
    }
}
