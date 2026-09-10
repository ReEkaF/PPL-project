<?php

namespace App\Repositories\Contracts\Perpustakaan;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface KategoriBukuRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllWithBookCount(): Collection;

    public function getRecentCategories(int $limit = 7): Collection;

    public function getTotalCount(): int;
}
