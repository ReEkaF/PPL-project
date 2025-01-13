<?php

namespace App\Http\Controllers\siswa\lms;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        $id_siswa = auth()->guard('web-siswa')->user()->id_siswa;

        $kelas = KelasSiswa::with('kelas')->where('id_siswa', $id_siswa)->firstOrFail()->kelas;
        $mataPelajaranList = kelas_mata_pelajaran::where('kelas_id', $kelas->id_kelas)
            ->with(['mataPelajaran', 'guru', 'hari'])
            ->whereHas('tahunAjaran', function ($query) {
                $query->where('aktif', 1);
            })
            ->get();
        return view('siswa.lms.index', [
            'mataPelajaranList' => $mataPelajaranList
        ]);
    }
}
