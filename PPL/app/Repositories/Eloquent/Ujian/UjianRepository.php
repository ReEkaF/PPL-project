<?php

namespace App\Repositories\Eloquent\Ujian;

use App\Models\jawaban_ujian;
use App\Models\pengumpulan_ujian;
use App\Models\soal_ujian;
use App\Models\ujian;
use App\Repositories\Contracts\Ujian\UjianRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UjianRepository extends BaseRepository implements UjianRepositoryInterface
{
    public function __construct(ujian $model)
    {
        parent::__construct($model);
    }

    public function getPaginatedUjian(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function getAllWithRelations(?string $kelas = null): Collection
    {
        $query = $this->model->with([
            'kelasMataPelajaran.kelas',
            'kelasMataPelajaran.mataPelajaran',
            'topik',
        ])
        ->withCount(['soalUjian', 'pengumpulanUjian'])
        ->orderBy('tanggal_dibuat', 'desc');

        if ($kelas && $kelas !== 'all') {
            $query->whereHas('kelasMataPelajaran.kelas', function ($q) use ($kelas) {
                $q->where('nama_kelas', $kelas);
            });
        }

        return $query->get();
    }

    public function findWithQuestions(string $id): ?Model
    {
        return $this->model->with(['soalUjian' => fn ($q) => $q->where('ujian_id', $id)])->find($id);
    }

    public function getQuestions(string $ujianId): Collection
    {
        return soal_ujian::where('ujian_id', $ujianId)->get();
    }

    public function createQuestion(array $data): Model
    {
        return soal_ujian::create($data);
    }

    public function updateQuestion(string $id, array $data): bool
    {
        $soal = soal_ujian::find($id);
        if ($soal) {
            return (bool) $soal->update($data);
        }

        return false;
    }

    public function deleteQuestion(string $id): bool
    {
        $soal = soal_ujian::find($id);
        if ($soal) {
            return (bool) $soal->delete();
        }

        return false;
    }

    public function getSubmissions(): Collection
    {
        return pengumpulan_ujian::with(['siswa', 'ujian'])->latest()->get();
    }

    public function deleteSubmission(string $id): bool
    {
        return DB::transaction(function () use ($id) {
            jawaban_ujian::where('pengumpulan_ujian_id', $id)->delete();
            $sub = pengumpulan_ujian::find($id);
            if ($sub) {
                return (bool) $sub->delete();
            }

            return false;
        });
    }

    public function getExamsByKmpIds(array|\Illuminate\Support\Collection $kmpIds): Collection
    {
        return $this->model
            ->whereIn('kelas_mata_pelajaran_id', $kmpIds)
            ->with(['kelasMataPelajaran.mataPelajaran', 'soalUjian', 'pengumpulanUjian'])
            ->latest('tanggal_dibuat')
            ->get();
    }
}
