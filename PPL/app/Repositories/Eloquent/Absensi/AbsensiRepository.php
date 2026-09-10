<?php

namespace App\Repositories\Eloquent\Absensi;

use App\Models\absensi_siswa;
use App\Models\kelas_mata_pelajaran;
use App\Models\pertemuan;
use App\Models\Siswa;
use App\Repositories\Contracts\Absensi\AbsensiRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AbsensiRepository extends BaseRepository implements AbsensiRepositoryInterface
{
    public function __construct(kelas_mata_pelajaran $model)
    {
        parent::__construct($model);
    }

    public function getStudentAttendanceSchedule(string $siswaId): Collection
    {
        return $this->model
            ->with([
                'kelas',
                'mataPelajaran',
                'guru',
                'hari',
                'pertemuan' => function ($query) use ($siswaId) {
                    $query->with(['absensiSiswa' => fn ($q) => $q->where('siswa_id', $siswaId)])
                        ->orderBy('tanggal_pertemuan');
                },
            ])
            ->whereHas('kelas.kelas_siswa', fn ($q) => $q->where('id_siswa', $siswaId))
            ->orderBy('hari_id')
            ->orderBy('waktu_mulai')
            ->get();
    }

    public function findMeetingDetails(string $kmpId, string $siswaId): ?Model
    {
        return $this->model
            ->with([
                'kelas',
                'mataPelajaran',
                'guru',
                'hari',
                'pertemuan' => function ($query) use ($siswaId) {
                    $query->with(['absensiSiswa' => fn ($q) => $q->where('siswa_id', $siswaId)])
                        ->orderBy('tanggal_pertemuan');
                },
            ])
            ->find($kmpId);
    }


    public function markPresence(string $siswaId, string $pertemuanId): array
    {
        $absensi = absensi_siswa::where('siswa_id', $siswaId)
            ->where('pertemuan_id', $pertemuanId)
            ->first();

        $pertemuan = pertemuan::find($pertemuanId);
        if (! $pertemuan) {
            return [
                'status' => 'error',
                'message' => 'Pertemuan tidak ditemukan.',
                'kmp_id' => null,
            ];
        }

        $kmpId = $pertemuan->kelas_mata_pelajaran_id;

        $isEnrolled = absensi_siswa::where('siswa_id', $siswaId)
            ->whereHas('pertemuan', fn ($q) => $q->where('kelas_mata_pelajaran_id', $kmpId))
            ->exists();

        if (! $isEnrolled) {
            return [
                'status' => 'not_enrolled',
                'message' => 'Anda tidak terdaftar pada kelas mata pelajaran ini.',
                'kmp_id' => $kmpId,
            ];
        }

        if ($absensi) {
            if ($pertemuan->status !== 'Aktif') {
                return [
                    'status' => 'error',
                    'message' => 'Status pertemuan sedang tidak aktif',
                    'kmp_id' => $kmpId,
                ];
            }

            if ($absensi->status_absensi === 'Hadir') {
                return [
                    'status' => 'info',
                    'message' => 'Anda sudah melakukan absensi kehadiran',
                    'kmp_id' => $kmpId,
                ];
            }

            $absensi->update(['status_absensi' => 'Hadir']);

            return [
                'status' => 'success',
                'message' => 'Status kehadiran berhasil diupdate',
                'kmp_id' => $kmpId,
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Gagal memperbarui status absensi.',
            'kmp_id' => $kmpId,
        ];
    }

    public function generatePresenceData(string $kmpId, string $firstWeekDate, int $totalMeetings): void
    {
        DB::transaction(function () use ($kmpId, $firstWeekDate, $totalMeetings) {
            $kmp = $this->find($kmpId);
            $idKelas = $kmp->kelas_id;

            $siswaList = Siswa::whereHas('kelassiswa', fn ($q) => $q->where('id_kelas', $idKelas))->get();

            for ($i = 0; $i < $totalMeetings; $i++) {
                $meetingDate = date('Y-m-d', strtotime($firstWeekDate." + $i week"));

                $pertemuan = pertemuan::create([
                    'kelas_mata_pelajaran_id' => $kmpId,
                    'tanggal_pertemuan' => $meetingDate,
                    'qr_code' => '',
                ]);

                $qrCodeUrl = route('siswa.absensi.scan', ['pertemuan_id' => $pertemuan->id_pertemuan]);

                $renderer = new ImageRenderer(
                    new RendererStyle(200),
                    new SvgImageBackEnd
                );
                $writer = new Writer($renderer);
                $qrCodeSvg = $writer->writeString($qrCodeUrl);

                if (! Storage::disk('public')->exists('qr_codes')) {
                    Storage::disk('public')->makeDirectory('qr_codes');
                }

                $filePath = 'qr_codes/'.$pertemuan->id_pertemuan.'.svg';
                Storage::disk('public')->put($filePath, $qrCodeSvg);

                $pertemuan->update(['qr_code' => $filePath]);

                foreach ($siswaList as $siswa) {
                    absensi_siswa::create([
                        'siswa_id' => $siswa->id_siswa,
                        'pertemuan_id' => $pertemuan->id_pertemuan,
                        'status_absensi' => 'Alpa',
                    ]);
                }
            }
        });
    }

    public function resetPertemuan(string $kmpId): void
    {
        DB::transaction(function () use ($kmpId) {
            $pertemuans = pertemuan::where('kelas_mata_pelajaran_id', $kmpId)->get();

            foreach ($pertemuans as $p) {
                if ($p->qr_code && Storage::disk('public')->exists($p->qr_code)) {
                    Storage::disk('public')->delete($p->qr_code);
                }
            }

            $pertemuanIds = $pertemuans->pluck('id_pertemuan');
            absensi_siswa::whereIn('pertemuan_id', $pertemuanIds)->delete();
            pertemuan::where('kelas_mata_pelajaran_id', $kmpId)->delete();
        });
    }

    public function updateStatuses(array $statusAbsensi): void
    {
        foreach ($statusAbsensi as $id => $status) {
            absensi_siswa::where('id_absensi_siswa', $id)->update(['status_absensi' => $status]);
        }
    }

    public function updatePertemuanStatus(string $pertemuanId, string $status): bool
    {
        $pertemuan = pertemuan::find($pertemuanId);
        if ($pertemuan) {
            $pertemuan->status = $status;
            return (bool) $pertemuan->save();
        }
        return false;
    }
}
