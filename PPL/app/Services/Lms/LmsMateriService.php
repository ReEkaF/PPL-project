<?php

namespace App\Services\Lms;

use App\Jobs\NotifikasiMateri;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;
use App\Models\notifikasi_sistem;
use App\Models\Siswa;
use App\Models\topik;
use App\Repositories\Contracts\Lms\MateriRepositoryInterface;
use App\Repositories\Contracts\Lms\TopikRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LmsMateriService
{
    public function __construct(
        protected MateriRepositoryInterface $materiRepo,
        protected TopikRepositoryInterface $topikRepo
    ) {}

    /**
     * Get data for teacher's materi index page.
     */
    public function getGuruMateriIndexData(string $guruId): array
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guruId)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('aktif', 1))
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->select('kelas_mata_pelajaran.*')
            ->get();

        $kmpIds = $kelasMataPelajaran->pluck('id_kelas_mata_pelajaran')->toArray();
        $materi = $this->materiRepo->getByKelasMataPelajaranIds($kmpIds, true);
        $materiBaru = $this->materiRepo->getRecentMateri($kmpIds);

        $materiBaruDate = $materiBaru->pluck('updated_at')->map(function ($date) {
            return $date ? $date->format('d F Y') : null;
        })->filter()->unique()->values();

        return [
            'kelas_mata_pelajaran' => $kelasMataPelajaran,
            'materi' => $materi,
            'materi_baru' => $materiBaru,
            'materi_baru_date' => $materiBaruDate,
        ];
    }

    /**
     * Get detail of a materi.
     */
    public function getMateriDetail(string $id): array
    {
        $materi = $this->materiRepo->findWithDetails($id);
        if (! $materi) {
            throw new Exception('Materi tidak ditemukan.');
        }

        $fileMateri = $this->materiRepo->getFiles($id);

        return [
            'materi' => $materi,
            'file_materi' => $fileMateri,
        ];
    }

    /**
     * Get create view data for teacher.
     */
    public function getCreateViewData(string $guruId): array
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guruId)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('aktif', 1))
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->select('kelas_mata_pelajaran.*')
            ->get();

        $kmpIds = $kelasMataPelajaran->pluck('id_kelas_mata_pelajaran')->toArray();
        $topik = topik::with('kelasMataPelajaran')
            ->whereIn('kelas_mata_pelajaran_id', $kmpIds)
            ->get();

        return [
            'kelas_mata_pelajaran' => $kelasMataPelajaran,
            'topik' => $topik,
        ];
    }

    /**
     * Get create form data for a specific class subject.
     */
    public function getCreateFormData(string $kmpId): array
    {
        $kmp = kelas_mata_pelajaran::with(['mataPelajaran', 'kelas'])->findOrFail($kmpId);
        $topik = $this->topikRepo->getByKelasMataPelajaranId($kmpId);
        $materiOld = $this->materiRepo->getModel()
            ->where('kelas_mata_pelajaran_id', $kmpId)
            ->where('status', 0)
            ->first();

        $fileMateriOld = $materiOld ? $this->materiRepo->getFiles($materiOld->id_materi) : collect();

        return [
            'id' => $kmpId,
            'kelas_mata_pelajaran' => $kmp,
            'topik' => $topik,
            'materi_old' => $materiOld,
            'file_materi_old' => $fileMateriOld,
            'mata_pelajaran' => $kmp->mataPelajaran,
        ];
    }

    /**
     * Store or draft a materi with attachments and notifications.
     */
    public function storeMateri(array $data, ?array $files = null, array $removedFiles = [], bool $isPublish = false, ?string $materiId = null): Model
    {
        return DB::transaction(function () use ($data, $files, $removedFiles, $isPublish, $materiId) {
            $status = $isPublish ? 1 : 0;
            $payload = [
                'kelas_mata_pelajaran_id' => $data['id_kelas_mata_pelajaran'],
                'topik_id' => $data['topik_id'] ?? null,
                'judul_materi' => $data['judul_materi'],
                'deskripsi' => $data['deskripsi'] ?? null,
                'status' => $status,
            ];

            if ($materiId) {
                $materi = $this->materiRepo->find($materiId);
                $materi->update($payload);
            } else {
                $materi = $this->materiRepo->create($payload);
            }

            // Remove deleted files
            $this->removePhysicalFiles($removedFiles);

            // Upload new files
            if ($files) {
                $this->handleFileUploads($files, $materi->id_materi);
            }

            if ($isPublish) {
                $this->dispatchPublishNotifications($materi, $data['id_kelas_mata_pelajaran'], 'store');
            }

            return $materi;
        });
    }

    /**
     * Get edit form data.
     */
    public function getEditData(string $id): array
    {
        $materi = $this->materiRepo->findWithDetails($id);
        if (! $materi) {
            throw new Exception('Materi tidak ditemukan.');
        }

        $kmp = kelas_mata_pelajaran::with(['mataPelajaran', 'kelas'])->findOrFail($materi->kelas_mata_pelajaran_id);
        $topik = $this->topikRepo->getByKelasMataPelajaranId($kmp->id_kelas_mata_pelajaran);
        $fileMateriOld = $this->materiRepo->getFiles($id);

        return [
            'id' => $id,
            'materi' => $materi,
            'kelas_mata_pelajaran' => $kmp,
            'topik' => $topik,
            'file_materi_old' => $fileMateriOld,
            'mata_pelajaran' => $kmp->mataPelajaran,
        ];
    }

    /**
     * Update an existing materi.
     */
    public function updateMateri(string $id, array $data, ?array $files = null, array $removedFiles = []): Model
    {
        return DB::transaction(function () use ($id, $data, $files, $removedFiles) {
            $materi = $this->materiRepo->find($id);
            if (! $materi) {
                throw new Exception('Materi tidak ditemukan.');
            }

            $materi->update([
                'kelas_mata_pelajaran_id' => $data['id_kelas_mata_pelajaran'],
                'topik_id' => $data['topik_id'] ?? null,
                'judul_materi' => $data['judul_materi'],
                'deskripsi' => $data['deskripsi'] ?? null,
                'updated_at' => now(),
            ]);

            $this->removePhysicalFiles($removedFiles);

            if ($files) {
                $this->handleFileUploads($files, $id);
            }

            $this->dispatchPublishNotifications($materi, $data['id_kelas_mata_pelajaran'], 'update');

            return $materi;
        });
    }

    /**
     * Destroy a materi and its files.
     */
    public function deleteMateri(string $id): bool
    {
        return DB::transaction(function () use ($id) {
            $materi = $this->materiRepo->find($id);
            if (! $materi) {
                return false;
            }

            $files = $this->materiRepo->getFiles($id);
            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file->file_path)) {
                    Storage::disk('public')->delete($file->file_path);
                }
                $file->delete();
            }

            $this->materiRepo->deleteNotifikasiSistem($id);

            return (bool) $materi->delete();
        });
    }

    /**
     * Get materi list for a student.
     */
    public function getSiswaMateriIndexData(string $siswaId): array
    {
        $kelasSiswa = KelasSiswa::where('id_siswa', $siswaId)->get();
        $kelasIds = $kelasSiswa->pluck('id_kelas')->toArray();

        $kelasMataPelajaran = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran'])
            ->whereIn('kelas_id', $kelasIds)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('aktif', 1))
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->select('kelas_mata_pelajaran.*')
            ->get();

        $kmpIds = $kelasMataPelajaran->pluck('id_kelas_mata_pelajaran')->toArray();
        $materi = $this->materiRepo->getByKelasMataPelajaranIds($kmpIds, true);
        $materiBaru = $this->materiRepo->getRecentMateri($kmpIds);

        $materiBaruDate = $materiBaru->pluck('updated_at')->map(function ($date) {
            return $date ? $date->format('d F Y') : null;
        })->filter()->unique()->values();

        return [
            'kelas_siswa' => $kelasSiswa,
            'kelas_mata_pelajaran' => $kelasMataPelajaran,
            'materi' => $materi,
            'materi_baru' => $materiBaru,
            'materi_baru_date' => $materiBaruDate,
        ];
    }

    /**
     * Get student materi detail and mark notification as read.
     */
    public function getSiswaMateriDetail(string $id, string $siswaId): array
    {
        $materi = $this->materiRepo->findWithDetails($id);
        if (! $materi) {
            throw new Exception('Materi tidak ditemukan.');
        }

        $fileMateri = $this->materiRepo->getFiles($id);

        $notifikasi = notifikasi_sistem::where('siswa_id', $siswaId)
            ->where('materi_id', $id)
            ->first();

        if ($notifikasi && $notifikasi->status == 0) {
            $notifikasi->update(['status' => 1, 'tanggal_dilihat' => now()]);
            $unreadCount = notifikasi_sistem::where('siswa_id', $siswaId)->where('status', 0)->count();
            session()->put('notifikasi_count', $unreadCount);
        }

        return [
            'materi' => $materi,
            'file_materi' => $fileMateri,
        ];
    }

    protected function removePhysicalFiles(array $removedFileIds): void
    {
        foreach ($removedFileIds as $fileId) {
            $file = $this->materiRepo->findFile($fileId);
            if ($file) {
                if (Storage::disk('public')->exists($file->file_path)) {
                    Storage::disk('public')->delete($file->file_path);
                }
                $file->delete();
            }
        }
    }

    protected function handleFileUploads(array $files, string $materiId): void
    {
        foreach ($files as $file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/file_materi', $fileName, 'public');
            $fileType = $file->getClientMimeType();

            $this->materiRepo->createFile([
                'materi_id' => $materiId,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $fileType,
                'upload_at' => now(),
                'status' => 1,
            ]);
        }
    }

    protected function dispatchPublishNotifications(Model $materi, string $kmpId, string $action = 'store'): void
    {
        $kmp = kelas_mata_pelajaran::with(['kelas.siswa', 'mataPelajaran'])->findOrFail($kmpId);

        if ($action === 'store') {
            foreach ($kmp->kelas->siswa as $student) {
                $this->materiRepo->createNotifikasiSistem([
                    'materi_id' => $materi->id_materi,
                    'siswa_id' => $student->id_siswa,
                    'status' => 0,
                ]);
            }
        }

        $siswaNomorWhatsApp = Siswa::whereHas('kelas', function ($query) use ($materi) {
            $query->whereHas('kelasMataPelajaran', function ($sub) use ($materi) {
                $sub->where('id_kelas_mata_pelajaran', $materi->kelas_mata_pelajaran_id);
            });
        })->pluck('nomor_wa_siswa')->filter()->toArray();

        try {
            NotifikasiMateri::dispatch($materi, $kmp, $siswaNomorWhatsApp, $action);
        } catch (Exception $e) {
            Log::error('Gagal mengirim WhatsApp NotifikasiMateri: '.$e->getMessage());
        }
    }
}
