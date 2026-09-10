<?php

namespace App\Http\Controllers\guru\lms;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;
use Illuminate\View\View;

class AnggotaGuruController extends Controller
{
    public function index(string $id): View
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'kelas:id_kelas,nama_kelas',
        ])->findOrFail($id);

        $kelasId = $kelasMataPelajaran->kelas->id_kelas;
        $anggotaKelas = KelasSiswa::with('siswa:id_siswa,nama_siswa,email')
            ->where('id_kelas', $kelasId)
            ->get()
            ->pluck('siswa')
            ->filter();

        return view('guru.lms.anggota', [
            'id' => $kelasMataPelajaran->id_kelas_mata_pelajaran,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'anggotaKelas' => $anggotaKelas,
            'jumlahAnggota' => $anggotaKelas->count(),
            'kelas' => $kelasMataPelajaran->kelas,
        ]);
    }
}
