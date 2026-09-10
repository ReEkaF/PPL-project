<?php

namespace App\Http\Controllers\guru\lms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lms\GradeTugasRequest;
use App\Http\Requests\Lms\StoreTugasRequest;
use App\Http\Requests\Lms\UpdateTugasRequest;
use App\Repositories\Contracts\Lms\TugasRepositoryInterface;
use App\Services\Lms\LmsTugasService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TugasGuruController extends Controller
{
    public function __construct(
        protected LmsTugasService $tugasService,
        protected TugasRepositoryInterface $tugasRepo
    ) {}

    public function index(): View
    {
        $guruId = auth()->guard('web-guru')->user()->id_guru;
        $data = $this->tugasService->getGuruTugasIndexData($guruId);

        return view('guru.lms.tugas', $data);
    }

    public function forumTugas(string $id): View
    {
        $data = $this->tugasService->getForumTugasData($id);

        return view('guru.lms.forum_tugas', $data);
    }

    public function create(string $id): View
    {
        $data = $this->tugasService->getCreateFormData($id);

        return view('guru.lms.tugas.create', $data);
    }

    public function detail(string $id): View
    {
        $tugas = $this->tugasRepo->findWithDetails($id);

        return view('guru.lms.tugas.detail', compact('tugas'));
    }

    public function store(StoreTugasRequest $request, ?string $id = null): RedirectResponse
    {
        try {
            $files = $request->file('files');
            $tugas = $this->tugasService->storeTugas($request->validated(), $files);

            return redirect()->route('guru.dashboard.lms.forum.tugas', $tugas->kelas_mata_pelajaran_id)
                ->with('success', 'Tugas berhasil dibuat');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function edit(string $id): View
    {
        $data = $this->tugasService->getEditData($id);

        return view('guru.lms.tugas.edit', $data);
    }

    public function update(UpdateTugasRequest $request, string $id): RedirectResponse
    {
        try {
            $files = $request->file('files');
            $removedFiles = $request->input('removed_files', []);

            $tugas = $this->tugasService->updateTugas($id, $request->validated(), $files, $removedFiles);

            return redirect()->route('guru.dashboard.lms.forum.tugas', $tugas->kelas_mata_pelajaran_id)
                ->with('success', 'Tugas berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function destroy(string $id, Request $request): RedirectResponse
    {
        try {
            $kmpId = $request->input('kelas_mata_pelajaran_id');
            $this->tugasService->deleteTugas($id);

            return redirect()->route('guru.dashboard.lms.forum.tugas', $kmpId)->with('success', 'Tugas berhasil dihapus');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function tugasSiswa(string $id): View
    {
        $data = $this->tugasService->getTugasSiswaOverview($id);

        return view('guru.lms.tugas.tugas_siswa', $data);
    }

    public function detailTugasSiswa(string $id): View
    {
        $data = $this->tugasService->getDetailTugasSiswa($id);

        return view('guru.lms.tugas.detail_tugas_siswa', $data);
    }

    public function nilaiTugas(GradeTugasRequest $request, string $id): RedirectResponse
    {
        try {
            $this->tugasService->gradeSubmission($id, $request->validated('nilai'), $request->validated('komentar'));

            return redirect()->back()->with('success', 'Nilai berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function periksaTugas(Request $request): View
    {
        $guruId = auth()->guard('web-guru')->user()->id_guru;
        $data = $this->tugasService->getPeriksaTugasData($guruId, $request->input('kelas_id'));

        return view('guru.lms.tracking_tugas', $data);
    }
}
