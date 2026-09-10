<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Absensi\GeneratePresenceRequest;
use App\Services\Absensi\AbsensiService;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function __construct(
        protected AbsensiService $absensiService
    ) {}

    public function index(Request $request)
    {
        $viewData = $this->absensiService->getStaffIndexData($request->query('kelas_id'));

        return view('staff_akademik.absensi.index', [
            'data' => $viewData['data'],
            'allKelas' => $viewData['allKelas'],
        ]);
    }

    public function details($id)
    {
        $detail = $this->absensiService->getStaffMeetingList($id);

        return view('staff_akademik.absensi.pertemuan', compact('detail'));
    }

    public function pertemuanDetails($id, $pertemuan)
    {
        $viewData = $this->absensiService->getStaffMeetingDetails($id, $pertemuan);

        return view('staff_akademik.absensi.pertemuan_details', [
            'detail' => $viewData['detail'],
            'students' => $viewData['students'],
            'pertemuan' => $viewData['pertemuan'],
        ]);
    }

    public function generatePresenceData(GeneratePresenceRequest $request, $id)
    {
        $this->absensiService->generatePresenceData(
            $id,
            $request->input('first_week_date'),
            (int) $request->input('total_meetings')
        );

        return redirect()->route('akademik.absensi.details', $id)->with('success', 'Sukses membuat data absensi');
    }

    public function resetPertemuan($id)
    {
        $this->absensiService->resetPertemuan($id);

        return redirect()->route('akademik.absensi.details', $id)
            ->with('success', 'Sukses mereset absensi pertemuan');
    }

    public function updateStatus(Request $request)
    {
        $this->absensiService->updateStatuses($request->input('status_absensi', []));

        return back()->with('success', 'Status absensi berhasil diubah');
    }
}
