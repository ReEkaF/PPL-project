<?php

namespace App\Repositories\Eloquent\Perpustakaan;

use App\Models\kategori_buku;
use App\Repositories\Contracts\Perpustakaan\KategoriBukuRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class KategoriBukuRepository extends BaseRepository implements KategoriBukuRepositoryInterface
{
    public function __construct(kategori_buku $model)
    {
        parent::__construct($model);
    }

    public function getAllWithBookCount(): Collection
    {
        return $this->model
            ->withCount('buku')
            ->orderBy('nama_kategori', 'asc')
            ->get();
    }

    public function getRecentCategories(int $limit = 7): Collection
    {
        return $this->model
            ->orderBy('nama_kategori', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getTotalCount(): int
    {
        return $this->model->count();
    }
}
