<?php

namespace App\Http\Controllers\pengurusekstra;

use App\Http\Controllers\Controller;
use App\Services\Ekstrakurikuler\EkstrakurikulerService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnggotaController extends Controller
{
    public function __construct(
        protected EkstrakurikulerService $ekstraService
    ) {}

    public function index(): View
    {
        $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
        $data = $this->ekstraService->getPengurusAnggotaData($siswaId);

        return view('pengurus_ekstra.anggota.index', $data);
    }

    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        try {
            $siswaId = auth()->guard('web-siswa')->user()->id_siswa;
            $status = $request->input('status');

            $this->ekstraService->updateMemberStatusPengurus($siswaId, $id, $status);

            return redirect()->route('pengurus_ekstra.anggota')->with('success', 'Status berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('pengurus_ekstra.anggota')->withErrors('Gagal memperbarui status: '.$e->getMessage());
        }
    }
}
