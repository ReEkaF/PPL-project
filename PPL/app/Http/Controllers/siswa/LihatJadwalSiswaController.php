<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Services\Akademik\JadwalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LihatJadwalSiswaController extends Controller
{
    public function __construct(
        protected JadwalService $jadwalService
    ) {}

    public function index(): View
    {
        $siswa = Auth::guard('web-siswa')->user();
        $result = $this->jadwalService->getJadwalForSiswa($siswa->id_siswa);

        if (! $result['has_kelas']) {
            return view('siswa.jadwal.jadwal-siswa', [
                'jadwal' => collect(),
                'siswa' => $siswa,
                'message' => 'Anda belum terdaftar dalam kelas.',
                'is_pdf' => false,
            ]);
        }

        return view('siswa.jadwal.jadwal-siswa', [
            'jadwal' => $result['jadwal'],
            'siswa' => $siswa,
            'is_pdf' => false,
        ]);
    }

    public function print(): Response
    {
        $siswa = Auth::guard('web-siswa')->user();
        $result = $this->jadwalService->getJadwalForSiswa($siswa->id_siswa);

        if (! $result['has_kelas']) {
            abort(404, 'Kelas tidak ditemukan.');
        }

        $pdf = Pdf::loadView('siswa.jadwal.cetak-jadwal-siswa', [
            'jadwal' => $result['jadwal'],
            'siswa' => $siswa,
            'is_pdf' => true,
        ]);

        return $pdf->stream('jadwal-siswa.pdf');
    }
}
