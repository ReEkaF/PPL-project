<?php

namespace App\Repositories\Eloquent\Lms;

use App\Models\file_tugas;
use App\Models\tugas;
use App\Repositories\Contracts\Lms\TugasRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TugasRepository extends BaseRepository implements TugasRepositoryInterface
{
    public function __construct(tugas $model)
    {
        parent::__construct($model);
    }

    public function getByKelasMataPelajaranId(string $kmpId): Collection
    {
        return $this->model
            ->where('kelas_mata_pelajaran_id', $kmpId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getWithoutTopic(string $kmpId): Collection
    {
        return $this->model
            ->where('kelas_mata_pelajaran_id', $kmpId)
            ->whereNull('topik_id')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findWithDetails(string $id): ?Model
    {
        return $this->model
            ->with([
                'filetugas',
                'topik',
                'kelasMataPelajaran' => fn ($query) => $query->with(['mataPelajaran', 'kelas', 'guru']),
            ])
            ->find($id);
    }

    public function findWithSubmissions(string $id): ?Model
    {
        return $this->model
            ->with([
                'pengumpulantugas' => function ($query) {
                    $query->with(['siswa', 'pengumpulanTugasFile']);
                },
                'kelasMataPelajaran' => function ($query) {
                    $query->with(['kelas.siswa', 'mataPelajaran']);
                },
            ])
            ->find($id);
    }

    public function createFile(array $fileData): Model
    {
        return file_tugas::create($fileData);
    }

    public function findFile(string $fileId): ?Model
    {
        return file_tugas::find($fileId);
    }

    public function deleteFile(string $fileId): bool
    {
        $file = file_tugas::find($fileId);
        if ($file) {
            return (bool) $file->delete();
        }

        return false;
    }

    public function getFiles(string $tugasId): Collection
    {
        return file_tugas::where('tugas_id', $tugasId)->get();
    }

    public function getUpcomingTasks(string $kmpId, ?string $siswaId = null): Collection
    {
        $query = $this->model
            ->where('kelas_mata_pelajaran_id', $kmpId)
            ->where('deadline', '>', Carbon::now());

        if ($siswaId) {
            $query->whereDoesntHave('pengumpulantugas', function ($q) use ($siswaId) {
                $q->where('siswa_id', $siswaId);
            });
        }

        return $query->orderBy('deadline', 'asc')->get();
    }

    public function getTugasForPeriksa(string $guruId, ?string $kelasId = null): Collection
    {
        $query = $this->model
            ->with(['kelasMataPelajaran.kelas.siswa', 'pengumpulantugas'])
            ->whereHas('kelasMataPelajaran', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            });

        if ($kelasId) {
            $query->whereHas('kelasMataPelajaran', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        return $query->get();
    }
}
