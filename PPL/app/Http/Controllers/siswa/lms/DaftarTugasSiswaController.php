<?php

namespace App\Http\Controllers\siswa\lms;

use App\Http\Controllers\Controller;
use App\Services\Lms\LmsTugasService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DaftarTugasSiswaController extends Controller
{
    public function __construct(
        protected LmsTugasService $tugasService
    ) {}

    public function ditugaskan(Request $request): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $data = $this->tugasService->getStudentTracking($siswaId, 'ditugaskan', $request->query('mata_pelajaran'));

        return view('siswa.lms.tracking.ditugaskan', $data);
    }

    public function belumDiserahkan(Request $request): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $data = $this->tugasService->getStudentTracking($siswaId, 'belum_diserahkan', $request->query('mata_pelajaran'));

        return view('siswa.lms.tracking.belum_diserahkan', $data);
    }

    public function diserahkan(Request $request): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $data = $this->tugasService->getStudentTracking($siswaId, 'diserahkan', $request->query('mata_pelajaran'));

        return view('siswa.lms.tracking.diserahkan', $data);
    }
}
