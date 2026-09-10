<?php

namespace App\Services\Superadmin;

use App\Models\Ekstrakurikuler;
use App\Repositories\Contracts\UserManagement\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SuperadminService
{
    public function __construct(
        protected UserRepositoryInterface $userRepo
    ) {}

    // ================= GURU =================

    public function getPaginatedGuru(int $perPage = 5, ?string $search = null): LengthAwarePaginator
    {
        return $this->userRepo->getPaginatedGuru($perPage, $search);
    }

    public function findGuruOrFail(string $id): Model
    {
        return $this->userRepo->findGuruOrFail($id);
    }

    public function createGuru(array $data, $fotoFile = null): Model
    {
        $payload = [
            'nama_guru' => $data['nama_guru'],
            'nip' => $data['nip'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'alamat_guru' => $data['alamat_guru'] ?? null,
            'nomor_wa_guru' => $data['nomor_wa_guru'] ?? null,
            'email' => $data['email'],
            'role_guru' => $data['role_guru'] ?? 'guru',
        ];

        if ($fotoFile) {
            $fileName = time().'.'.$fotoFile->extension();
            $fotoFile->move(public_path('images/guru'), $fileName);
            $payload['foto_guru'] = $fileName;
        }

        return $this->userRepo->createGuru($payload);
    }

    public function updateGuru(string $id, array $data, $fotoFile = null): bool
    {
        $payload = [
            'nama_guru' => $data['nama_guru'],
            'nip' => $data['nip'],
            'username' => $data['username'],
            'alamat_guru' => $data['alamat_guru'] ?? null,
            'nomor_wa_guru' => $data['nomor_wa_guru'] ?? null,
            'email' => $data['email'],
            'role_guru' => $data['role_guru'] ?? 'guru',
        ];

        if (! empty($data['password'])) {
            $payload['password'] = bcrypt($data['password']);
        }

        if ($fotoFile) {
            $fileName = time().'.'.$fotoFile->extension();
            $fotoFile->move(public_path('images/guru'), $fileName);
            $payload['foto_guru'] = $fileName;
        }

        return $this->userRepo->updateGuru($id, $payload);
    }

    public function deleteGuru(string $id): bool
    {
        return $this->userRepo->deleteGuru($id);
    }

    // ================= SISWA =================

    public function getPaginatedSiswa(int $perPage = 5, ?string $search = null): LengthAwarePaginator
    {
        return $this->userRepo->getPaginatedSiswa($perPage, $search);
    }

    public function findSiswaOrFail(string $id): Model
    {
        return $this->userRepo->findSiswaOrFail($id);
    }

    public function createSiswa(array $data, $fotoFile = null): Model
    {
        $payload = [
            'nisn' => $data['nisn'],
            'nama_siswa' => $data['nama_siswa'],
            'tgl_lahir_siswa' => $data['tgl_lahir_siswa'] ?? null,
            'jenis_kelamin_siswa' => $data['jenis_kelamin_siswa'] ?? null,
            'alamat_siswa' => $data['alamat_siswa'] ?? null,
            'password' => bcrypt($data['password']),
            'nomor_wa_siswa' => $data['nomor_wa_siswa'] ?? null,
            'username' => $data['username'],
            'email' => $data['email'],
            'role_siswa' => $data['role_siswa'] ?? 'siswa',
        ];

        if ($fotoFile) {
            $fileName = time().'.'.$fotoFile->extension();
            $fotoFile->move(public_path('images/siswa'), $fileName);
            $payload['foto_siswa'] = $fileName;
        }

        return $this->userRepo->createSiswa($payload);
    }

    public function updateSiswa(string $id, array $data, $fotoFile = null): bool
    {
        $payload = [
            'nama_siswa' => $data['nama_siswa'],
            'nisn' => $data['nisn'],
            'username' => $data['username'],
            'alamat_siswa' => $data['alamat_siswa'] ?? null,
            'nomor_wa_siswa' => $data['nomor_wa_siswa'] ?? null,
            'email' => $data['email'],
            'jenis_kelamin_siswa' => $data['jenis_kelamin_siswa'] ?? null,
            'role_siswa' => $data['role_siswa'] ?? 'siswa',
            'tgl_lahir_siswa' => $data['tgl_lahir_siswa'] ?? null,
        ];

        if (! empty($data['password'])) {
            $payload['password'] = bcrypt($data['password']);
        }

        if ($fotoFile) {
            $fileName = time().'.'.$fotoFile->extension();
            $fotoFile->move(public_path('images/siswa'), $fileName);
            $payload['foto_siswa'] = $fileName;
        }

        return $this->userRepo->updateSiswa($id, $payload);
    }

    public function deleteSiswa(string $id): bool
    {
        return $this->userRepo->deleteSiswa($id);
    }

    // ================= STAFF AKADEMIK =================

    public function getAllStaffAkademik(): Collection
    {
        return $this->userRepo->getAllStaffAkademik();
    }

    public function findStaffAkademikOrFail(string $id): Model
    {
        return $this->userRepo->findStaffAkademikOrFail($id);
    }

    public function createStaffAkademik(array $data): Model
    {
        return $this->userRepo->createStaffAkademik($data);
    }

    public function updateStaffAkademik(string $id, array $data): bool
    {
        return $this->userRepo->updateStaffAkademik($id, $data);
    }

    public function deleteStaffAkademik(string $id): bool
    {
        return $this->userRepo->deleteStaffAkademik($id);
    }

    public function resetPasswordStaffAkademik(string $id): bool
    {
        return $this->userRepo->resetPasswordStaffAkademik($id);
    }

    // ================= STAFF PERPUS =================

    public function getAllStaffPerpus(): Collection
    {
        return $this->userRepo->getAllStaffPerpus();
    }

    public function findStaffPerpusOrFail(string $id): Model
    {
        return $this->userRepo->findStaffPerpusOrFail($id);
    }

    public function createStaffPerpus(array $data): Model
    {
        return $this->userRepo->createStaffPerpus($data);
    }

    public function updateStaffPerpus(string $id, array $data): bool
    {
        return $this->userRepo->updateStaffPerpus($id, $data);
    }

    public function deleteStaffPerpus(string $id): bool
    {
        return $this->userRepo->deleteStaffPerpus($id);
    }

    public function resetPasswordStaffPerpus(string $id): bool
    {
        return $this->userRepo->resetPasswordStaffPerpus($id);
    }

    // ================= PEMBINA EKSTRA =================

    public function getPaginatedPembina(int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepo->getPaginatedPembina($perPage);
    }

    public function getAvailableGuruForPembina(int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepo->getAvailableGuruForPembina($perPage);
    }

    public function setPembinaRole(string $guruId): bool
    {
        return $this->userRepo->setPembinaRole($guruId);
    }

    public function updatePembina(string $id, array $data): bool
    {
        $payload = $data;
        if (! empty($data['password'])) {
            $payload['password'] = bcrypt($data['password']);
        } else {
            unset($payload['password']);
        }

        return $this->userRepo->updateGuru($id, $payload);
    }

    public function removePembinaRole(string $guruId): bool
    {
        return $this->userRepo->removePembinaRole($guruId);
    }

    // ================= PENGURUS EKSTRA =================

    public function getPaginatedPengurus(int $perPage = 5, ?string $search = null): LengthAwarePaginator
    {
        return $this->userRepo->getPaginatedPengurus($perPage, $search);
    }

    public function getCreatePengurusFormData(): array
    {
        return [
            'siswa' => $this->userRepo->getAvailableSiswaForPengurus(),
            'ekstrakurikuler' => Ekstrakurikuler::all(),
        ];
    }

    public function getEditPengurusFormData(string $siswaId): array
    {
        return [
            'pengurus' => $this->userRepo->findSiswaOrFail($siswaId),
            'ekstrakurikuler' => Ekstrakurikuler::all(),
        ];
    }

    public function storePengurus(string $siswaId, string $ekstrakurikulerId, string $role): Model
    {
        if ($this->userRepo->isPengurusAssigned($siswaId, $ekstrakurikulerId)) {
            throw new Exception('Siswa ini sudah terdaftar di ekstrakurikuler tersebut.');
        }

        return $this->userRepo->assignPengurus($siswaId, $ekstrakurikulerId, $role);
    }

    public function updatePengurus(string $siswaId, string $ekstrakurikulerId, string $namaSiswa, string $role): bool
    {
        return $this->userRepo->updatePengurus($siswaId, $ekstrakurikulerId, $namaSiswa, $role);
    }

    public function deletePengurus(string $pengurusId): bool
    {
        return $this->userRepo->deletePengurus($pengurusId);
    }

    public function removePengurusRole(string $siswaId): bool
    {
        return $this->userRepo->removePengurusRoleBySiswaId($siswaId);
    }

    // ================= SUPERADMIN =================

    public function updateSuperadminProfile(string $adminId, array $data): bool
    {
        $payload = [
            'username' => $data['username'],
            'email' => $data['email'],
            'nama_superadmin' => $data['nama_superadmin'],
            'no_hp' => $data['no_hp'],
        ];

        if (! empty($data['new_password'])) {
            $payload['password'] = bcrypt($data['new_password']);
        }

        return $this->userRepo->updateSuperadminProfile($adminId, $payload);
    }
}
