<?php

namespace App\Http\Controllers\siswa\lms;

use App\Http\Controllers\Controller;
use App\Services\Lms\LmsMateriService;
use Illuminate\View\View;

class MateriSiswaController extends Controller
{
    public function __construct(
        protected LmsMateriService $materiService
    ) {}

    public function index(): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $data = $this->materiService->getSiswaMateriIndexData($siswaId);

        return view('siswa.lms.materi', $data);
    }

    public function detail(string $id): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $data = $this->materiService->getSiswaMateriDetail($id, $siswaId);

        return view('siswa.lms.detail_materi', $data);
    }
}
