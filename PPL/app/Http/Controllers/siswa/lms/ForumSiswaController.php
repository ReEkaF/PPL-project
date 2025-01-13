<?php

namespace App\Http\Controllers\Siswa\LMS;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasMataPelajaran;
use App\Models\tugas;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ForumSiswaController extends Controller
{
    /**
     * Display forum page for specific class subject
     *
     * @param int $id
     * @return View
     * @throws ModelNotFoundException
     */
    public function index($id)
    {

        $idSiswa =  auth()->guard('web-siswa')->user()->id_siswa;

        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'guru:id_guru,nama_guru',
            'materi:id_materi,judul_materi,created_at,kelas_mata_pelajaran_id',
            'tugas:id_tugas,judul,created_at,kelas_mata_pelajaran_id',

        ])
            ->select([
                'id_kelas_mata_pelajaran',
                'waktu_mulai',
                'waktu_selesai',
                'hari_id',
                'mata_pelajaran_id',
                'guru_id',
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
            ->sortBy('date')
            ->values();

        $tugasMendatang = tugas::where('kelas_mata_pelajaran_id', $kelasMataPelajaran->id_kelas_mata_pelajaran)
            ->where('deadline', '>', Carbon::now())
            ->whereDoesntHave('pengumpulantugas', function ($query) use ($idSiswa) {
                $query->where('siswa_id', $idSiswa);
            })
            ->orderBy('deadline', 'asc')
            ->get();

        return view('siswa.lms.forum', [
            'id' => $kelasMataPelajaran->id_kelas_mata_pelajaran,
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
