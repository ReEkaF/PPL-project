<?php

namespace App\Http\Controllers\guru\lms;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use Illuminate\Http\Request;

class DashboardGuruController extends Controller
{
    public function index()
    {
        $id_guru = auth()->guard('web-guru')->user()->id_guru;
        $kelas_guru = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'hari', 'tahunAjaran'])
            ->where('guru_id', $id_guru)
            ->whereHas('tahunAjaran', function ($query) {
                $query->where('aktif', 1);
            })
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->select('kelas_mata_pelajaran.*')
            ->get();
        return view('guru.lms.index', [
            'kelasGuru' => $kelas_guru
        ]);
    }
}
