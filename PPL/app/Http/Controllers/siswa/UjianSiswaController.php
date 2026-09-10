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
    public function index(Request $request)
    {
        $idSiswa = Auth::guard('web-siswa')->user()?->id_siswa;
        $status = $request->query('status', 'semua');

        $data = $this->cbtService->getAvailableExamsForStudentPaginated($idSiswa, $status, 6);

        return view('siswa.ujian.index', $data);
    }

    /**
     * Halaman Mulai Ujian
     */
    public function start(Request $request, $id)
    {
        $idSiswa = Auth::guard('web-siswa')->user()?->id_siswa;

        if (! $idSiswa) {
            return redirect()->route('login');
        }

        $token = $request->query('token') ?? $request->input('token');

        try {
            $data = $this->cbtService->startExam($id, $idSiswa, $token);

            // Simpan waktu selesai ujian di session
            Session::put('ujian_end_time', $data['endTime']);

            return view('siswa.ujian.start', [
                'ujian' => $data['ujian'],
                'endTime' => $data['endTime'],
            ]);
        } catch (\Exception $e) {
            return redirect()->route('siswa.ujian.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Submit Ujian
     */
    public function submit(Request $request, $idUjian)
    {
        $idSiswa = Auth::guard('web-siswa')->user()?->id_siswa;

        if (! $idSiswa) {
            return redirect()->route('login');
        }

        try {
            $result = $this->cbtService->submitExam($idSiswa, $idUjian, $request->except('_token'));

            return view('siswa.ujian.end', $result);
        } catch (\Exception $e) {
            return redirect()->route('siswa.ujian.index')->with('error', $e->getMessage());
        }
    }
}
