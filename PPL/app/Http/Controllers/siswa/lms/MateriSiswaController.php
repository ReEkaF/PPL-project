<?php

namespace App\Http\Controllers\siswa\lms;

use App\Models\materi;
use App\Models\KelasSiswa;
use App\Models\file_materi;
use App\Models\kelas_mata_pelajaran;
use App\Models\notifikasi_sistem;
use App\Http\Controllers\Controller;

class MateriSiswaController extends Controller
{

    public function index()
    {
        $id_siswa = auth()->guard(name: 'web-siswa')->user()->id_siswa;
        $data['kelas_siswa'] = KelasSiswa::where('id_siswa', $id_siswa)->get();
        $data['kelas_mata_pelajaran'] = kelas_mata_pelajaran::with('kelas', 'mataPelajaran')
            ->whereIn('kelas_id', $data['kelas_siswa']->pluck('id_kelas'))
            ->whereHas('tahunAjaran', fn($query) => $query->where('aktif', 1))
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->get();
        $data['materi'] = materi::whereIn('kelas_mata_pelajaran_id', $data['kelas_mata_pelajaran']->pluck('id_kelas_mata_pelajaran'))->where('status', 1)->get();
        $data['materi_baru'] = materi::whereIn('id_materi', $data['materi']->pluck('id_materi'))->orderBy('created_at', 'desc')->get();
        $data['materi_baru_date'] = $data['materi_baru']->pluck('updated_at')->map(function ($date) {
            return $date->format('d F Y');
        })->unique()->values();

        return view('siswa.lms.materi', $data);
    }

    public function detail($id)
    {
        $id_siswa = auth()->guard(name: 'web-siswa')->user()->id_siswa;
        $data['materi'] = materi::findOrFail($id);
        $data['file_materi'] = file_materi::where('materi_id', $id)->get();
        $notifikasi = notifikasi_sistem::where('siswa_id', $id_siswa)->where('materi_id', $id)->first();
        if ($notifikasi['status'] == 0) {
            $notifikasi->update(['status' => 1, 'tanggal_dilihat' => now()]);

            $notifikasi_count = notifikasi_sistem::where('siswa_id', $id_siswa)->where('status', 0)->count();
            session()->put('notifikasi_count', $notifikasi_count);
        }


        return view('siswa.lms.detail_materi', $data);
    }
}
