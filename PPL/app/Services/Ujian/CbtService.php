<?php

namespace App\Services\Ujian;

use App\Models\jawaban_ujian;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;
use App\Models\pengumpulan_ujian;
use App\Models\soal_ujian;
use App\Models\topik;
use App\Repositories\Contracts\Ujian\UjianRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CbtService
{
    public function __construct(
        protected UjianRepositoryInterface $ujianRepo
    ) {}

    public function getPaginatedUjian(int $perPage = 10): LengthAwarePaginator
    {
        return $this->ujianRepo->getPaginatedUjian($perPage);
    }

    public function getGroupedUjianByKelas(?string $kelasFilter = null): array
    {
        $allUjian = $this->ujianRepo->getAllWithRelations(null);

        // Daftar semua nama kelas yang ada (terurut)
        $kelasList = $allUjian->map(function ($item) {
            return $item->kelasMataPelajaran?->kelas?->nama_kelas;
        })->filter()->unique()->sort()->values();

        // Filter data jika parameter kelas diberikan
        $filteredUjian = ($kelasFilter && $kelasFilter !== 'all')
            ? $allUjian->filter(fn ($u) => ($u->kelasMataPelajaran?->kelas?->nama_kelas ?? '') === $kelasFilter)
            : $allUjian;

        // Grouping per nama kelas
        $groupedUjian = $filteredUjian->groupBy(function ($item) {
            return $item->kelasMataPelajaran?->kelas?->nama_kelas ?? 'Tanpa Kelas';
        })->sortKeys();

        // Hitungan per kelas untuk badge tab
        $classCounts = $allUjian->groupBy(function ($item) {
            return $item->kelasMataPelajaran?->kelas?->nama_kelas ?? 'Tanpa Kelas';
        })->map->count();

        return [
            'groupedUjian' => $groupedUjian,
            'kelasList' => $kelasList,
            'classCounts' => $classCounts,
            'totalUjian' => $allUjian->count(),
            'selectedKelas' => $kelasFilter ?? 'all',
        ];
    }

    public function getCreateUjianFormData(): array
    {
        $guruId = auth()->guard('web-guru')->user()?->id_guru;

        $kmpQuery = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'guru']);
        if ($guruId && kelas_mata_pelajaran::where('guru_id', $guruId)->exists()) {
            $kmpQuery->where('guru_id', $guruId);
        }

        $kelasMataPelajaran = $kmpQuery->get()->sortBy(fn ($item) => $item->kelas?->nama_kelas ?? '');
        $groupedKmp = $kelasMataPelajaran->groupBy(fn ($item) => $item->kelas?->nama_kelas ?? 'Lainnya')->sortKeys();

        $topikQuery = topik::query();
        if ($guruId && kelas_mata_pelajaran::where('guru_id', $guruId)->exists()) {
            $topikQuery->whereHas('kelasMataPelajaran', fn ($q) => $q->where('guru_id', $guruId));
        }
        $topik = $topikQuery->get();

        return [
            'soalUjian' => soal_ujian::all(),
            'topik' => $topik,
            'kelasMataPelajaran' => $kelasMataPelajaran,
            'groupedKmp' => $groupedKmp,
        ];
    }

    public function createUjian(array $data): Model
    {
        return $this->ujianRepo->create([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'jenis_ujian' => $data['jenis_ujian'],
            'topik_id' => $data['topik_id'],
            'kelas_mata_pelajaran_id' => $data['kelas_mata_pelajaran_id'],
            'tanggal_dibuat' => $data['tanggal_dibuat'],
            'waktu_mulai' => !empty($data['waktu_mulai']) ? $data['waktu_mulai'] : null,
            'waktu_selesai' => !empty($data['waktu_selesai']) ? $data['waktu_selesai'] : null,
            'durasi_menit' => !empty($data['durasi_menit']) ? (int) $data['durasi_menit'] : 60,
            'token' => !empty($data['token']) ? strtoupper(trim($data['token'])) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function getQuestionsForExam(string $ujianId): array
    {
        $ujian = $this->ujianRepo->findOrFail($ujianId);
        $questions = $this->ujianRepo->getQuestions($ujianId);

        return [
            'ujian' => $ujian,
            'soalUjian' => $questions,
        ];
    }

    public function updateQuestion(string $id, array $data): bool
    {
        return $this->ujianRepo->updateQuestion($id, $data);
    }

    public function deleteQuestion(string $id): bool
    {
        return $this->ujianRepo->deleteQuestion($id);
    }

    public function getSubmissions(): Collection
    {
        return $this->ujianRepo->getSubmissions();
    }

    public function deleteSubmission(string $id): bool
    {
        return $this->ujianRepo->deleteSubmission($id);
    }

    // ================= SISWA CBT =================

    public function getAvailableExamsForStudent(?string $siswaId = null): Collection
    {
        if (! $siswaId) {
            return $this->ujianRepo->all();
        }

        $kelasSiswa = KelasSiswa::where('id_siswa', $siswaId)->first();
        if (! $kelasSiswa) {
            return collect();
        }

        $kmpIds = kelas_mata_pelajaran::where('kelas_id', $kelasSiswa->id_kelas)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('aktif', 1))
            ->pluck('id_kelas_mata_pelajaran');

        if ($kmpIds->isEmpty()) {
            $kmpIds = kelas_mata_pelajaran::where('kelas_id', $kelasSiswa->id_kelas)
                ->pluck('id_kelas_mata_pelajaran');
        }

        return $this->ujianRepo->getExamsByKmpIds($kmpIds);
    }

    public function getAvailableExamsForStudentPaginated(?string $siswaId = null, string $status = 'semua', int $perPage = 6): array
    {
        $allExams = $this->getAvailableExamsForStudent($siswaId);

        $totalCount = $allExams->count();
        $selesaiCount = $allExams->filter(fn ($u) => $u->pengumpulanUjian->where('siswa_id', $siswaId)->isNotEmpty())->count();
        $belumCount = $totalCount - $selesaiCount;

        $filtered = match ($status) {
            'belum' => $allExams->filter(fn ($u) => $u->pengumpulanUjian->where('siswa_id', $siswaId)->isEmpty()),
            'selesai' => $allExams->filter(fn ($u) => $u->pengumpulanUjian->where('siswa_id', $siswaId)->isNotEmpty()),
            default => $allExams,
        };

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $filtered->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $currentPageItems,
            $filtered->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );

        return [
            'ujians' => $paginated,
            'totalCount' => $totalCount,
            'selesaiCount' => $selesaiCount,
            'belumCount' => $belumCount,
            'currentStatus' => $status,
        ];
    }

    public function startExam(string $ujianId, ?string $siswaId = null, ?string $tokenInput = null): array
    {
        $ujian = $this->ujianRepo->findWithQuestions($ujianId);
        if (! $ujian) {
            throw new Exception('Ujian tidak ditemukan.');
        }

        // 1. Validasi Butir Soal (Tidak boleh kosong)
        if ($ujian->soalUjian->isEmpty()) {
            throw new Exception('Soal ujian belum tersedia. Silakan hubungi guru mata pelajaran.');
        }

        if ($siswaId) {
            // 2. Validasi Apakah Siswa Sudah Pernah Mengumpulkan / Submit
            $sudahSubmit = pengumpulan_ujian::where('ujian_id', $ujianId)
                ->where('siswa_id', $siswaId)
                ->first();

            if ($sudahSubmit) {
                throw new Exception("Anda sudah menyelesaikan ujian ini dengan nilai {$sudahSubmit->nilai}. Ujian tidak dapat dikerjakan ulang.");
            }

            // 3. Validasi Hak Akses Kelas Siswa
            $kelasSiswa = KelasSiswa::where('id_siswa', $siswaId)->first();
            $kelasUjianId = $ujian->kelasMataPelajaran?->kelas_id;

            if ($kelasUjianId && $kelasSiswa && $kelasSiswa->id_kelas !== $kelasUjianId) {
                throw new Exception('Akses ditolak: Ujian ini bukan diperuntukkan untuk kelas Anda.');
            }
        }

        // 4. Validasi Jadwal Pelaksanaan (Window Time)
        $now = now();
        if ($ujian->waktu_mulai && $now->lt(Carbon::parse($ujian->waktu_mulai))) {
            $waktuMulaiStr = Carbon::parse($ujian->waktu_mulai)->translatedFormat('d F Y, H:i');
            throw new Exception("Ujian belum dibuka. Ujian baru dapat diakses pada {$waktuMulaiStr} WIB.");
        }

        if ($ujian->waktu_selesai && $now->gt(Carbon::parse($ujian->waktu_selesai))) {
            $waktuSelesaiStr = Carbon::parse($ujian->waktu_selesai)->translatedFormat('d F Y, H:i');
            throw new Exception("Waktu pelaksanaan ujian telah berakhir pada {$waktuSelesaiStr} WIB.");
        }

        // 5. Validasi Token CBT dari Pengawas / Proktor
        if (! empty($ujian->token)) {
            $normalizedExpected = trim(strtoupper($ujian->token));
            $normalizedInput = trim(strtoupper($tokenInput ?? ''));

            if (empty($normalizedInput)) {
                throw new Exception('Token ujian wajib diisi. Silakan minta kode token kepada pengawas ujian di kelas.');
            }

            if ($normalizedInput !== $normalizedExpected) {
                throw new Exception('Token ujian tidak valid. Pastikan Anda memasukkan kode token yang benar dari pengawas.');
            }
        }

        // 6. Timer Persistence (Melanjutkan sesi jika browser ter-refresh)
        $sessionKey = "ujian_end_time_{$ujianId}_{$siswaId}";
        $durasi = (int) ($ujian->durasi_menit ?: 60);

        if (session()->has($sessionKey)) {
            $existingEndTime = Carbon::parse(session($sessionKey));
            if ($existingEndTime->isFuture()) {
                $endTime = $existingEndTime;
            } else {
                throw new Exception('Waktu pengerjaan ujian Anda telah habis.');
            }
        } else {
            $endTime = now()->addMinutes($durasi);
            // Jika ada batas waktu_selesai yang lebih cepat dari durasi normal, potong waktu selesai ujian
            if ($ujian->waktu_selesai && Carbon::parse($ujian->waktu_selesai)->lt($endTime)) {
                $endTime = Carbon::parse($ujian->waktu_selesai);
            }
            session([$sessionKey => $endTime->toDateTimeString()]);
        }

        return [
            'ujian' => $ujian,
            'endTime' => $endTime,
        ];
    }

    public function submitExam(string $siswaId, string $ujianId, array $answers): array
    {
        // Validasi: Apakah sudah pernah submit sebelumnya (cegah double submit)
        $existingSubmission = pengumpulan_ujian::where('siswa_id', $siswaId)
            ->where('ujian_id', $ujianId)
            ->first();

        if ($existingSubmission) {
            $totalSoal = soal_ujian::where('ujian_id', $ujianId)->count();

            return [
                'ujian' => $existingSubmission->ujian,
                'jumlahSoal' => $totalSoal,
                'jawabanBenar' => round(((float) $existingSubmission->nilai / 100) * $totalSoal),
                'nilai' => $existingSubmission->nilai,
                'already_submitted' => true,
            ];
        }

        return DB::transaction(function () use ($siswaId, $ujianId, $answers) {
            $ujian = $this->ujianRepo->findWithQuestions($ujianId);
            $totalSoal = $ujian ? $ujian->soalUjian->count() : soal_ujian::where('ujian_id', $ujianId)->count();

            $pengumpulan = pengumpulan_ujian::create([
                'id_pengumpulan_ujian' => (string) Str::uuid(),
                'siswa_id' => $siswaId,
                'ujian_id' => $ujianId,
                'tanggal_pengumpulan' => now(),
                'nilai' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $jawabanBenar = 0;

            foreach ($answers as $key => $value) {
                if (str_starts_with($key, 'jawaban_')) {
                    $idSoal = str_replace('jawaban_', '', $key);
                    $soal = soal_ujian::find($idSoal);

                    if ($soal) {
                        $isCorrect = trim(strtolower($value)) === trim(strtolower($soal->kunci_jawaban));
                        if ($isCorrect) {
                            $jawabanBenar++;
                        }

                        jawaban_ujian::create([
                            'id_jawaban_ujian' => (string) Str::uuid(),
                            'pengumpulan_ujian_id' => $pengumpulan->id_pengumpulan_ujian,
                            'soal_id' => $idSoal,
                            'jawaban_dipilih' => $value,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Hitung nilai skala 0 - 100
            $nilaiAkhir = $totalSoal > 0 ? round(($jawabanBenar / $totalSoal) * 100) : 0;
            $pengumpulan->update(['nilai' => (string) $nilaiAkhir]);

            // Hapus session waktu ujian
            session()->forget("ujian_end_time_{$ujianId}_{$siswaId}");
            session()->forget('ujian_end_time');

            return [
                'ujian' => $pengumpulan->ujian,
                'jumlahSoal' => $totalSoal,
                'jawabanBenar' => $jawabanBenar,
                'nilai' => $nilaiAkhir,
                'already_submitted' => false,
            ];
        });
    }
}
