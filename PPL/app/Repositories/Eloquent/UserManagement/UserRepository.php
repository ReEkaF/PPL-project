<?php

namespace App\Repositories\Eloquent\UserManagement;

use App\Models\Guru;
use App\Models\PengurusEkstra;
use App\Models\Siswa;
use App\Models\Staffakademik;
use App\Models\Staffperpus;
use App\Models\Superadmin;
use App\Repositories\Contracts\UserManagement\UserRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(
        Superadmin $model,
        protected Guru $guruModel,
        protected Siswa $siswaModel,
        protected Staffakademik $staffAkademikModel,
        protected Staffperpus $staffPerpusModel,
        protected PengurusEkstra $pengurusEkstraModel
    ) {
        parent::__construct($model);
    }

    // ================= GURU =================

    public function getPaginatedGuru(int $perPage = 5, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->guruModel->query();

        if ($search) {
            $query->where('nip', 'LIKE', '%'.$search.'%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findGuruOrFail(string $id): Model
    {
        return $this->guruModel->findOrFail($id);
    }

    public function createGuru(array $data): Model
    {
        return $this->guruModel->create($data);
    }

    public function updateGuru(string $id, array $data): bool
    {
        $guru = $this->findGuruOrFail($id);

        return $guru->update($data);
    }

    public function deleteGuru(string $id): bool
    {
        $guru = $this->findGuruOrFail($id);

        return (bool) $guru->delete();
    }

    // ================= SISWA =================

    public function getPaginatedSiswa(int $perPage = 5, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->siswaModel->query();

        if ($search) {
            $query->where('nisn', 'LIKE', '%'.$search.'%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findSiswaOrFail(string $id): Model
    {
        return $this->siswaModel->findOrFail($id);
    }

    public function createSiswa(array $data): Model
    {
        return $this->siswaModel->create($data);
    }

    public function updateSiswa(string $id, array $data): bool
    {
        $siswa = $this->findSiswaOrFail($id);

        return $siswa->update($data);
    }

    public function deleteSiswa(string $id): bool
    {
        $siswa = $this->findSiswaOrFail($id);

        return (bool) $siswa->delete();
    }

    // ================= STAFF AKADEMIK =================

    public function getAllStaffAkademik(): Collection
    {
        return $this->staffAkademikModel->all();
    }

    public function findStaffAkademikOrFail(string $id): Model
    {
        return $this->staffAkademikModel->where('id_staff_akademik', $id)->firstOrFail();
    }

    public function createStaffAkademik(array $data): Model
    {
        return $this->staffAkademikModel->create($data);
    }

    public function updateStaffAkademik(string $id, array $data): bool
    {
        $staff = $this->staffAkademikModel->where('id_staff_akademik', $id)->firstOrFail();

        return $staff->update($data);
    }

    public function deleteStaffAkademik(string $id): bool
    {
        $staff = $this->staffAkademikModel->where('id_staff_akademik', $id)->firstOrFail();

        return (bool) $staff->delete();
    }

    public function resetPasswordStaffAkademik(string $id): bool
    {
        $staff = $this->staffAkademikModel->where('id_staff_akademik', $id)->firstOrFail();
        $staff->password = bcrypt($staff->username);

        return $staff->save();
    }

    // ================= STAFF PERPUS =================

    public function getAllStaffPerpus(): Collection
    {
        return $this->staffPerpusModel->all();
    }

    public function findStaffPerpusOrFail(string $id): Model
    {
        return $this->staffPerpusModel->where('id_staff_perpustakaan', $id)->firstOrFail();
    }

    public function createStaffPerpus(array $data): Model
    {
        return $this->staffPerpusModel->create($data);
    }

    public function updateStaffPerpus(string $id, array $data): bool
    {
        $staff = $this->staffPerpusModel->where('id_staff_perpustakaan', $id)->firstOrFail();

        return $staff->update($data);
    }

    public function deleteStaffPerpus(string $id): bool
    {
        $staff = $this->staffPerpusModel->where('id_staff_perpustakaan', $id)->firstOrFail();

        return (bool) $staff->delete();
    }

    public function resetPasswordStaffPerpus(string $id): bool
    {
        $staff = $this->staffPerpusModel->where('id_staff_perpustakaan', $id)->firstOrFail();
        $staff->password = bcrypt($staff->username);

        return $staff->save();
    }

    // ================= PEMBINA EKSTRA =================

    public function getPaginatedPembina(int $perPage = 10): LengthAwarePaginator
    {
        return $this->guruModel->where('role_guru', 'pembina')
            ->with('ekstrakurikuler')
            ->orderBy('updated_at', 'DESC')
            ->paginate($perPage);
    }

    public function getAvailableGuruForPembina(int $perPage = 10): LengthAwarePaginator
    {
        return $this->guruModel->where('role_guru', 'guru')
            ->latest()
            ->paginate($perPage);
    }

    public function setPembinaRole(string $guruId): bool
    {
        $guru = $this->findGuruOrFail($guruId);

        return $guru->update(['role_guru' => 'pembina']);
    }

    public function removePembinaRole(string $guruId): bool
    {
        $guru = $this->findGuruOrFail($guruId);

        return $guru->update(['role_guru' => 'guru']);
    }

    // ================= PENGURUS EKSTRA =================

    public function getPaginatedPengurus(int $perPage = 5, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->siswaModel->where('role_siswa', 'pengurus')->with('pengurusEkstra');

        if ($search) {
            $query->where('nama_siswa', 'LIKE', '%'.$search.'%');
        }

        return $query->paginate($perPage);
    }

    public function getAvailableSiswaForPengurus(): Collection
    {
        return $this->siswaModel->where('role_siswa', 'siswa')->get();
    }

    public function isPengurusAssigned(string $siswaId, string $ekstrakurikulerId): bool
    {
        return $this->pengurusEkstraModel->where('id_siswa', $siswaId)
            ->where('id_ekstrakurikuler', $ekstrakurikulerId)
            ->exists();
    }

    public function assignPengurus(string $siswaId, string $ekstrakurikulerId, string $role): Model
    {
        return DB::transaction(function () use ($siswaId, $ekstrakurikulerId, $role) {
            $pengurus = $this->pengurusEkstraModel->create([
                'id_siswa' => $siswaId,
                'id_ekstrakurikuler' => $ekstrakurikulerId,
            ]);

            $siswa = $this->findSiswaOrFail($siswaId);
            $siswa->update(['role_siswa' => $role]);

            return $pengurus;
        });
    }

    public function updatePengurus(string $siswaId, string $ekstrakurikulerId, string $namaSiswa, string $role): bool
    {
        return DB::transaction(function () use ($siswaId, $ekstrakurikulerId, $namaSiswa, $role) {
            $pengurus = $this->pengurusEkstraModel->where('id_siswa', $siswaId)->first();
            if ($pengurus) {
                $pengurus->update(['id_ekstrakurikuler' => $ekstrakurikulerId]);
            } else {
                $this->pengurusEkstraModel->create([
                    'id_siswa' => $siswaId,
                    'id_ekstrakurikuler' => $ekstrakurikulerId,
                ]);
            }

            $siswa = $this->findSiswaOrFail($siswaId);

            return $siswa->update([
                'nama_siswa' => $namaSiswa,
                'role_siswa' => $role,
            ]);
        });
    }

    public function deletePengurus(string $pengurusId): bool
    {
        $pengurus = $this->pengurusEkstraModel->findOrFail($pengurusId);

        return (bool) $pengurus->delete();
    }

    public function removePengurusRoleBySiswaId(string $siswaId): bool
    {
        return DB::transaction(function () use ($siswaId) {
            $this->pengurusEkstraModel->where('id_siswa', $siswaId)->delete();
            $siswa = $this->findSiswaOrFail($siswaId);

            return $siswa->update(['role_siswa' => 'siswa']);
        });
    }

    // ================= SUPERADMIN =================

    public function findSuperadminOrFail(string $id): Model
    {
        return $this->model->where('id_admin', $id)->firstOrFail();
    }

    public function updateSuperadminProfile(string $adminId, array $data): bool
    {
        $admin = $this->model->where('id_admin', $adminId)->firstOrFail();

        return $admin->update($data);
    }

    public function getDashboardStats(): array
    {
        return [
            'totalGuru' => $this->guruModel->count(),
            'totalSiswa' => $this->siswaModel->count(),
            'totalStaffAkademik' => $this->staffAkademikModel->count(),
            'totalStaffPerpus' => $this->staffPerpusModel->count(),
            'totalPembina' => $this->guruModel->where('role_guru', 'pembina')->count(),
            'totalPengurus' => $this->siswaModel->where('role_siswa', 'pengurus')->count(),
        ];
    }
}
