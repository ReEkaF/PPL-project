<?php

namespace App\Services\Akademik;

use App\Models\Guru;
use App\Models\mata_pelajaran;
use App\Models\Siswa;
use App\Models\tahun_ajaran;
use App\Repositories\Contracts\Akademik\KelasRepositoryInterface;
use App\Repositories\Contracts\Akademik\MataPelajaranRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AkademikManagementService
{
    public function __construct(
        protected KelasRepositoryInterface $kelasRepo,
        protected MataPelajaranRepositoryInterface $matpelRepo
    ) {}

    // ================= MATA PELAJARAN =================

    public function getPaginatedMataPelajaran(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->matpelRepo->getPaginatedMatpel($search, $perPage);
    }

    public function createMataPelajaran(array $data): Model
    {
        return $this->matpelRepo->create($data);
    }

    public function updateMataPelajaran(string $id, array $data): bool
    {
        return $this->matpelRepo->update($id, $data);
    }

    public function deleteMataPelajaran(string $id): bool
    {
        return $this->matpelRepo->delete($id);
    }

    // ================= KELAS =================

    public function getPaginatedKelas(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->kelasRepo->getPaginatedClasses($search, $perPage);
    }

    public function createKelas(array $data): Model
    {
        return $this->kelasRepo->create($data);
    }

    public function updateKelas(string $id, array $data): bool
    {
        return $this->kelasRepo->update($id, $data);
    }

    public function deleteKelas(string $id): bool
    {
        return $this->kelasRepo->delete($id);
    }

    // ================= GURU MATA PELAJARAN =================

    public function getPaginatedGuruMatpel(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->matpelRepo->getPaginatedGuruMataPelajaran($search, $perPage);
    }

    public function getGuruMatpelFormData(): array
    {
        return [
            'gurus' => Guru::all(),
            'mataPelajaran' => mata_pelajaran::all(),
        ];
    }

    public function assignGuruMatpel(string $guruId, string $matpelId): Model
    {
        return $this->matpelRepo->assignGuruMatpel($guruId, $matpelId);
    }

    public function updateGuruMatpel(int|string $id, string $guruId, string $matpelId): bool
    {
        return $this->matpelRepo->updateGuruMatpel($id, $guruId, $matpelId);
    }

    public function deleteGuruMatpel(int|string $id): bool
    {
        return $this->matpelRepo->deleteGuruMatpel($id);
    }

    // ================= MANAGEMENT KELAS & SISWA =================

    public function getAllKelasWithStudentCount(): Collection
    {
        return $this->kelasRepo->getAllWithStudentCount();
    }

    public function getKelasDetailWithStudents(string $idKelas): Model
    {
        $kelas = $this->kelasRepo->findWithStudentsAndWali($idKelas);
        if (! $kelas) {
            throw new Exception('Kelas tidak ditemukan.');
        }

        return $kelas;
    }

    public function getTambahSiswaData(string $idKelas): array
    {
        $kelas = $this->kelasRepo->findOrFail($idKelas);
        $siswa = Siswa::whereDoesntHave('kelas')->get();

        return [
            'kelas' => $kelas,
            'siswa' => $siswa,
        ];
    }

    public function addStudentsToKelas(string $idKelas, array $siswaIds): void
    {
        $tahunAjaranAktif = tahun_ajaran::where('aktif', 1)->value('id_tahun_ajaran');
        if (! $tahunAjaranAktif) {
            throw new Exception('Tahun ajaran aktif tidak ditemukan.');
        }

        foreach ($siswaIds as $siswaId) {
            $this->kelasRepo->attachStudent($idKelas, $siswaId, $tahunAjaranAktif);
        }
    }

    public function removeStudentFromKelas(string $idKelas, string $idSiswa): void
    {
        $this->kelasRepo->detachStudent($idKelas, $idSiswa);
    }

    public function removeStudentsMassalFromKelas(string $idKelas, array $siswaIds): void
    {
        $this->kelasRepo->detachStudents($idKelas, $siswaIds);
    }

    public function getEditWaliKelasData(string $idKelas): array
    {
        $kelas = $this->kelasRepo->findOrFail($idKelas);
        $gurus = Guru::whereDoesntHave('kelasSiswas')->get();

        return [
            'kelas' => $kelas,
            'gurus' => $gurus,
        ];
    }

    public function updateWaliKelas(string $idKelas, ?string $waliKelasId): void
    {
        $this->kelasRepo->updateWaliKelas($idKelas, $waliKelasId);
    }
}
