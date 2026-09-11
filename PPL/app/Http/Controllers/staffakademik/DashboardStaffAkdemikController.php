<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use App\Models\kelas;
use App\Models\mata_pelajaran;
use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class DashboardStaffAkdemikController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('web-staffakademik')->user();
        $totalKelas = kelas::count();
        $totalMapel = mata_pelajaran::count();
        $totalSiswa = Siswa::count();
        $totalPrestasi = Prestasi::count();
        $pengajuanPending = Prestasi::where('status_prestasi', 'menunggu')
            ->orWhere('status_prestasi', 'pending')
            ->count();

        $daftarKelas = kelas::withCount('siswa')->take(6)->get();
        $prestasiTerbaru = Prestasi::with('siswa')->take(5)->get();

        return view('staff_akademik.dashboard', compact(
            'staff',
            'totalKelas',
            'totalMapel',
            'totalSiswa',
            'totalPrestasi',
            'pengajuanPending',
            'daftarKelas',
            'prestasiTerbaru'
        ));
    }
}

