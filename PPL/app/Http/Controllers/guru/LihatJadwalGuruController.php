<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Services\Akademik\JadwalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LihatJadwalGuruController extends Controller
{
    public function __construct(
        protected JadwalService $jadwalService
    ) {}

    public function index(): View
    {
        $guru = Auth::guard('web-guru')->user();
        $query = $this->jadwalService->getJadwalForGuru($guru->id_guru);

        return view('guru.jadwal.lihat-jadwal', compact('guru', 'query'));
    }

    public function print(): Response
    {
        $guru = Auth::guard('web-guru')->user();
        $jadwal = $this->jadwalService->getJadwalForGuru($guru->id_guru);

        $pdf = Pdf::loadView('guru.jadwal.cetak-jadwal-guru', compact('guru', 'jadwal'));

        return $pdf->stream('jadwal-guru.pdf');
    }
}
