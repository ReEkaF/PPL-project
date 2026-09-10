<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Services\Absensi\AbsensiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function __construct(
        protected AbsensiService $absensiService
    ) {}

    public function index()
    {
        $siswaId = Auth::guard('web-siswa')->id();
        $data = $this->absensiService->getSiswaSchedule($siswaId);

        return view('siswa.absensi.index', compact('data'));
    }

    public function details($id)
    {
        $siswaId = Auth::guard('web-siswa')->id();
        $detail = $this->absensiService->getSiswaMeetingDetails($id, $siswaId);

        if (! $detail) {
            abort(404);
        }

        return view('siswa.absensi.pertemuan', compact('detail'));
    }

    public function scanQrCode($pertemuan_id, Request $request)
    {
        $siswaId = Auth::guard('web-siswa')->id();
        $result = $this->absensiService->scanQrCode($siswaId, $pertemuan_id);

        if ($result['status'] === 'not_enrolled') {
            return redirect()->route('siswa.absensi.index')
                ->with('error', $result['message']);
        }

        if ($result['kmp_id']) {
            return redirect()->route('siswa.absensi.details', ['id' => $result['kmp_id']])
                ->with($result['status'], $result['message']);
        }

        return redirect()->route('siswa.absensi.index')
            ->with('error', $result['message']);
    }
}
