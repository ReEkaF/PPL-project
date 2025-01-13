<?php

namespace App\Http\Controllers\guru\lms;

use App\Http\Controllers\Controller;
use App\Models\topik;
use Illuminate\Http\Request;

class TopikLmsController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'topic' => 'required|string|max:100',
        ]);
        topik::create([
            'judul_topik' => $request->topic,
            'kelas_mata_pelajaran_id' => $request->kelas_mata_pelajaran_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
        ]);
        if ($request->has('dari_tugas')) {
            return redirect()->route('guru.dashboard.lms.tugas.create', $id)->with('success', 'Topik berhasil ditambahkan');
        } else if ($request->has('dari_materi')) {
            return redirect()->route('guru.dashboard.lms.materi.create', $id)->with('success', 'Topik berhasil ditambahkan');
        }
        return redirect()->route('guru.dashboard.lms.forum.tugas', $id)->with('success', 'Topik berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'topic' => 'required|string|max:100',
        ]);

        $topik = topik::findOrFail($id);
        $topik->update([
            'judul_topik' => $request->topic
        ]);

        return redirect()->route('guru.dashboard.lms.forum.tugas', $topik->kelas_mata_pelajaran_id)
            ->with('success', 'Topik berhasil diperbarui');
    }

    public function destroy($id)
    {
        $topik = topik::findOrFail($id);
        $kelasMataPelajaranId = $topik->kelas_mata_pelajaran_id;

        $topik->delete();

        return redirect()->route('guru.dashboard.lms.forum.tugas', $kelasMataPelajaranId)
            ->with('success', 'Topik berhasil dihapus');
    }
}
