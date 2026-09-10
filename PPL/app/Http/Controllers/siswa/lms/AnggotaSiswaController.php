<?php

namespace App\Http\Controllers\siswa\lms;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;
use Illuminate\View\View;

class AnggotaSiswaController extends Controller
{
    public function index(string $id): View
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'kelas:id_kelas,nama_kelas',
            'guru:id_guru,nama_guru',
            'hari',
        ])->findOrFail($id);

        $kelasId = $kelasMataPelajaran->kelas->id_kelas;
        $anggotaKelas = KelasSiswa::with('siswa:id_siswa,nama_siswa,nisn,email,jenis_kelamin_siswa,foto_siswa')
            ->where('id_kelas', $kelasId)
            ->get()
            ->pluck('siswa')
            ->filter();

        return view('siswa.lms.anggota', [
            'id' => $kelasMataPelajaran->id_kelas_mata_pelajaran,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'kelas' => $kelasMataPelajaran->kelas,
            'guru' => $kelasMataPelajaran->guru,
            'hari' => $kelasMataPelajaran->hari,
            'waktu_mulai' => $kelasMataPelajaran->waktu_mulai,
            'waktu_selesai' => $kelasMataPelajaran->waktu_selesai,
            'anggotaKelas' => $anggotaKelas,
            'jumlahAnggota' => $anggotaKelas->count(),
        ]);
    }
}
