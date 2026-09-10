<?php

namespace App\Http\Controllers\ekstrakurikuler;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ekstrakurikuler\RegisterEkstraRequest;
use App\Services\Ekstrakurikuler\EkstrakurikulerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EkstrakurikulerController extends Controller
{
    public function __construct(
        protected EkstrakurikulerService $ekstraService
    ) {}

    public function showForm(): View
    {
        $siswaId = Auth::guard('web-siswa')->user()->id_siswa;
        $data = $this->ekstraService->getRegistrationFormData($siswaId);

        return view('ekstrakurikuler.registrasi', $data);
    }

    public function submitForm(RegisterEkstraRequest $request): RedirectResponse
    {
        $siswaId = Auth::guard('web-siswa')->user()->id_siswa;
        $fileIzin = $request->file('surat_izin_orang_tua');
        $fileDokter = $request->file('surat_keterangan_dokter');

        $this->ekstraService->submitRegistration(
            $siswaId,
            $request->validated(),
            $fileIzin,
            $fileDokter
        );

        return redirect()->route('ekstrakurikuler.registrasi')->with('success', 'Pendaftaran berhasil!');
    }

    public function dashboardEkstra(): View
    {
        $data = $this->ekstraService->getPublicDashboardData();

        return view('ekstrakurikuler.dashboardEkstra', $data);
    }

    public function show(string $id): View
    {
        $data = $this->ekstraService->getPublicDetail($id);

        return view('ekstrakurikuler.detail', $data);
    }
}
