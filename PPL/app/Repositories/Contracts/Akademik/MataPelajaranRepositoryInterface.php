<?php

namespace App\Repositories\Contracts\Akademik;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface MataPelajaranRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get paginated subject list with search.
     */
    public function getPaginatedMatpel(?string $search = null, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get paginated teacher-subject assignments with search.
     */
    public function getPaginatedGuruMataPelajaran(?string $search = null, int $perPage = 10): LengthAwarePaginator;

    /**
     * Assign a teacher to a subject.
     */
    public function assignGuruMatpel(string $guruId, string $matpelId): Model;

    /**
     * Find teacher-subject assignment by ID.
     */
    public function findGuruMatpel(int|string $id): ?Model;

    /**
     * Update teacher-subject assignment.
     */
    public function updateGuruMatpel(int|string $id, string $guruId, string $matpelId): bool;

    /**
     * Delete teacher-subject assignment.
     */
    public function deleteGuruMatpel(int|string $id): bool;
}
