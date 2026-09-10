<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiSiswaController extends Controller
{
    /**
     * Halaman Daftar Prestasi Siswa (Read-Only)
     * Seluruh data prestasi diinput dan diverifikasi oleh Staff Akademik.
     */
    public function index(Request $request)
    {
        $idSiswa = auth()->guard('web-siswa')->user()?->id_siswa;

        if (! $idSiswa) {
            return redirect()->route('login');
        }

        $search = $request->input('search');

        // Mengambil prestasi siswa yang telah diverifikasi/dicatat oleh Staff Akademik
        $prestasi = Prestasi::where('siswa_id', $idSiswa)
            ->where('status_prestasi', 1)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_prestasi', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi_prestasi', 'like', '%' . $search . '%');
                });
            })
            ->latest('created_at')
            ->paginate(6)
            ->withQueryString();

        $totalPrestasi = Prestasi::where('siswa_id', $idSiswa)
            ->where('status_prestasi', 1)
            ->count();

        return view('siswa.prestasi.index', compact('prestasi', 'totalPrestasi', 'search'));
    }

    /**
     * Halaman Rincian Prestasi Siswa
     */
    public function show($id)
    {
        $idSiswa = auth()->guard('web-siswa')->user()?->id_siswa;

        $prestasi = Prestasi::where('id_prestasi', $id)
            ->where('siswa_id', $idSiswa)
            ->firstOrFail();

        return view('siswa.prestasi.show', compact('prestasi'));
    }
}
