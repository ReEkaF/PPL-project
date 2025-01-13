<?php

namespace App\Http\Controllers\guru\lms;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use App\Models\tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ForumGuruController extends Controller
{
    public function index($id)
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'guru:id_guru,nama_guru',
            'materi:id_materi,judul_materi,created_at,kelas_mata_pelajaran_id',
            'tugas:id_tugas,judul,created_at,kelas_mata_pelajaran_id',
            'kelas:id_kelas,nama_kelas',
        ])
            ->select([
                'id_kelas_mata_pelajaran',
                'waktu_mulai',
                'waktu_selesai',
                'hari_id',
                'mata_pelajaran_id',
                'guru_id',
                'kelas_id'
            ])
            ->findOrFail($id);


        $materiTugas = collect()
            ->merge($kelasMataPelajaran->materi->map(fn($item) => (object) [
                'id' => $item->id_materi,
                'judul' => $item->judul_materi,
                'type' => 'materi',
                'date' => $item->created_at
            ]))
            ->merge($kelasMataPelajaran->tugas->map(fn($item) => (object) [
                'id' => $item->id_tugas,
                'judul' => $item->judul,
                'type' => 'tugas',
                'date' => $item->created_at,
            ]))
            ->sortByDesc('date')
            ->values();

        $tugasMendatang = tugas::where('kelas_mata_pelajaran_id', $kelasMataPelajaran->id_kelas_mata_pelajaran)
            ->where('deadline', '>', Carbon::now())
            ->orderBy('deadline', 'asc')
            ->get();


        return view('guru.lms.forum', [
            'id' => $kelasMataPelajaran->id_kelas_mata_pelajaran,
            'kelas' => $kelasMataPelajaran->kelas,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'guru' => $kelasMataPelajaran->guru,
            'waktu_mulai' => $kelasMataPelajaran->waktu_mulai,
            'waktu_selesai' => $kelasMataPelajaran->waktu_selesai,
            'hari' => $kelasMataPelajaran->hari,
            'materiTugas' => $materiTugas,
            'tugasMendatang' => $tugasMendatang
        ]);
    }
}
