<?php

namespace App\Repositories\Eloquent\Perpustakaan;

use App\Models\buku;
use App\Repositories\Contracts\Perpustakaan\BukuRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BukuRepository extends BaseRepository implements BukuRepositoryInterface
{
    public function __construct(buku $model)
    {
        parent::__construct($model);
    }

    public function searchBooks(?string $search, ?string $kategoriId, int $perPage = 12): LengthAwarePaginator
    {
        return $this->model
            ->with(['kategoriBuku', 'jenisBuku'])
            ->when($search, function ($query) use ($search) {
                $query->where('judul_buku', 'LIKE', '%'.$search.'%')
                    ->orWhere('author_buku', 'LIKE', '%'.$search.'%');
            })
            ->when($kategoriId, function ($query) use ($kategoriId) {
                $query->where('id_kategori_buku', $kategoriId);
            })
            ->orderBy('tgl_ditambahkan', 'desc')
            ->paginate($perPage);
    }

    public function getRecentBooks(int $limit = 7): Collection
    {
        return $this->model
            ->with(['kategoriBuku', 'jenisBuku'])
            ->orderBy('tgl_ditambahkan', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getTotalBooksCount(): int
    {
        return $this->model->count();
    }

    public function getTotalStockSum(): int
    {
        return (int) $this->model->sum('stok_buku');
    }
}
