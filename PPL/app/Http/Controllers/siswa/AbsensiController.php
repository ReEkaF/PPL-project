<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Services\Absensi\AbsensiService;
use Carbon\Carbon;
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

        $totalMeetings = 0;
        $totalHadir = 0;
        $totalIzin = 0;
        $totalSakit = 0;
        $totalAlpa = 0;
        $activeCount = 0;

        $namaHariIni = Carbon::now()->locale('id')->isoFormat('dddd');

        $data->each(function ($item) use (&$totalMeetings, &$totalHadir, &$totalIzin, &$totalSakit, &$totalAlpa, &$activeCount, $namaHariIni) {
            $hadir = 0;
            $izin = 0;
            $sakit = 0;
            $alpa = 0;
            $hasActive = false;
            $activePertemuanId = null;

            foreach ($item->pertemuan as $p) {
                if ($p->status === 'Aktif') {
                    $hasActive = true;
                    $activePertemuanId = $p->id_pertemuan;
                }
                $abs = $p->absensiSiswa->first() ?? $p->absensisiswa->first();
                if ($abs) {
                    match ($abs->status_absensi) {
                        'Hadir' => $hadir++,
                        'Izin' => $izin++,
                        'Sakit' => $sakit++,
                        'Alpa' => $alpa++,
                        default => null,
                    };
                }
            }

            if ($hasActive) {
                $activeCount++;
            }

            $mapelTotal = $hadir + $izin + $sakit + $alpa;
            $persentase = $mapelTotal > 0 ? round(($hadir / $mapelTotal) * 100) : 100;

            $totalMeetings += $mapelTotal;
            $totalHadir += $hadir;
            $totalIzin += $izin;
            $totalSakit += $sakit;
            $totalAlpa += $alpa;

            $isToday = false;
            if ($item->hari && strcasecmp($item->hari->nama_hari, $namaHariIni) === 0) {
                $isToday = true;
            }

            $item->stats = (object) [
                'total' => $mapelTotal,
                'total_jadwal' => $item->pertemuan->count(),
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'persentase' => $persentase,
                'has_active' => $hasActive,
                'active_pertemuan_id' => $activePertemuanId,
                'is_today' => $isToday,
            ];
        });

        $overallPersentase = $totalMeetings > 0 ? round(($totalHadir / $totalMeetings) * 100, 1) : 100;

        $statusLabel = 'Sangat Baik';
        $statusColor = 'emerald';
        if ($overallPersentase < 75) {
            $statusLabel = 'Perlu Perhatian';
            $statusColor = 'rose';
        } elseif ($overallPersentase < 85) {
            $statusLabel = 'Cukup Baik';
            $statusColor = 'amber';
        }

        $overallStats = (object) [
            'total' => $totalMeetings,
            'hadir' => $totalHadir,
            'izin' => $totalIzin,
            'sakit' => $totalSakit,
            'alpa' => $totalAlpa,
            'persentase' => $overallPersentase,
            'status_label' => $statusLabel,
            'status_color' => $statusColor,
            'active_count' => $activeCount,
            'nama_hari_ini' => $namaHariIni,
        ];

        return view('siswa.absensi.index', compact('data', 'overallStats'));
    }

    public function details($id)
    {
        $siswaId = Auth::guard('web-siswa')->id();
        $detail = $this->absensiService->getSiswaMeetingDetails($id, $siswaId);

        if (! $detail) {
            abort(404);
        }

        $hadir = 0;
        $izin = 0;
        $sakit = 0;
        $alpa = 0;
        $activePertemuan = null;

        foreach ($detail->pertemuan as $p) {
            if ($p->status === 'Aktif') {
                $activePertemuan = $p;
            }
            $abs = $p->absensiSiswa->first() ?? $p->absensisiswa->first();
            if ($abs) {
                match ($abs->status_absensi) {
                    'Hadir' => $hadir++,
                    'Izin' => $izin++,
                    'Sakit' => $sakit++,
                    'Alpa' => $alpa++,
                    default => null,
                };
            }
        }

        $totalTercatat = $hadir + $izin + $sakit + $alpa;
        $persentase = $totalTercatat > 0 ? round(($hadir / $totalTercatat) * 100, 1) : 100;

        $isEligible = $persentase >= 75;

        $activeAttendanceStatus = null;
        if ($activePertemuan) {
            $abs = $activePertemuan->absensiSiswa->first() ?? $activePertemuan->absensisiswa->first();
            $activeAttendanceStatus = $abs ? $abs->status_absensi : null;
        }

        $stats = (object) [
            'total' => $totalTercatat,
            'total_pertemuan' => $detail->pertemuan->count(),
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpa' => $alpa,
            'persentase' => $persentase,
            'is_eligible' => $isEligible,
            'active_pertemuan' => $activePertemuan,
            'active_attendance_status' => $activeAttendanceStatus,
        ];

        return view('siswa.absensi.pertemuan', compact('detail', 'stats'));
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
