<?php

namespace App\Repositories\Eloquent\Lms;

use App\Models\file_materi;
use App\Models\materi;
use App\Models\notifikasi_sistem;
use App\Repositories\Contracts\Lms\MateriRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MateriRepository extends BaseRepository implements MateriRepositoryInterface
{
    public function __construct(materi $model)
    {
        parent::__construct($model);
    }

    public function getByKelasMataPelajaranIds(array $kmpIds, bool $onlyPublished = true): Collection
    {
        $query = $this->model->whereIn('kelas_mata_pelajaran_id', $kmpIds);

        if ($onlyPublished) {
            $query->where('status', 1);
        }

        return $query->get();
    }

    public function getRecentMateri(array $kmpIds, int $limit = 20): Collection
    {
        return $this->model
            ->whereIn('kelas_mata_pelajaran_id', $kmpIds)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function findWithDetails(string $id): ?Model
    {
        return $this->model
            ->with(['fileMateri', 'topik', 'kelasMataPelajaran'])
            ->find($id);
    }

    public function createFile(array $fileData): Model
    {
        return file_materi::create($fileData);
    }

    public function findFile(string $fileId): ?Model
    {
        return file_materi::find($fileId);
    }

    public function deleteFile(string $fileId): bool
    {
        $file = file_materi::find($fileId);
        if ($file) {
            return (bool) $file->delete();
        }

        return false;
    }

    public function getFiles(string $materiId): Collection
    {
        return file_materi::where('materi_id', $materiId)->get();
    }

    public function countFiles(string $materiId): int
    {
        return file_materi::where('materi_id', $materiId)->count();
    }

    public function deleteNotifikasiSistem(string $materiId): int
    {
        return notifikasi_sistem::where('materi_id', $materiId)->delete();
    }

    public function createNotifikasiSistem(array $data): Model
    {
        return notifikasi_sistem::create($data);
    }
}
