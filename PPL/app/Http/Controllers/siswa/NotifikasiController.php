<?php

namespace App\Http\Controllers\siswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\notifikasi_sistem;

class NotifikasiController extends Controller
{


    public function index()
    {
        $siswaId = auth()->guard('web-siswa')->id();
        $materi = notifikasi_sistem::with('materi')->where('siswa_id', $siswaId)->get();

        return view('siswa.notifikasi', compact('materi'));
    }
}
