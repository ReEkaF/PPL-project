<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LihatJadwalSiswaController extends Controller
{
    /**
     * Menampilkan jadwal siswa yang sedang login
     */
    public function index()
    {
        // Ambil data siswa yang sedang login
        $siswa = Auth::guard('web-siswa')->user();

        // Cari kelas siswa berdasarkan ID siswa
        $kelasSiswa = DB::table('kelas_siswas')
            ->where('id_siswa', $siswa->id_siswa)
            ->first();

        if (!$kelasSiswa) {
            return view('siswa.jadwal.jadwal-siswa', [
                'jadwal' => [],
                'siswa' => $siswa,
                'message' => 'Anda belum terdaftar dalam kelas.',
                'is_pdf' => false,
            ]);
        }

        // Ambil jadwal berdasarkan kelas
        $jadwal = DB::table('kelas_mata_pelajaran')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->where('kelas_mata_pelajaran.kelas_id', $kelasSiswa->id_kelas)
            ->orderBy('hari.nama_hari', 'desc')
            ->select(
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'mata_pelajaran.nama_matpel',
                'guru.nama_guru'
            )
            ->get();

        return view('siswa.jadwal.jadwal-siswa', [
            'jadwal' => $jadwal,
            'siswa' => $siswa,
            'is_pdf' => false,
        ]);
    }

    /**
     * Download jadwal dalam bentuk PDF
     */
    public function print()
    {
        $siswa = Auth::guard('web-siswa')->user();

        $kelasSiswa = DB::table('kelas_siswas')
            ->where('id_siswa', $siswa->id_siswa)
            ->first();

        if (!$kelasSiswa) {
            abort(404, 'Kelas tidak ditemukan.');
        }

        // Ambil jadwal berdasarkan kelas, urutkan berdasarkan hari dan waktu mulai
        $jadwal = DB::table('kelas_mata_pelajaran')
        ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
        ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
        ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
        ->where('kelas_mata_pelajaran.kelas_id', $kelasSiswa->id_kelas)
        ->orderBy('hari.nama_hari', 'desc')
        ->orderBy('kelas_mata_pelajaran.waktu_mulai') // Urutkan berdasarkan waktu mulai
        ->select(
            'hari.nama_hari',
            'kelas_mata_pelajaran.waktu_mulai',
            'kelas_mata_pelajaran.waktu_selesai',
            'mata_pelajaran.nama_matpel',
            'guru.nama_guru'
        )
        ->get();


        $pdf = Pdf::loadView('siswa.jadwal.cetak-jadwal-siswa', [
            'jadwal' => $jadwal,
            'siswa' => $siswa,
            'is_pdf' => true,
        ]);

        return $pdf->stream('jadwal-siswa.pdf');
    }
}
