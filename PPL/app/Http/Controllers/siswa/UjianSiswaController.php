<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Services\Ujian\CbtService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UjianSiswaController extends Controller
{
    public function __construct(
        protected CbtService $cbtService
    ) {}

    /**
     * Halaman Daftar Ujian
     */
    public function index()
    {
        $ujians = $this->cbtService->getAvailableExamsForStudent();

        return view('siswa.ujian.index', compact('ujians'));
    }

    /**
     * Halaman Mulai Ujian
     */
    public function start($id)
    {
        $data = $this->cbtService->startExam($id);

        // Simpan waktu selesai ujian di session
        Session::put('ujian_end_time', $data['endTime']);

        return view('siswa.ujian.start', [
            'ujian' => $data['ujian'],
            'endTime' => $data['endTime'],
        ]);
    }

    /**
     * Submit Ujian
     */
    public function submit(Request $request, $idUjian)
    {
        $idSiswa = Auth::guard('web-siswa')->user()->id_siswa;

        $result = $this->cbtService->submitExam($idSiswa, $idUjian, $request->except('_token'));

        return view('siswa.ujian.end', $result);
    }
}
