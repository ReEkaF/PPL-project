<?php

namespace App\Repositories\Contracts\UserManagement;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    // ================= GURU =================
    public function getPaginatedGuru(int $perPage = 5, ?string $search = null): LengthAwarePaginator;

    public function findGuruOrFail(string $id): Model;

    public function createGuru(array $data): Model;

    public function updateGuru(string $id, array $data): bool;

    public function deleteGuru(string $id): bool;

    // ================= SISWA =================
    public function getPaginatedSiswa(int $perPage = 5, ?string $search = null): LengthAwarePaginator;

    public function findSiswaOrFail(string $id): Model;

    public function createSiswa(array $data): Model;

    public function updateSiswa(string $id, array $data): bool;

    public function deleteSiswa(string $id): bool;

    // ================= STAFF AKADEMIK =================
    public function getAllStaffAkademik(): Collection;

    public function findStaffAkademikOrFail(string $id): Model;

    public function createStaffAkademik(array $data): Model;

    public function updateStaffAkademik(string $id, array $data): bool;

    public function deleteStaffAkademik(string $id): bool;

    public function resetPasswordStaffAkademik(string $id): bool;

    // ================= STAFF PERPUS =================
    public function getAllStaffPerpus(): Collection;

    public function findStaffPerpusOrFail(string $id): Model;

    public function createStaffPerpus(array $data): Model;

    public function updateStaffPerpus(string $id, array $data): bool;

    public function deleteStaffPerpus(string $id): bool;

    public function resetPasswordStaffPerpus(string $id): bool;

    // ================= PEMBINA EKSTRA =================
    public function getPaginatedPembina(int $perPage = 10): LengthAwarePaginator;

    public function getAvailableGuruForPembina(int $perPage = 10): LengthAwarePaginator;

    public function setPembinaRole(string $guruId): bool;

    public function removePembinaRole(string $guruId): bool;

    // ================= PENGURUS EKSTRA =================
    public function getPaginatedPengurus(int $perPage = 5, ?string $search = null): LengthAwarePaginator;

    public function getAvailableSiswaForPengurus(): Collection;

    public function isPengurusAssigned(string $siswaId, string $ekstrakurikulerId): bool;

    public function assignPengurus(string $siswaId, string $ekstrakurikulerId, string $role): Model;

    public function updatePengurus(string $siswaId, string $ekstrakurikulerId, string $namaSiswa, string $role): bool;

    public function deletePengurus(string $pengurusId): bool;

    public function removePengurusRoleBySiswaId(string $siswaId): bool;

    // ================= SUPERADMIN =================
    public function findSuperadminOrFail(string $id): Model;

    public function updateSuperadminProfile(string $adminId, array $data): bool;
}
