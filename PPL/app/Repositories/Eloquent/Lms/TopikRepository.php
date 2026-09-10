<?php

namespace App\Repositories\Eloquent\Lms;

use App\Models\topik;
use App\Repositories\Contracts\Lms\TopikRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class TopikRepository extends BaseRepository implements TopikRepositoryInterface
{
    public function __construct(topik $model)
    {
        parent::__construct($model);
    }

    public function getByKelasMataPelajaranId(string $kmpId): Collection
    {
        return $this->model
            ->where('kelas_mata_pelajaran_id', $kmpId)
            ->get();
    }
}
