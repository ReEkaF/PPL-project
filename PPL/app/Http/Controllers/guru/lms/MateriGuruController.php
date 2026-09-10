<?php

namespace App\Http\Controllers\guru\lms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lms\StoreMateriRequest;
use App\Http\Requests\Lms\UpdateMateriRequest;
use App\Services\Lms\LmsMateriService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MateriGuruController extends Controller
{
    public function __construct(
        protected LmsMateriService $materiService
    ) {}

    public function index(): View
    {
        $guruId = auth()->guard('web-guru')->user()->id_guru;
        $data = $this->materiService->getGuruMateriIndexData($guruId);

        return view('guru.lms.materi', $data);
    }

    public function detail(string $id): View
    {
        $data = $this->materiService->getMateriDetail($id);

        return view('guru.lms.materi.detail', $data);
    }

    public function createView(): View
    {
        $guruId = auth()->guard('web-guru')->user()->id_guru;
        $data = $this->materiService->getCreateViewData($guruId);

        return view('guru.lms.materi.create_view', $data);
    }

    public function create(string $id): View
    {
        $data = $this->materiService->getCreateFormData($id);

        return view('guru.lms.materi.create', $data);
    }

    public function store(StoreMateriRequest $request, ?string $id = null): RedirectResponse
    {
        try {
            $isPublish = $request->has('post');
            $files = $request->file('file_materi');
            $removedFiles = $request->input('removed_files', []);
            $materiId = $request->input('id_materi');

            $this->materiService->storeMateri(
                $request->validated(),
                $files,
                $removedFiles,
                $isPublish,
                $materiId
            );

            $message = $isPublish
                ? 'Materi berhasil dibuat dan notifikasi berhasil dikirim.'
                : 'Draft Materi berhasil dibuat.';

            return redirect()->route('guru.dashboard.lms.materi')->with('success', $message);
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function edit(string $id): View
    {
        $data = $this->materiService->getEditData($id);

        return view('guru.lms.materi.edit', $data);
    }

    public function update(UpdateMateriRequest $request, string $id): RedirectResponse
    {
        try {
            $files = $request->file('file_materi');
            $removedFiles = $request->input('removed_files', []);

            $this->materiService->updateMateri(
                $id,
                $request->validated(),
                $files,
                $removedFiles
            );

            return redirect()->route('guru.dashboard.lms.materi')->with('success', 'Materi berhasil diubah.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->materiService->deleteMateri($id);

            return redirect()->route('guru.dashboard.lms.materi')->with('success', 'Materi berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
