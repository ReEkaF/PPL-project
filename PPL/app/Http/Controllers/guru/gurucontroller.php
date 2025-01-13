<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index()
    {
        // $currentGuard = auth()->getDefaultDriver();
        // dd($currentGuard);
        return view('guru.dashboard');
    }
    public function daftarSiswaWali()
    {
        // Mendapatkan data guru yang sedang login
        $guru = Auth::guard('web-guru')->user();

       // Mendapatkan semua kelas yang diwalikan
        $kelasList = $guru->kelas;

        // Mendapatkan semua siswa di kelas yang diwalikan
        $siswaList = $guru->kelasSiswas->load('siswa');

        return view('guru.kelas.daftar_siswa_wali', compact('guru', 'kelasList', 'siswaList'));
    }
    public function daftarKelasDanJadwal()
    {
        $guru = Auth::guard('web-guru')->user();

        $kelasMataPelajaran = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'guru', 'hari'])  // Menambahkan relasi hari
            ->where('guru_id', $guru->id_guru)  // Filter berdasarkan guru yang sedang login
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')  // Pastikan kolom kelas_id benar
            ->orderBy('kelas.nama_kelas')  // Urutkan berdasarkan nama kelas
            ->get();

        return view('guru.kelas.jadwal_pelajaran_kelas', compact('kelasMataPelajaran'));
    }
}
