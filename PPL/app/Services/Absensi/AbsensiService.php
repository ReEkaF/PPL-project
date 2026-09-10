<?php

namespace App\Services\Absensi;

use App\Models\kelas;
use App\Models\kelas_mata_pelajaran;
use App\Models\pertemuan;
use App\Repositories\Contracts\Absensi\AbsensiRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AbsensiService
{
    public function __construct(
        protected AbsensiRepositoryInterface $absensiRepo
    ) {}

    // ================= STAFF AKADEMIK =================

    public function getStaffIndexData(?string $kelasId = null): array
    {
        $allKelas = kelas::orderByRaw('LENGTH(nama_kelas)')
            ->orderBy('nama_kelas')
            ->get();

        $query = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'guru', 'hari'])
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->orderByRaw('LENGTH(kelas.nama_kelas)')
            ->orderBy('kelas.nama_kelas')
            ->orderBy('hari_id')
            ->orderBy('waktu_mulai')
            ->select('kelas_mata_pelajaran.*');

        if ($kelasId) {
            $query->where('kelas_mata_pelajaran.kelas_id', $kelasId);
        }

        return [
            'data' => $query->get(),
            'allKelas' => $allKelas,
        ];
    }

    public function getStaffMeetingList(string $kmpId): Model
    {
        return kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'guru', 'hari', 'pertemuan'])
            ->where('id_kelas_mata_pelajaran', $kmpId)
            ->firstOrFail();
    }

    public function getStaffMeetingDetails(string $kmpId, string $pertemuanId): array
    {
        $detail = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'guru', 'hari'])
            ->where('id_kelas_mata_pelajaran', $kmpId)
            ->firstOrFail();

        $students = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.siswa_id', '=', 'siswa.id_siswa')
            ->where('absensi_siswa.pertemuan_id', $pertemuanId)
            ->orderBy('siswa.nisn')
            ->select('absensi_siswa.*', 'siswa.nisn', 'siswa.nama_siswa')
            ->get();

        $pertemuan = pertemuan::find($pertemuanId);

        return [
            'detail' => $detail,
            'students' => $students,
            'pertemuan' => $pertemuan,
        ];
    }

    public function generatePresenceData(string $kmpId, string $firstWeekDate, int $totalMeetings): void
    {
        $this->absensiRepo->generatePresenceData($kmpId, $firstWeekDate, $totalMeetings);
    }

    public function resetPertemuan(string $kmpId): void
    {
        $this->absensiRepo->resetPertemuan($kmpId);
    }

    public function updateStatuses(array $statusAbsensi): void
    {
        $this->absensiRepo->updateStatuses($statusAbsensi);
    }

    public function updatePertemuanStatus(string $pertemuanId, string $status): bool
    {
        return $this->absensiRepo->updatePertemuanStatus($pertemuanId, $status);
    }

    // ================= GURU =================

    public function getGuruIndexData(string $guruId, ?string $kelasId = null): array
    {
        $allKelas = kelas::whereHas('kelasmatapelajaran', function ($query) use ($guruId) {
            $query->where('guru_id', $guruId);
        })->orderByRaw('LENGTH(nama_kelas)')
            ->orderBy('nama_kelas')
            ->get();

        $query = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'guru', 'hari'])
            ->where('guru_id', $guruId)
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->orderByRaw('LENGTH(kelas.nama_kelas)')
            ->orderBy('kelas.nama_kelas')
            ->orderBy('hari_id')
            ->orderBy('waktu_mulai')
            ->select('kelas_mata_pelajaran.*');

        if ($kelasId) {
            $query->where('kelas_mata_pelajaran.kelas_id', $kelasId);
        }

        return [
            'data' => $query->get(),
            'allKelas' => $allKelas,
        ];
    }

    // ================= SISWA =================

    public function getSiswaSchedule(string $siswaId): Collection
    {
        return $this->absensiRepo->getStudentAttendanceSchedule($siswaId);
    }

    public function getSiswaMeetingDetails(string $kmpId, string $siswaId): ?Model
    {
        return $this->absensiRepo->findMeetingDetails($kmpId, $siswaId);
    }

    public function scanQrCode(string $siswaId, string $pertemuanId): array
    {
        return $this->absensiRepo->markPresence($siswaId, $pertemuanId);
    }
}
