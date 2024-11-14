<?php

namespace App\Http\Controllers\guru\lms;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use Illuminate\Http\Request;

class TugasGuruController extends Controller
{
    public function index()
    {
        return view('guru.lms.tugas');
    }

    public function forumTugas($id)
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'topik.tugas',
            'kelas:id_kelas,nama_kelas',
        ])->findOrFail($id);


        return view('guru.lms.forum_tugas', [
            'id' => $kelasMataPelajaran->id_kelas_mata_pelajaran,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'listTopik' => $kelasMataPelajaran->topik,
            'kelas' => $kelasMataPelajaran->kelas,
        ]);
    }

    public function detail($id)
    {
        return view('guru.lms.detail_tugas', ['id' => $id]);
    }


}