<?php

namespace App\Repositories\Contracts\Lms;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface MateriRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get materi by list of kelas mata pelajaran IDs.
     */
    public function getByKelasMataPelajaranIds(array $kmpIds, bool $onlyPublished = true): Collection;

    /**
     * Get recent materi ordered by created_at desc.
     */
    public function getRecentMateri(array $kmpIds, int $limit = 20): Collection;

    /**
     * Find materi by ID with attached files and topics.
     */
    public function findWithDetails(string $id): ?Model;

    /**
     * Create file record for materi.
     */
    public function createFile(array $fileData): Model;

    /**
     * Find a file record by ID.
     */
    public function findFile(string $fileId): ?Model;

    /**
     * Delete a file record by ID.
     */
    public function deleteFile(string $fileId): bool;

    /**
     * Get files for a materi.
     */
    public function getFiles(string $materiId): Collection;

    /**
     * Count files attached to a materi.
     */
    public function countFiles(string $materiId): int;

    /**
     * Delete system notifications for a materi.
     */
    public function deleteNotifikasiSistem(string $materiId): int;

    /**
     * Create system notification for student.
     */
    public function createNotifikasiSistem(array $data): Model;
}
