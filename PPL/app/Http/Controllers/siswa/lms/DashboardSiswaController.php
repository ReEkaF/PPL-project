<?php

namespace App\Http\Controllers\siswa\lms;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;
use Illuminate\View\View;

class DashboardSiswaController extends Controller
{
    public function index(): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;

        $kelasSiswa = KelasSiswa::with('kelas')
            ->where('id_siswa', $siswaId)
            ->firstOrFail();

        $mataPelajaranList = kelas_mata_pelajaran::where('kelas_id', $kelasSiswa->kelas->id_kelas)
            ->with(['mataPelajaran', 'guru', 'hari'])
            ->whereHas('tahunAjaran', function ($query) {
                $query->where('aktif', 1);
            })
            ->get();

        return view('siswa.lms.index', [
            'mataPelajaranList' => $mataPelajaranList,
        ]);
    }
}
