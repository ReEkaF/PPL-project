<?php

namespace App\Repositories\Contracts\Akademik;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface KelasRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get paginated classes with optional search.
     */
    public function getPaginatedClasses(?string $search = null, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get all classes with student count.
     */
    public function getAllWithStudentCount(): Collection;

    /**
     * Find class with assigned students and wali kelas.
     */
    public function findWithStudentsAndWali(string $idKelas): ?Model;

    /**
     * Attach student to class.
     */
    public function attachStudent(string $idKelas, string $idSiswa, string $tahunAjaranId): void;

    /**
     * Detach single student from class.
     */
    public function detachStudent(string $idKelas, string $idSiswa): void;

    /**
     * Detach multiple students from class.
     */
    public function detachStudents(string $idKelas, array $siswaIds): void;

    /**
     * Update wali kelas for all students in a class.
     */
    public function updateWaliKelas(string $idKelas, ?string $guruId): int;
}
