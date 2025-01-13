<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LihatJadwalController extends Controller
{
    //
    
    public function kelas_index($kelas_id = null)
    {
        $kelas = DB::table('kelas')
            ->orderByRaw('LENGTH(nama_kelas)')
            ->orderBy('nama_kelas')
            ->get();

        $hari = DB::table('hari')
            ->orderByRaw("FIELD(nama_hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get();

        // Query untuk data jadwal, dengan filter kelas_id jika ada
        $query = DB::table('kelas_mata_pelajaran')
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->join('tahun_ajaran', 'kelas_mata_pelajaran.tahun_ajaran_id', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->orderBy('hari.nama_hari', 'desc')
            ->select(
                'kelas_mata_pelajaran.id_kelas_mata_pelajaran',
                'kelas_mata_pelajaran.kelas_id',
                'kelas.nama_kelas',
                'kelas_mata_pelajaran.mata_pelajaran_id',
                'mata_pelajaran.nama_matpel',
                'kelas_mata_pelajaran.guru_id',
                'guru.nip',
                'guru.nama_guru',
                'kelas_mata_pelajaran.hari_id',
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'kelas_mata_pelajaran.tahun_ajaran_id',
                'tahun_ajaran.tahun_mulai',
                'tahun_ajaran.tahun_selesai',
                'tahun_ajaran.semester',
                'tahun_ajaran.aktif'
            )
            ->where('tahun_ajaran.aktif', 1) // Hanya tahun ajaran aktif
            ->orderBy('hari.id_hari') // Urutkan berdasarkan hari
            ->orderBy('kelas_mata_pelajaran.waktu_mulai'); // Urutkan berdasarkan waktu mulai

        // Jika kelas_id ada, tambahkan filter berdasarkan kelas
        if (isset($_GET['kelas_id']) && $_GET['kelas_id'] != '') {
            $filter = $_GET['kelas_id'];
            htmlspecialchars($filter);
            $kelas_id = $filter;
            $query->where('kelas_mata_pelajaran.kelas_id', $filter);
        }

        $data = $query->get();

        return view("staff_akademik.jadwalLihat.jadwal-kelas", compact('data', 'kelas', 'kelas_id'));
    }

    public function guru_index(Request $request)
{
    $guru = DB::table('guru')->get();
    $guru_id = $request->input('guru_id');

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
        ->where('tahun_ajaran.aktif', 1);

    if ($guru_id) {
        $query->where('kelas_mata_pelajaran.guru_id', $guru_id);
    }

    $data = $query->orderBy('hari.id_hari')->orderBy('kelas_mata_pelajaran.waktu_mulai')->get();

    return view("staff_akademik.jadwalLihat.jadwal-guru", compact('guru', 'data', 'guru_id'));
}


}
