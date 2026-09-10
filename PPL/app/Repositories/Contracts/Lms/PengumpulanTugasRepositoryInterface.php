<?php

namespace App\Repositories\Contracts\Lms;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface PengumpulanTugasRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find submission by task ID and student ID.
     */
    public function findByTugasAndSiswa(string $tugasId, string $siswaId): ?Model;

    /**
     * Find submission with files, task, and student details.
     */
    public function findWithDetails(string $id): ?Model;

    /**
     * Get all submissions for a task.
     */
    public function getByTugasId(string $tugasId): Collection;

    /**
     * Create file record for a submission.
     */
    public function createFile(array $fileData): Model;

    /**
     * Find submission file by ID.
     */
    public function findFile(string $fileId): ?Model;

    /**
     * Delete submission file by ID.
     */
    public function deleteFile(string $fileId): bool;

    /**
     * Recalculate and update late status for task submissions when deadline changes.
     */
    public function syncLateStatusWithDeadline(string $tugasId, Carbon $deadline): void;

    /**
     * Get active assigned tasks for student tracking.
     */
    public function getTrackingDitugaskan(string $siswaId, string $kelasId, ?string $matpelId = null): Collection;

    /**
     * Get overdue unsubmitted tasks for student tracking.
     */
    public function getTrackingBelumDiserahkan(string $siswaId, string $kelasId, ?string $matpelId = null): Collection;

    /**
     * Get submitted tasks for student tracking.
     */
    public function getTrackingDiserahkan(string $siswaId, string $kelasId, ?string $matpelId = null): Collection;
}
