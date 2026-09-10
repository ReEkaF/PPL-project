<?php

namespace App\Http\Controllers\siswa\lms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lms\SubmitTugasRequest;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;
use App\Models\materi;
use App\Models\tugas;
use App\Services\Lms\LmsTugasService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TugasSiswaController extends Controller
{
    public function __construct(
        protected LmsTugasService $tugasService
    ) {}

    public function index(): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $kelas = KelasSiswa::with('kelas')->where('id_siswa', $siswaId)->firstOrFail()->kelas;

        $mataPelajaranList = kelas_mata_pelajaran::where('kelas_id', $kelas->id_kelas)
            ->with([
                'mataPelajaran',
                'tugas' => fn ($query) => $query->orderBy('deadline', 'asc'),
            ])
            ->get();

        $allTasks = $mataPelajaranList->flatMap(fn ($mapel) => $mapel->tugas)
            ->sortBy('created_at')
            ->groupBy(fn ($task) => Carbon::parse($task->created_at)->format('Y-m-d'));

        return view('siswa.lms.tugas', [
            'mataPelajaranList' => $mataPelajaranList,
            'allTasks' => $allTasks,
        ]);
    }

    public function forumTugas(string $id): View
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'guru:id_guru,nama_guru',
            'kelas:id_kelas,nama_kelas',
            'hari',
            'topik.tugas',
            'topik.materi',
        ])->findOrFail($id);

        $tugasTanpaTopik = tugas::where('kelas_mata_pelajaran_id', $id)
            ->whereNull('topik_id')
            ->get();

        $materiTanpaTopik = materi::where('kelas_mata_pelajaran_id', $id)
            ->whereNull('topik_id')
            ->get();

        return view('siswa.lms.forum_tugas', [
            'id' => $kelasMataPelajaran->id_kelas_mata_pelajaran,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'guru' => $kelasMataPelajaran->guru,
            'kelas' => $kelasMataPelajaran->kelas,
            'hari' => $kelasMataPelajaran->hari,
            'waktu_mulai' => $kelasMataPelajaran->waktu_mulai,
            'waktu_selesai' => $kelasMataPelajaran->waktu_selesai,
            'listTopik' => $kelasMataPelajaran->topik,
            'tugasTanpaTopik' => $tugasTanpaTopik,
            'materiTanpaTopik' => $materiTanpaTopik,
        ]);
    }

    public function detail(string $id): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $data = $this->tugasService->getSiswaTugasDetail($id, $siswaId);

        return view('siswa.lms.detail_tugas', $data);
    }

    public function submit(SubmitTugasRequest $request, string $id): RedirectResponse
    {
        try {
            $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
            $files = $request->file('files');

            $this->tugasService->submitTugasSiswa($id, $siswaId, $files);

            return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengumpulkan tugas: '.$e->getMessage());
        }
    }

    public function deleteFile(string $id): RedirectResponse
    {
        try {
            $deleted = $this->tugasService->deleteSubmissionFile($id);
            if ($deleted) {
                return redirect()->back()->with('success', 'File berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'File tidak ditemukan.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus file.');
        }
    }

    public function batalPengumpulan(string $id): RedirectResponse
    {
        try {
            $cancelled = $this->tugasService->cancelSubmission($id);
            if ($cancelled) {
                return redirect()->back()->with('success', 'Penyerahan tugas berhasil dibatalkan.');
            }

            return redirect()->back()->with('error', 'Pengumpulan tugas tidak ditemukan.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal membatalkan penyerahan tugas.');
        }
    }
}
