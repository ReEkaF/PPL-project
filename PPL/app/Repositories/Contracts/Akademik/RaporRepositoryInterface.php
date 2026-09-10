<?php

namespace App\Repositories\Contracts\Akademik;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RaporRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get paginated student report summary list.
     */
    public function getPaginatedSiswaRapor(
        ?string $search = null,
        ?string $kelasId = null,
        string $sort = 'nama_siswa',
        string $order = 'asc',
        int $perPage = 16
    ): LengthAwarePaginator;

    /**
     * Get full student report card details with grades, predicate, and extracurriculars.
     */
    public function getSiswaRaporDetail(string $siswaId): array;
}
