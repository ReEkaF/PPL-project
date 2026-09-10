<?php

namespace App\Repositories\Eloquent\Lms;

use App\Models\kelas_mata_pelajaran;
use App\Models\pengumpulan_tugas;
use App\Models\PengumpulanTugasFile;
use App\Repositories\Contracts\Lms\PengumpulanTugasRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugasRepository extends BaseRepository implements PengumpulanTugasRepositoryInterface
{
    public function __construct(pengumpulan_tugas $model)
    {
        parent::__construct($model);
    }

    public function findByTugasAndSiswa(string $tugasId, string $siswaId): ?Model
    {
        return $this->model
            ->with('pengumpulanTugasFile')
            ->where('tugas_id', $tugasId)
            ->where('siswa_id', $siswaId)
            ->first();
    }

    public function findWithDetails(string $id): ?Model
    {
        return $this->model
            ->with(['siswa', 'pengumpulanTugasFile', 'tugas.kelasMataPelajaran'])
            ->find($id);
    }

    public function getByTugasId(string $tugasId): Collection
    {
        return $this->model
            ->with(['siswa', 'pengumpulanTugasFile'])
            ->where('tugas_id', $tugasId)
            ->get();
    }

    public function createFile(array $fileData): Model
    {
        return PengumpulanTugasFile::create($fileData);
    }

    public function findFile(string $fileId): ?Model
    {
        return PengumpulanTugasFile::find($fileId);
    }

    public function deleteFile(string $fileId): bool
    {
        $file = PengumpulanTugasFile::find($fileId);
        if ($file) {
            return (bool) $file->delete();
        }

        return false;
    }

    public function syncLateStatusWithDeadline(string $tugasId, Carbon $deadline): void
    {
        $submissions = $this->model
            ->where('tugas_id', $tugasId)
            ->whereIn('status', ['diserahkan', 'terlambat diserahkan'])
            ->get();

        foreach ($submissions as $sub) {
            $submittedAt = Carbon::parse($sub->created_at);
            $isLate = $submittedAt->isAfter($deadline);
            $sub->update([
                'status' => $isLate ? 'terlambat diserahkan' : 'diserahkan',
            ]);
        }
    }

    public function getTrackingDitugaskan(string $siswaId, string $kelasId, ?string $matpelId = null): Collection
    {
        $query = kelas_mata_pelajaran::where('kelas_id', $kelasId)->with('mataPelajaran');

        if ($matpelId) {
            $query->whereHas('mataPelajaran', fn ($q) => $q->where('id_matpel', $matpelId));
        }

        return $query->with([
            'mataPelajaran',
            'tugas' => function ($q) use ($siswaId) {
                $q->whereDate('deadline', '>=', now())
                    ->whereDoesntHave('pengumpulanTugas', fn ($sq) => $sq->where('siswa_id', $siswaId))
                    ->orderBy('deadline', 'asc');
            },
        ])->get()->filter(fn ($kmp) => $kmp->tugas->isNotEmpty());
    }

    public function getTrackingBelumDiserahkan(string $siswaId, string $kelasId, ?string $matpelId = null): Collection
    {
        $query = kelas_mata_pelajaran::where('kelas_id', $kelasId)->with('mataPelajaran');

        if ($matpelId) {
            $query->whereHas('mataPelajaran', fn ($q) => $q->where('id_matpel', $matpelId));
        }

        return $query->with([
            'mataPelajaran',
            'tugas' => function ($q) use ($siswaId) {
                $q->whereDoesntHave('pengumpulanTugas', fn ($sq) => $sq->where('siswa_id', $siswaId))
                    ->whereDate('deadline', '<=', now())
                    ->orderBy('deadline', 'asc');
            },
        ])->get()->filter(fn ($kmp) => $kmp->tugas->isNotEmpty());
    }

    public function getTrackingDiserahkan(string $siswaId, string $kelasId, ?string $matpelId = null): Collection
    {
        $query = kelas_mata_pelajaran::where('kelas_id', $kelasId)->with('mataPelajaran');

        if ($matpelId) {
            $query->whereHas('mataPelajaran', fn ($q) => $q->where('id_matpel', $matpelId));
        }

        return $query->with([
            'mataPelajaran',
            'tugas' => function ($q) use ($siswaId) {
                $q->whereHas('pengumpulanTugas', function ($sq) use ($siswaId) {
                    $sq->where('siswa_id', $siswaId)->whereIn('status', ['diserahkan', 'terlambat diserahkan']);
                })
                    ->with(['pengumpulanTugas' => function ($sq) use ($siswaId) {
                        $sq->where('siswa_id', $siswaId)->whereIn('status', ['diserahkan', 'terlambat diserahkan']);
                    }])
                    ->orderBy('created_at', 'asc');
            },
        ])->get()->filter(fn ($kmp) => $kmp->tugas->isNotEmpty());
    }
}
