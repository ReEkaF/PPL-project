<?php

namespace App\Http\Controllers\guru;

use App\Models\hari;
use App\Models\kelas;
use App\Models\kelas_mata_pelajaran;
use App\Models\pertemuan;
use App\Models\absensi_siswa;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $guruId = Auth::guard('web-guru')->id();

        $allKelas = Kelas::whereHas('kelasmatapelajaran', function ($query) use ($guruId) {
            $query->where('guru_id', $guruId);
        })->orderByRaw('LENGTH(nama_kelas)')
        ->orderBy('nama_kelas')
        ->get();

        $query = kelas_mata_pelajaran::with('kelas', 'mataPelajaran', 'guru', 'hari')
            ->where('guru_id', $guruId)
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->orderByRaw('LENGTH(kelas.nama_kelas)')
            ->orderBy('kelas.nama_kelas')
            ->orderBy('hari_id')
            ->orderBy('waktu_mulai');

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $data = $query->get();

        return view("guru.absensi.index", compact('data', 'allKelas'));
    }

    public function details($id)
    {
        $detail = kelas_mata_pelajaran::with('kelas', 'mataPelajaran', 'guru', 'hari', 'pertemuan')
            ->where('id_kelas_mata_pelajaran', $id)
            ->firstOrFail();

        return view('guru.absensi.pertemuan', compact('detail'));
    }

    public function pertemuanDetails($id, $pertemuan)
    {
        $detail = kelas_mata_pelajaran::with('kelas', 'mataPelajaran', 'guru', 'hari')
            ->where('id_kelas_mata_pelajaran', $id)
            ->firstOrFail();

        // $students = absensi_siswa::where('pertemuan_id', $pertemuan)
        //     ->with(['siswa' => function ($query) {
        //         $query->orderBy('nisn');
        //     }])
        //     ->get();

        $students = DB::table('absensi_siswa')
            ->join('siswa', 'absensi_siswa.siswa_id', '=', 'siswa.id_siswa')
            ->where('absensi_siswa.pertemuan_id', $pertemuan)
            ->orderBy('siswa.nisn')
            ->select('absensi_siswa.*', 'siswa.nisn', 'siswa.nama_siswa')
            ->get();

        $pertemuan = pertemuan::find($pertemuan);

        return view('guru.absensi.pertemuan_details', compact('detail', 'students', 'pertemuan'));
    }

    public function updateStatus(Request $request)
    {
        $statusAbsensi = $request->input('status_absensi');

        foreach ($statusAbsensi as $id => $status) {
            absensi_siswa::where('id_absensi_siswa', $id)->update(['status_absensi' => $status]);
        }

        return back()->with('success', 'Status absensi berhasil diubah');
    }

    public function updateStatusQr(Request $request)
    {
        $pertemuan = pertemuan::find($request->id);
        $pertemuan->status = $request->status;
        $pertemuan->save();

        return response()->json(['success' => true]);
    }
}
