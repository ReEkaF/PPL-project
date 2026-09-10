<?php

namespace App\Http\Controllers\guru\lms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lms\StoreTopikRequest;
use App\Repositories\Contracts\Lms\TopikRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TopikLmsController extends Controller
{
    public function __construct(
        protected TopikRepositoryInterface $topikRepo
    ) {}

    public function store(StoreTopikRequest $request, string $id): RedirectResponse
    {
        $this->topikRepo->create([
            'judul_topik' => $request->validated('topic'),
            'kelas_mata_pelajaran_id' => $request->input('kelas_mata_pelajaran_id'),
            'mata_pelajaran_id' => $request->input('mata_pelajaran_id'),
        ]);

        if ($request->has('dari_tugas')) {
            return redirect()->route('guru.dashboard.lms.tugas.create', $id)->with('success', 'Topik berhasil ditambahkan');
        } elseif ($request->has('dari_materi')) {
            return redirect()->route('guru.dashboard.lms.materi.create', $id)->with('success', 'Topik berhasil ditambahkan');
        }

        return redirect()->route('guru.dashboard.lms.forum.tugas', $id)->with('success', 'Topik berhasil ditambahkan');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:100'],
        ]);

        $topik = $this->topikRepo->findOrFail($id);
        $topik->update([
            'judul_topik' => $request->input('topic'),
        ]);

        return redirect()->route('guru.dashboard.lms.forum.tugas', $topik->kelas_mata_pelajaran_id)
            ->with('success', 'Topik berhasil diperbarui');
    }

    public function destroy(string $id): RedirectResponse
    {
        $topik = $this->topikRepo->findOrFail($id);
        $kmpId = $topik->kelas_mata_pelajaran_id;

        $topik->delete();

        return redirect()->route('guru.dashboard.lms.forum.tugas', $kmpId)
            ->with('success', 'Topik berhasil dihapus');
    }
}
