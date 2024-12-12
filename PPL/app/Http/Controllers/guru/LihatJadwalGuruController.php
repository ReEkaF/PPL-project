<?php

namespace App\Http\Controllers\guru;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LihatJadwalGuruController extends Controller
{
    /**
     * Menampilkan jadwal guru yang sedang login
     */
    public function index()
    {
        $guru = Auth::guard('web-guru')->user();
        $guru_id = $guru->id_guru;

        $query = DB::table('kelas_mata_pelajaran')
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->join('tahun_ajaran', 'kelas_mata_pelajaran.tahun_ajaran_id', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->orderBy('hari.nama_hari', 'desc')
            ->select(
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'mata_pelajaran.nama_matpel',
                'kelas.nama_kelas'
            )
            ->where('tahun_ajaran.aktif', 1)
            ->where('kelas_mata_pelajaran.guru_id', $guru_id)
            ->orderBy('hari.id_hari')
            ->orderBy('kelas_mata_pelajaran.waktu_mulai')
            ->get();

        return view('guru.jadwal.lihat-jadwal', compact('guru', 'query'));
    }

    /**
     * Cetak PDF dari jadwal guru
     */
    public function print()
    {
        $guru = Auth::guard('web-guru')->user();
        $guru_id = $guru->id_guru;

        $jadwal = DB::table('kelas_mata_pelajaran')
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->join('tahun_ajaran', 'kelas_mata_pelajaran.tahun_ajaran_id', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->orderBy('hari.nama_hari', 'desc')
            ->select(
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'mata_pelajaran.nama_matpel',
                'kelas.nama_kelas'
            )
            ->where('tahun_ajaran.aktif', 1)
            ->where('kelas_mata_pelajaran.guru_id', $guru_id)
            ->orderBy('hari.id_hari')
            ->orderBy('kelas_mata_pelajaran.waktu_mulai')
            ->get();

        $pdf = Pdf::loadView('guru.jadwal.cetak-jadwal-guru', compact('guru', 'jadwal'));
        return $pdf->stream('jadwal-guru.pdf');
    }
}
