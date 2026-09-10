<?php

namespace App\Repositories\Contracts\Lms;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface TopikRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get topics for a specific class subject.
     */
    public function getByKelasMataPelajaranId(string $kmpId): Collection;
}
