<?php

namespace App\Repositories\Contracts\Perpustakaan;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BukuRepositoryInterface extends BaseRepositoryInterface
{
    public function searchBooks(?string $search, ?string $kategoriId, int $perPage = 12): LengthAwarePaginator;

    public function getRecentBooks(int $limit = 7): Collection;

    public function getTotalBooksCount(): int;

    public function getTotalStockSum(): int;
}
