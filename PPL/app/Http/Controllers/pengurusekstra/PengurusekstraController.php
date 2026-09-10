<?php

namespace App\Http\Controllers\pengurusekstra;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ekstrakurikuler\StorePostinganRequest;
use App\Http\Requests\Ekstrakurikuler\UpdatePostinganRequest;
use App\Models\PostingEkstrakurikuler;
use App\Services\Ekstrakurikuler\EkstrakurikulerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengurusekstraController extends Controller
{
    public function __construct(
        protected EkstrakurikulerService $ekstraService
    ) {}

    public function dashboard(): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $data = $this->ekstraService->getPengurusDashboardData($siswaId);

        return view('pengurus_ekstra.dashboard', $data);
    }

    public function store(StorePostinganRequest $request): RedirectResponse
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $this->ekstraService->storePostingan($siswaId, $request->validated(), $request->file('gambar'));

        return redirect()->back()->with('success', 'Postingan berhasil ditambahkan.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->ekstraService->deletePostingan($id);

        return redirect()->back()->with('success', 'Postingan berhasil dihapus.');
    }

    public function edit(string $id): View
    {
        $posting = PostingEkstrakurikuler::findOrFail($id);

        return view('pengurus_ekstra.edit', compact('posting'));
    }

    public function show(string $id): JsonResponse
    {
        $posting = PostingEkstrakurikuler::findOrFail($id);

        return response()->json([
            'id_posting' => $posting->id_posting,
            'judul' => $posting->judul,
            'deskripsi' => $posting->deskripsi,
            'gambar' => $posting->gambar,
            'tgl_uploud' => $posting->tgl_uploud,
        ]);
    }

    public function update(UpdatePostinganRequest $request, string $id): RedirectResponse
    {
        $this->ekstraService->updatePostingan($id, $request->validated(), $request->file('gambar'));

        return redirect()->route('pengurus_ekstra.dashboard')->with('success', 'Postingan berhasil diperbarui.');
    }

    public function updateStatus(Request $request): RedirectResponse
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $status = $request->input('status', 'tutup');

        $this->ekstraService->updateStatusEkstra($siswaId, $status);

        return redirect()->route('pengurus_ekstra.dashboard')->with('success', 'Status pendaftaran ekstrakurikuler berhasil diperbarui.');
    }
}
