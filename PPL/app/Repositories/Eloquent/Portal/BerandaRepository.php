<?php

namespace App\Repositories\Eloquent\Portal;

use App\Models\buku;
use App\Models\Ekstrakurikuler;
use App\Models\Guru;
use App\Models\PrestasiEkstrakurikuler;
use App\Models\Siswa;
use App\Repositories\Contracts\Portal\BerandaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BerandaRepository implements BerandaRepositoryInterface
{
    public function getLatestBooks(int $limit = 4): Collection
    {
        return buku::with(['kategoriBuku', 'jenisBuku'])
            ->orderBy('tgl_ditambahkan', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getAllTeachersWithSubjects(): Collection
    {
        return Guru::with(['gurumatapelajaran.mataPelajaran'])
            ->orderBy('nama_guru', 'asc')
            ->get();
    }

    public function getAllExtracurricularAchievements(): Collection
    {
        return PrestasiEkstrakurikuler::with('ekstrakurikuler')->get();
    }

    public function getSchoolStatistics(): array
    {
        return [
            'total_guru' => Guru::count(),
            'total_siswa' => Siswa::count(),
            'total_buku' => buku::count(),
            'total_ekskul' => Ekstrakurikuler::count(),
        ];
    }
}
