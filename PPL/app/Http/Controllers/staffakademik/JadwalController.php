<?php

namespace App\Http\Controllers\staffakademik;

use App\Exports\JadwalExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Akademik\StoreJadwalRequest;
use App\Http\Requests\Akademik\UpdateJadwalRequest;
use App\Imports\JadwalImport;
use App\Services\Akademik\JadwalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class JadwalController extends Controller
{
    public function __construct(
        protected JadwalService $jadwalService
    ) {}

    public function jadwalIndex(Request $request, ?string $kelas_id = null): View
    {
        $selectedKelasId = $request->input('kelas_id', $kelas_id);
        $data = $this->jadwalService->getJadwalIndexData($selectedKelasId);

        return view('staff_akademik.jadwalManagemen.index', $data);
    }

    public function createJadwal(): View
    {
        $formData = $this->jadwalService->getCreateFormData();

        return view('staff_akademik.jadwalManagemen.create', $formData);
    }

    public function storeJadwal(StoreJadwalRequest $request): RedirectResponse
    {
        $jadwalData = $request->input('jadwal');
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        $kelasId = $request->input('kelas_id');

        $bentrok = $this->jadwalService->storeJadwalBatch($kelasId, $tahunAjaranId, $jadwalData);

        if (! empty($bentrok)) {
            return redirect()->route('staff_akademik.jadwal')
                ->with('error', 'List jadwal bentrok')
                ->with('bentrok', $bentrok);
        }

        return redirect()->route('staff_akademik.jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function editJadwal(string $id): View
    {
        $formData = $this->jadwalService->getEditFormData($id);

        return view('staff_akademik.jadwalManagemen.edit', $formData);
    }

    public function updateJadwal(UpdateJadwalRequest $request, string $id): RedirectResponse
    {
        try {
            $this->jadwalService->updateJadwal($id, $request->validated());

            return redirect()->route('staff_akademik.jadwal')->with('success', 'Jadwal berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('staff_akademik.jadwal')->with('error-update', $e->getMessage());
        }
    }

    public function deleteJadwal(string $id): RedirectResponse
    {
        try {
            $this->jadwalService->deleteJadwal($id);

            return redirect()->route('staff_akademik.jadwal')->with('success', 'Jadwal berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('staff_akademik.jadwal')->with('error-delete', 'Jadwal tersebut sedang berlangsung atau tidak dapat dihapus.');
        }
    }

    public function importPage(): View
    {
        return view('staff_akademik.jadwalManagemen.importExcel');
    }

    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        try {
            Excel::import(new JadwalImport, $request->file('file'));

            return redirect()->route('staff_akademik.jadwal')->with('success', 'Jadwal berhasil diimport.');
        } catch (Exception $e) {
            return redirect()->route('staff_akademik.jadwal')->with('error-excel', $e->getMessage());
        }
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        $kelasId = $request->query('kelas_id');

        return Excel::download(new JadwalExport($kelasId), 'jadwal.xlsx');
    }

    public function exportPdf(Request $request): Response
    {
        $kelasId = $request->query('kelas_id');
        $indexData = $this->jadwalService->getJadwalIndexData($kelasId);
        $data = $indexData['data'];

        $pdf = Pdf::loadView('staff_akademik.jadwalManagemen.pdf', compact('data'));

        return $pdf->download('jadwal.pdf');
    }
}
