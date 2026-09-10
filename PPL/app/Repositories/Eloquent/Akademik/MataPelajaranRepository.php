<?php

namespace App\Repositories\Eloquent\Akademik;

use App\Models\guru_mata_pelajaran;
use App\Models\mata_pelajaran;
use App\Repositories\Contracts\Akademik\MataPelajaranRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class MataPelajaranRepository extends BaseRepository implements MataPelajaranRepositoryInterface
{
    public function __construct(mata_pelajaran $model)
    {
        parent::__construct($model);
    }

    public function getPaginatedMatpel(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->when($search, fn ($query, $s) => $query->where('nama_matpel', 'like', '%'.$s.'%'))
            ->orderBy('nama_matpel', 'asc')
            ->paginate($perPage);
    }

    public function getPaginatedGuruMataPelajaran(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = guru_mata_pelajaran::with(['guru', 'mataPelajaran']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('guru', fn ($g) => $g->where('nama_guru', 'like', '%'.$search.'%'))
                    ->orWhereHas('mataPelajaran', fn ($m) => $m->where('nama_matpel', 'like', '%'.$search.'%'));
            });
        }

        return $query->paginate($perPage);
    }

    public function assignGuruMatpel(string $guruId, string $matpelId): Model
    {
        return guru_mata_pelajaran::create([
            'guru_id' => $guruId,
            'matpel_id' => $matpelId,
        ]);
    }

    public function findGuruMatpel(int|string $id): ?Model
    {
        return guru_mata_pelajaran::find($id);
    }

    public function updateGuruMatpel(int|string $id, string $guruId, string $matpelId): bool
    {
        $assignment = guru_mata_pelajaran::find($id);
        if ($assignment) {
            return (bool) $assignment->update([
                'guru_id' => $guruId,
                'matpel_id' => $matpelId,
            ]);
        }

        return false;
    }

    public function deleteGuruMatpel(int|string $id): bool
    {
        $assignment = guru_mata_pelajaran::find($id);
        if ($assignment) {
            return (bool) $assignment->delete();
        }

        return false;
    }
}
