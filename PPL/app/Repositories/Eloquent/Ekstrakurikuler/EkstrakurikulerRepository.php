<?php

namespace App\Repositories\Eloquent\Ekstrakurikuler;

use App\Models\Berkas;
use App\Models\ekstrakurikuler;
use App\Models\PengurusEkstra;
use App\Models\RegistrasiEkstrakurikuler;
use App\Repositories\Contracts\Ekstrakurikuler\EkstrakurikulerRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EkstrakurikulerRepository extends BaseRepository implements EkstrakurikulerRepositoryInterface
{
    public function __construct(ekstrakurikuler $model)
    {
        parent::__construct($model);
    }

    public function getOpenEkstrakurikuler(): Collection
    {
        return $this->model->where('status', 'buka')->get();
    }

    public function findByGuruId(string $guruId): ?Model
    {
        return $this->model->with('pembinaEkstra')->where('guru_id', $guruId)->first();
    }

    public function findByPengurusSiswaId(string $siswaId): ?Model
    {
        $pengurus = PengurusEkstra::with('ekstrakurikuler')->where('id_siswa', $siswaId)->first();

        return $pengurus?->ekstrakurikuler;
    }

    public function registerStudent(string $siswaId, array $ekstraIds, array $data, ?string $fileIzin = null, ?string $fileDokter = null): void
    {
        DB::transaction(function () use ($siswaId, $ekstraIds, $data, $fileIzin, $fileDokter) {
            foreach ($ekstraIds as $idEkstra) {
                $registration = RegistrasiEkstrakurikuler::create([
                    'id_siswa' => $siswaId,
                    'id_ekstrakurikuler' => $idEkstra,
                    'riwayat_penyakit' => $data['riwayat_penyakit'] ?? null,
                    'alasan' => $data['alasan_ekskul'] ?? null,
                    'no_ortu' => $data['no_hp_orangtua'] ?? null,
                    'status' => 'menunggu',
                    'tgl_registrasi' => now(),
                ]);

                if ($fileIzin || $fileDokter) {
                    Berkas::create([
                        'id_registrasi' => $registration->id_registrasi,
                        'surat_izin_ortu' => $fileIzin,
                        'surat_riwayat_penyakit' => $fileDokter,
                    ]);
                }
            }
        });
    }

    public function getMembers(string $idEkstra): Collection
    {
        return RegistrasiEkstrakurikuler::with('siswa')
            ->where('id_ekstrakurikuler', $idEkstra)
            ->latest('tgl_registrasi')
            ->get();
    }

    public function updateMemberStatus(string $idEkstra, string $idSiswa, string $status): bool
    {
        $registration = RegistrasiEkstrakurikuler::where('id_siswa', $idSiswa)
            ->where('id_ekstrakurikuler', $idEkstra)
            ->first();

        if ($registration) {
            return (bool) $registration->update(['status' => $status]);
        }

        return false;
    }
}
