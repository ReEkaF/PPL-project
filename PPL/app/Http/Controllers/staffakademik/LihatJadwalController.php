<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Services\Akademik\JadwalService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LihatJadwalController extends Controller
{
    public function __construct(
        protected JadwalService $jadwalService
    ) {}

    public function kelas_index(Request $request, ?string $kelas_id = null): View
    {
        $selectedKelasId = $request->input('kelas_id', $kelas_id);
        $data = $this->jadwalService->getJadwalIndexData($selectedKelasId);

        return view('staff_akademik.jadwalLihat.jadwal-kelas', [
            'data' => $data['data'],
            'kelas' => $data['kelas'],
            'kelas_id' => $data['kelas_id'],
        ]);
    }

    public function guru_index(Request $request): View
    {
        $guruList = Guru::orderBy('nama_guru')->get();
        $guruId = $request->input('guru_id');

        $data = $this->jadwalService->getJadwalForGuru($guruId ?: null);

        return view('staff_akademik.jadwalLihat.jadwal-guru', [
            'guru' => $guruList,
            'data' => $data,
            'guru_id' => $guruId,
        ]);
    }
}
