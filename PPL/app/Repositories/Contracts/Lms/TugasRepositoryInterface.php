<?php

namespace App\Repositories\Contracts\Lms;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TugasRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get tasks for a given kelas mata pelajaran.
     */
    public function getByKelasMataPelajaranId(string $kmpId): Collection;

    /**
     * Get tasks without assigned topic for a kelas mata pelajaran.
     */
    public function getWithoutTopic(string $kmpId): Collection;

    /**
     * Find task with files, topic, and class details.
     */
    public function findWithDetails(string $id): ?Model;

    /**
     * Find task with student submissions and student info.
     */
    public function findWithSubmissions(string $id): ?Model;

    /**
     * Create a file record for a task.
     */
    public function createFile(array $fileData): Model;

    /**
     * Find a task file by ID.
     */
    public function findFile(string $fileId): ?Model;

    /**
     * Delete a task file by ID.
     */
    public function deleteFile(string $fileId): bool;

    /**
     * Get all files for a task.
     */
    public function getFiles(string $tugasId): Collection;

    /**
     * Get upcoming tasks for a class subject.
     */
    public function getUpcomingTasks(string $kmpId, ?string $siswaId = null): Collection;

    /**
     * Get tasks for grading overview by teacher.
     */
    public function getTugasForPeriksa(string $guruId, ?string $kelasId = null): Collection;
}
