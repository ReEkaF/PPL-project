<?php

namespace App\Repositories\Contracts\Akademik;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface JadwalRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get active academic year class schedule with filters.
     */
    public function getJadwalForKelas(?string $kelasId = null): Collection;

    /**
     * Get active academic year teacher schedule.
     */
    public function getJadwalForGuru(string $guruId): Collection;

    /**
     * Check if a teacher has a schedule conflict.
     */
    public function checkBentrokGuru(
        string $guruId,
        string $hariId,
        string $tahunAjaranId,
        string $waktuMulai,
        string $waktuSelesai,
        ?string $excludeId = null
    ): bool;

    /**
     * Check if a classroom has a schedule conflict.
     */
    public function checkBentrokKelas(
        string $kelasId,
        string $hariId,
        string $tahunAjaranId,
        string $waktuMulai,
        string $waktuSelesai,
        ?string $excludeId = null
    ): bool;

    /**
     * Create a schedule record.
     */
    public function createJadwal(array $data): Model;

    /**
     * Update a schedule record.
     */
    public function updateJadwal(string $id, array $data): bool;

    /**
     * Delete a schedule record.
     */
    public function deleteJadwal(string $id): bool;
}
