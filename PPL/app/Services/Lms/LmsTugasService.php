<?php

namespace App\Services\Lms;

use App\Jobs\NotifikasUploadTugas;
use App\Models\kelas;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;
use App\Models\materi;
use App\Models\Siswa;
use App\Models\tugas;
use App\Repositories\Contracts\Lms\PengumpulanTugasRepositoryInterface;
use App\Repositories\Contracts\Lms\TopikRepositoryInterface;
use App\Repositories\Contracts\Lms\TugasRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LmsTugasService
{
    public function __construct(
        protected TugasRepositoryInterface $tugasRepo,
        protected PengumpulanTugasRepositoryInterface $pengumpulanRepo,
        protected TopikRepositoryInterface $topikRepo
    ) {}

    /**
     * Get data for teacher's task dashboard index.
     */
    public function getGuruTugasIndexData(string $guruId): array
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'kelas',
            'mataPelajaran',
            'tugas' => fn ($query) => $query->orderBy('deadline', 'asc'),
        ])
            ->where('guru_id', $guruId)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('aktif', 1))
            ->get();

        $mataPelajaranGrup = $kelasMataPelajaran->groupBy('mata_pelajaran_id')
            ->map(function ($items) {
                return [
                    'mata_pelajaran' => $items->first()->mataPelajaran->nama_matpel,
                    'kelas' => $items->map(function ($item) {
                        return [
                            'nama_kelas' => $item->kelas->nama_kelas,
                            'id_kelas' => $item->kelas->id_kelas,
                            'id_kelas_matapelajaran' => $item->id_kelas_mata_pelajaran,
                            'tugas' => $item->tugas,
                        ];
                    }),
                ];
            });

        $allTasks = $kelasMataPelajaran->flatMap(function ($mapel) {
            return $mapel->tugas;
        })->sortBy('created_at')->groupBy(function ($task) {
            return Carbon::parse($task->created_at)->format('Y-m-d');
        });

        return [
            'mataPelajaranGrup' => $mataPelajaranGrup,
            'allTasks' => $allTasks,
            'kelasMataPelajaran' => $kelasMataPelajaran,
        ];
    }

    /**
     * Get forum tugas data for a class subject.
     */
    public function getForumTugasData(string $kmpId): array
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'topik' => function ($query) {
                $query->orderBy('created_at', 'desc')->with([
                    'tugas' => fn ($q) => $q->orderBy('created_at', 'desc'),
                    'materi' => fn ($q) => $q->orderBy('created_at', 'desc'),
                ]);
            },
            'kelas:id_kelas,nama_kelas',
        ])->findOrFail($kmpId);

        $tugasTanpaTopik = $this->tugasRepo->getWithoutTopic($kmpId);
        $materiTanpaTopik = materi::where('kelas_mata_pelajaran_id', $kmpId)
            ->whereNull('topik_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'id' => $kelasMataPelajaran->id_kelas_mata_pelajaran,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'listTopik' => $kelasMataPelajaran->topik,
            'kelas' => $kelasMataPelajaran->kelas,
            'tugasTanpaTopik' => $tugasTanpaTopik,
            'materiTanpaTopik' => $materiTanpaTopik,
        ];
    }

    /**
     * Get create form data.
     */
    public function getCreateFormData(string $kmpId): array
    {
        $kmp = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'kelas:id_kelas,nama_kelas',
        ])->findOrFail($kmpId);

        $topiks = $this->topikRepo->getByKelasMataPelajaranId($kmpId);

        return [
            'id' => $kmpId,
            'mataPelajaran' => $kmp->mataPelajaran,
            'kelas' => $kmp->kelas,
            'topiks' => $topiks,
        ];
    }

    /**
     * Store new task and send notifications.
     */
    public function storeTugas(array $data, ?array $files = null): Model
    {
        return DB::transaction(function () use ($data, $files) {
            $tugas = $this->tugasRepo->create([
                'kelas_mata_pelajaran_id' => $data['kelas_mata_pelajaran_id'],
                'topik_id' => $data['topik_id'] ?? null,
                'judul' => $data['judul_tugas'],
                'deskripsi' => $data['deskripsi'],
                'deadline' => Carbon::parse($data['tenggat'])->format('Y-m-d H:i:s'),
                'created_at' => now(),
            ]);

            if ($files) {
                $this->handleFileUploads($files, $tugas->id_tugas);
            }

            // Send notification
            $this->dispatchTugasNotification($tugas);

            return $tugas;
        });
    }

    /**
     * Get task edit data.
     */
    public function getEditData(string $id): array
    {
        $tugas = $this->tugasRepo->findWithDetails($id);
        if (! $tugas) {
            throw new Exception('Tugas tidak ditemukan.');
        }

        $topiks = $this->topikRepo->getByKelasMataPelajaranId($tugas->kelas_mata_pelajaran_id);

        return [
            'tugas' => $tugas,
            'mataPelajaran' => $tugas->kelasMataPelajaran->mataPelajaran,
            'kelas' => $tugas->kelasMataPelajaran->kelas,
            'topiks' => $topiks,
        ];
    }

    /**
     * Update task and sync late statuses.
     */
    public function updateTugas(string $id, array $data, ?array $files = null, array $removedFiles = []): Model
    {
        return DB::transaction(function () use ($id, $data, $files, $removedFiles) {
            $tugas = $this->tugasRepo->find($id);
            if (! $tugas) {
                throw new Exception('Tugas tidak ditemukan.');
            }

            $deadline = Carbon::parse($data['tenggat']);

            $tugas->update([
                'topik_id' => $data['topik_id'] ?? null,
                'judul' => $data['judul_tugas'],
                'deskripsi' => $data['deskripsi'] ?? '',
                'deadline' => $deadline->format('Y-m-d H:i:s'),
                'updated_at' => now(),
            ]);

            // Handle removed files
            foreach ($removedFiles as $fileId) {
                $file = $this->tugasRepo->findFile($fileId);
                if ($file) {
                    $path = 'uploads/file_tugas/'.basename($file->file_path);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $file->delete();
                }
            }

            // Sync submission late statuses with the new deadline
            $this->pengumpulanRepo->syncLateStatusWithDeadline($id, $deadline);

            // Handle new files
            if ($files) {
                $this->handleFileUploads($files, $id);
            }

            return $tugas;
        });
    }

    /**
     * Delete task and all its files.
     */
    public function deleteTugas(string $id): bool
    {
        return DB::transaction(function () use ($id) {
            $files = $this->tugasRepo->getFiles($id);
            foreach ($files as $file) {
                $path = 'uploads/file_tugas/'.basename($file->file_path);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $file->delete();
            }

            $tugas = $this->tugasRepo->find($id);
            if ($tugas) {
                return (bool) $tugas->delete();
            }

            return false;
        });
    }

    /**
     * Overview of student submissions for a specific task.
     */
    public function getTugasSiswaOverview(string $tugasId): array
    {
        $tugas = $this->tugasRepo->findWithSubmissions($tugasId);
        if (! $tugas) {
            throw new Exception('Tugas tidak ditemukan.');
        }

        $siswaList = $tugas->kelasMataPelajaran->kelas->siswa;
        $pengumpulanTugas = $tugas->pengumpulantugas;
        $diserahkan = $pengumpulanTugas->count();
        $belumDiserahkan = $siswaList->count() - $diserahkan;

        return [
            'tugas' => $tugas,
            'kelas' => $tugas->kelasMataPelajaran->kelas,
            'mataPelajaran' => $tugas->kelasMataPelajaran->mataPelajaran,
            'KelasMataPelajaranId' => $tugas->kelas_mata_pelajaran_id,
            'siswaList' => $siswaList,
            'pengumpulanTugas' => $pengumpulanTugas,
            'diserahkan' => $diserahkan,
            'belumDiserahkan' => $belumDiserahkan,
        ];
    }

    /**
     * Detail of a single student submission for grading.
     */
    public function getDetailTugasSiswa(string $pengumpulanId): array
    {
        $pengumpulan = $this->pengumpulanRepo->findWithDetails($pengumpulanId);
        if (! $pengumpulan) {
            throw new Exception('Pengumpulan tugas tidak ditemukan.');
        }

        $tugas = $this->tugasRepo->findWithSubmissions($pengumpulan->tugas_id);

        return [
            'pengumpulan' => $pengumpulan,
            'tugas' => $tugas,
            'kelas' => $tugas->kelasMataPelajaran->kelas,
            'mataPelajaran' => $tugas->kelasMataPelajaran->mataPelajaran,
            'KelasMataPelajaranId' => $tugas->kelas_mata_pelajaran_id,
            'siswaList' => $tugas->kelasMataPelajaran->kelas->siswa,
            'pengumpulanTugas' => $tugas->pengumpulantugas,
        ];
    }

    /**
     * Grade a student's task submission.
     */
    public function gradeSubmission(string $pengumpulanId, float|int $nilai, ?string $komentar = null): bool
    {
        $pengumpulan = $this->pengumpulanRepo->find($pengumpulanId);
        if (! $pengumpulan) {
            throw new Exception('Pengumpulan tugas tidak ditemukan.');
        }

        return $pengumpulan->update([
            'nilai' => $nilai,
            'komentar' => $komentar ?? '',
        ]);
    }

    /**
     * Get periksa tugas listing with aggregated submission metrics.
     */
    public function getPeriksaTugasData(string $guruId, ?string $kelasId = null): array
    {
        $tugas = $this->tugasRepo->getTugasForPeriksa($guruId, $kelasId);

        $infoTugas = $tugas->map(function ($t) {
            $totalSiswa = $t->kelasMataPelajaran->kelas->siswa->count();
            $siswaMenyerahkan = $t->pengumpulantugas->count();
            $dinilai = $t->pengumpulantugas->filter(fn ($p) => $p->nilai !== null)->count();
            $siswaBelumMenyerahkan = $totalSiswa - $siswaMenyerahkan;

            return [
                'tugas' => $t,
                'totalSiswa' => $totalSiswa,
                'siswaMenyerahkan' => $siswaMenyerahkan,
                'dinilai' => $dinilai,
                'siswaBelumMenyerahkan' => $siswaBelumMenyerahkan,
                'namaKelas' => $t->kelasMataPelajaran->kelas->nama_kelas,
                'deadline' => $t->deadline,
            ];
        });

        $kelasList = kelas::whereIn('id_kelas', function ($q) use ($guruId) {
            $q->select('kelas_id')
                ->from('kelas_mata_pelajaran')
                ->where('guru_id', $guruId);
        })->orderBy('nama_kelas', 'asc')->get();

        return [
            'tugas' => $infoTugas,
            'kelasList' => $kelasList,
            'kelasId' => $kelasId,
        ];
    }

    /**
     * Get task detail for student submission view.
     */
    public function getSiswaTugasDetail(string $tugasId, string $siswaId): array
    {
        $tugas = $this->tugasRepo->findWithDetails($tugasId);
        if (! $tugas) {
            throw new Exception('Tugas tidak ditemukan.');
        }

        $pengumpulan = $this->pengumpulanRepo->findByTugasAndSiswa($tugasId, $siswaId);
        $now = Carbon::now();
        $deadline = Carbon::parse($tugas->deadline);

        if ($pengumpulan) {
            $submittedAt = Carbon::parse($pengumpulan->created_at ?? $pengumpulan->tanggal_pengumpulan);
            if ($submittedAt <= $deadline) {
                $statusText = 'diserahkan';
                $statusColor = 'bg-green-100 text-green-800';
            } else {
                $statusText = 'terlambat diserahkan';
                $statusColor = 'bg-red-100 text-red-800';
            }
        } else {
            if ($now > $deadline) {
                $statusText = 'Tidak Diserahkan';
                $statusColor = 'bg-red-100 text-red-800';
            } else {
                $statusText = 'Ditugaskan';
                $statusColor = 'bg-blue-100 text-blue-800';
            }
        }

        return [
            'tugas' => $tugas,
            'kelasMataPelajaran' => $tugas->kelasMataPelajaran,
            'filetugas' => $tugas->filetugas,
            'pengumpulan' => $pengumpulan,
            'status_text' => $statusText,
            'status_color' => $statusColor,
        ];
    }

    /**
     * Submit task by student with uploaded files.
     */
    public function submitTugasSiswa(string $tugasId, string $siswaId, array $files): Model
    {
        return DB::transaction(function () use ($tugasId, $siswaId, $files) {
            $tugas = $this->tugasRepo->find($tugasId);
            if (! $tugas) {
                throw new Exception('Tugas tidak ditemukan.');
            }

            $now = Carbon::now();
            $status = $now->isAfter(Carbon::parse($tugas->deadline)) ? 'terlambat diserahkan' : 'diserahkan';

            $pengumpulan = $this->pengumpulanRepo->findByTugasAndSiswa($tugasId, $siswaId);
            if (! $pengumpulan) {
                $pengumpulan = $this->pengumpulanRepo->create([
                    'tugas_id' => $tugasId,
                    'siswa_id' => $siswaId,
                    'tanggal_pengumpulan' => $now,
                    'status' => $status,
                    'nilai' => null,
                    'komentar' => '',
                ]);
            }

            foreach ($files as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $path = $file->storeAs('uploads/pengumpulan_file_tugas', $filename, 'public');

                $this->pengumpulanRepo->createFile([
                    'pengumpulan_tugas_id' => $pengumpulan->id_pengumpulan_tugas,
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }

            return $pengumpulan;
        });
    }

    /**
     * Delete student submitted file.
     */
    public function deleteSubmissionFile(string $fileId): bool
    {
        $file = $this->pengumpulanRepo->findFile($fileId);
        if (! $file) {
            return false;
        }

        $path = 'uploads/pengumpulan_file_tugas/'.basename($file->file_path);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return (bool) $file->delete();
    }

    /**
     * Cancel/retract student submission.
     */
    public function cancelSubmission(string $pengumpulanId): bool
    {
        return DB::transaction(function () use ($pengumpulanId) {
            $pengumpulan = $this->pengumpulanRepo->findWithDetails($pengumpulanId);
            if (! $pengumpulan) {
                return false;
            }

            foreach ($pengumpulan->pengumpulanTugasFile as $file) {
                $path = 'uploads/pengumpulan_file_tugas/'.basename($file->file_path);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $file->delete();
            }

            return (bool) $pengumpulan->delete();
        });
    }

    /**
     * Student task tracking data.
     */
    public function getStudentTracking(string $siswaId, string $statusType, ?string $matpelId = null): array
    {
        $kelas = KelasSiswa::with('kelas')
            ->where('id_siswa', $siswaId)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('aktif', 1))
            ->firstOrFail()
            ->kelas;

        $matpelList = kelas_mata_pelajaran::where('kelas_id', $kelas->id_kelas)
            ->with('mataPelajaran')
            ->get()
            ->pluck('mataPelajaran.nama_matpel', 'mataPelajaran.id_matpel');

        $kelasMataPelajaran = match ($statusType) {
            'ditugaskan' => $this->pengumpulanRepo->getTrackingDitugaskan($siswaId, $kelas->id_kelas, $matpelId),
            'belum_diserahkan' => $this->pengumpulanRepo->getTrackingBelumDiserahkan($siswaId, $kelas->id_kelas, $matpelId),
            'diserahkan' => $this->pengumpulanRepo->getTrackingDiserahkan($siswaId, $kelas->id_kelas, $matpelId),
            default => collect(),
        };

        return [
            'kelasMataPelajaran' => $kelasMataPelajaran,
            'mataPelajaranList' => $matpelList,
            'selectedMataPelajaran' => $matpelId,
        ];
    }

    protected function handleFileUploads(array $files, string $tugasId): void
    {
        foreach ($files as $file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('uploads/file_tugas', $fileName, 'public');

            $this->tugasRepo->createFile([
                'tugas_id' => $tugasId,
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'original_name' => $file->getClientOriginalName(),
                'upload_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    protected function dispatchTugasNotification(Model $tugas): void
    {
        $namaTugas = $tugas->judul;
        $mataPelajaran = $tugas->kelasMataPelajaran->mataPelajaran->nama_matpel ?? '';
        $deadline = Carbon::parse($tugas->deadline)->format('d M Y H:i');

        $siswaNomorWhatsApp = Siswa::whereHas('kelas', function ($query) use ($tugas) {
            $query->whereHas('kelasMataPelajaran', function ($sub) use ($tugas) {
                $sub->where('id_kelas_mata_pelajaran', $tugas->kelas_mata_pelajaran_id);
            });
        })->pluck('nomor_wa_siswa')->filter()->toArray();

        try {
            NotifikasUploadTugas::dispatch($namaTugas, $mataPelajaran, $deadline, $siswaNomorWhatsApp);
        } catch (Exception $e) {
            Log::error('Gagal mengirim WhatsApp NotifikasUploadTugas: '.$e->getMessage());
        }
    }
}
