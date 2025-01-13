<?php

namespace App\Http\Controllers\siswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\kelas_mata_pelajaran;
use App\Models\absensi_siswa;
use App\Models\pertemuan;

class AbsensiController extends Controller
{
    public function index()
    {
        $siswaId = Auth::guard('web-siswa')->id();

        $data = kelas_mata_pelajaran::with('kelas', 'mataPelajaran', 'guru', 'hari')
            ->whereHas('kelas.kelas_siswa', function ($query) use ($siswaId) {
                $query->where('id_siswa', $siswaId);
            })
            ->orderBy('hari_id')
            ->orderBy('waktu_mulai')
            ->get();

        return view("siswa.absensi.index", compact('data'));
    }

    public function details($id)
    {
        $siswaId = Auth::guard('web-siswa')->id();

        $detail = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran', 'guru', 'hari', 'pertemuan' => function ($query) use ($siswaId) {
            $query->with(['absensiSiswa' => function ($query) use ($siswaId) {
                $query->where('siswa_id', $siswaId);
            }]);
        }])->where('id_kelas_mata_pelajaran', $id)->firstOrFail();

        return view('siswa.absensi.pertemuan', compact('detail'));
    }

    public function scanQrCode($pertemuan_id, Request $request)
    {
        $siswaId = Auth::guard('web-siswa')->id();
        $absensi = absensi_siswa::where('siswa_id', $siswaId)
            ->where('pertemuan_id', $pertemuan_id)
            ->first();
        $pertemuan = pertemuan::find($pertemuan_id);
        $kelas_mata_pelajaran_id = $pertemuan->kelas_mata_pelajaran_id;

        $isEnrolled = absensi_siswa::where('siswa_id', $siswaId)
            ->whereHas('pertemuan', function ($query) use ($kelas_mata_pelajaran_id) {
                $query->where('kelas_mata_pelajaran_id', $kelas_mata_pelajaran_id);
            })
            ->exists();

        if (!$isEnrolled) {
            return redirect()->route('siswa.absensi.index')
                ->with('error', 'Anda tidak terdaftar pada kelas mata pelajaran ini.');
        }

        if ($absensi) {
            if ($pertemuan->status != 'Aktif') {
                return redirect()->route('siswa.absensi.details', [
                    'id' => $kelas_mata_pelajaran_id
                ])->with('error', 'Status pertemuan sedang tidak aktif');
            }

            if ($absensi->status_absensi == 'Hadir') {
                return redirect()->route('siswa.absensi.details', [
                    'id' => $kelas_mata_pelajaran_id
                ])->with('info', 'Anda sudah melakukan absensi kehadiran');
            }

            $absensi->status_absensi = 'Hadir';
            $absensi->save();

            return redirect()->route('siswa.absensi.details', [
                'id' => $kelas_mata_pelajaran_id
            ])->with('success', 'Status kehadiran berhasil diupdate');
        }

        return redirect()->route('siswa.absensi.index')
            ->with('error', 'Failed to update presence status.');
    }
}
