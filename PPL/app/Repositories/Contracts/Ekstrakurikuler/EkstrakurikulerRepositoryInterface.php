<?php

namespace App\Repositories\Contracts\Ekstrakurikuler;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EkstrakurikulerRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get open extracurriculars for student registration.
     */
    public function getOpenEkstrakurikuler(): Collection;

    /**
     * Find extracurricular by responsible teacher (Pembina).
     */
    public function findByGuruId(string $guruId): ?Model;

    /**
     * Find extracurricular assigned to student as manager (Pengurus).
     */
    public function findByPengurusSiswaId(string $siswaId): ?Model;

    /**
     * Register student for extracurricular activities with attached files.
     */
    public function registerStudent(string $siswaId, array $ekstraIds, array $data, ?string $fileIzin = null, ?string $fileDokter = null): void;

    /**
     * Get members of an extracurricular activity.
     */
    public function getMembers(string $idEkstra): Collection;

    /**
     * Update member registration status.
     */
    public function updateMemberStatus(string $idEkstra, string $idSiswa, string $status): bool;
}
