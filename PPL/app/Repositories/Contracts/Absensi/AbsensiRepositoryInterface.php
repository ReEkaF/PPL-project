<?php

namespace App\Repositories\Contracts\Absensi;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AbsensiRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get class subjects for student attendance page.
     */
    public function getStudentAttendanceSchedule(string $siswaId): Collection;

    /**
     * Find class subject with meetings and student attendance status.
     */
    public function findMeetingDetails(string $kmpId, string $siswaId): ?Model;

    /**
     * Mark attendance when scanning QR code.
     */
    public function markPresence(string $siswaId, string $pertemuanId): array;

    /**
     * Generate recurring meetings with QR codes and student default attendance rows.
     */
    public function generatePresenceData(string $kmpId, string $firstWeekDate, int $totalMeetings): void;

    /**
     * Reset all meetings and attendance records for a class subject.
     */
    public function resetPertemuan(string $kmpId): void;

    /**
     * Update bulk attendance statuses.
     */
    public function updateStatuses(array $statusAbsensi): void;

    /**
     * Update status of a single meeting (e.g. Aktif / Tidak Aktif).
     */
    public function updatePertemuanStatus(string $pertemuanId, string $status): bool;
}
