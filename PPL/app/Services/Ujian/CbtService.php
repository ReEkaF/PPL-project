<?php

namespace App\Services\Ujian;

use App\Models\jawaban_ujian;
use App\Models\kelas_mata_pelajaran;
use App\Models\pengumpulan_ujian;
use App\Models\soal_ujian;
use App\Models\topik;
use App\Repositories\Contracts\Ujian\UjianRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CbtService
{
    public function __construct(
        protected UjianRepositoryInterface $ujianRepo
    ) {}

    public function getPaginatedUjian(int $perPage = 10): LengthAwarePaginator
    {
        return $this->ujianRepo->getPaginatedUjian($perPage);
    }

    public function getCreateUjianFormData(): array
    {
        return [
            'soalUjian' => soal_ujian::all(),
            'topik' => topik::all(),
            'kelasMataPelajaran' => kelas_mata_pelajaran::with(['kelas', 'mataPelajaran'])->get(),
        ];
    }

    public function createUjian(array $data): Model
    {
        return $this->ujianRepo->create([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'jenis_ujian' => $data['jenis_ujian'],
            'topik_id' => $data['topik_id'],
            'kelas_mata_pelajaran_id' => $data['kelas_mata_pelajaran_id'],
            'tanggal_dibuat' => $data['tanggal_dibuat'],
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

    public function getAvailableExamsForStudent(): Collection
    {
        return $this->ujianRepo->all();
    }

    public function startExam(string $ujianId): array
    {
        $ujian = $this->ujianRepo->findWithQuestions($ujianId);
        if (! $ujian) {
            throw new Exception('Ujian tidak ditemukan.');
        }

        $durasi = 60; // durasi dalam menit
        $endTime = now()->addMinutes($durasi);

        return [
            'ujian' => $ujian,
            'endTime' => $endTime,
        ];
    }

    public function submitExam(string $siswaId, string $ujianId, array $answers): array
    {
        return DB::transaction(function () use ($siswaId, $ujianId, $answers) {
            $nilai = 0;

            $pengumpulan = pengumpulan_ujian::create([
                'siswa_id' => $siswaId,
                'ujian_id' => $ujianId,
                'tanggal_pengumpulan' => now(),
                'nilai' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($answers as $key => $value) {
                if (str_starts_with($key, 'jawaban_')) {
                    $idSoal = str_replace('jawaban_', '', $key);
                    $soal = soal_ujian::findOrFail($idSoal);

                    if (trim(strtolower($value)) === trim(strtolower($soal->kunci_jawaban))) {
                        $nilai += 5;
                    }

                    jawaban_ujian::create([
                        'pengumpulan_ujian_id' => $pengumpulan->id_pengumpulan_ujian,
                        'soal_id' => $idSoal,
                        'jawaban_dipilih' => $value,
                    ]);
                }
            }

            $pengumpulan->update(['nilai' => $nilai]);

            $totalSoal = soal_ujian::where('ujian_id', $ujianId)->count();

            return [
                'ujian' => $pengumpulan->ujian,
                'jumlahSoal' => $totalSoal,
                'jawabanBenar' => $nilai / 5,
                'nilai' => $nilai,
            ];
        });
    }
}
