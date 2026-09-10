<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Services\Absensi\AbsensiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function __construct(
        protected AbsensiService $absensiService
    ) {}

    public function index(Request $request)
    {
        $guruId = Auth::guard('web-guru')->id();
        $viewData = $this->absensiService->getGuruIndexData($guruId, $request->query('kelas_id'));

        return view('guru.absensi.index', [
            'data' => $viewData['data'],
            'allKelas' => $viewData['allKelas'],
        ]);
    }

    public function details($id)
    {
        $detail = $this->absensiService->getStaffMeetingList($id);

        return view('guru.absensi.pertemuan', compact('detail'));
    }

    public function pertemuanDetails($id, $pertemuan)
    {
        $viewData = $this->absensiService->getStaffMeetingDetails($id, $pertemuan);

        return view('guru.absensi.pertemuan_details', [
            'detail' => $viewData['detail'],
            'students' => $viewData['students'],
            'pertemuan' => $viewData['pertemuan'],
        ]);
    }

    public function updateStatus(Request $request)
    {
        $this->absensiService->updateStatuses($request->input('status_absensi', []));

        return back()->with('success', 'Status absensi berhasil diubah');
    }

    public function updateStatusQr(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pertemuan,id_pertemuan',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $this->absensiService->updatePertemuanStatus($request->id, $request->status);

        return response()->json([
            'success' => true,
            'message' => 'Status QR Code berhasil diubah menjadi ' . $request->status,
            'status' => $request->status,
        ]);
    }
}
