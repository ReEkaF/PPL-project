<?php

namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use App\Models\kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
        public function index()
    {
        return view('siswa.dashboard');
    }
    public function show($id_kelas, $id_siswa)
    {
        // Menggunakan alias untuk kolom id_siswa agar tidak terjadi ambiguitas
        $kelas = kelas::with(['siswa' => function ($query) use ($id_siswa) {
            $query->where('kelas_siswas.id_siswa', $id_siswa); // Menambahkan alias 'kelas_siswas.id_siswa'
        }])->findOrFail($id_kelas);

        $siswa = $kelas->siswa->first();

        if (!$siswa) {
            abort(403, 'Akses ditolak: Siswa tidak ditemukan di kelas ini.');
        }

        return view('guru.kelas.profil_siswa', compact('siswa', 'kelas'));
    }
}
