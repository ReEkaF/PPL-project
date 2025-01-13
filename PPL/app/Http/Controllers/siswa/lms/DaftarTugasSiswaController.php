<?php

namespace App\Http\Controllers\siswa\lms;

use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;

class DaftarTugasSiswaController extends Controller
{
    public function belumDiserahkan(Request $request)
    {
        $idSiswa = auth()->guard('web-siswa')->user()->id_siswa;

        // Mendapatkan kelas siswa
        $kelas = KelasSiswa::with(['kelas', 'tahunAjaran'])
            ->where('id_siswa', $idSiswa)
            ->whereHas('tahunAjaran', function ($query) {
                $query->where('aktif', '1');
            })
            ->firstOrFail()
            ->kelas;

        // Query awal untuk mata pelajaran di kelas siswa
        $kelasMataPelajaranQuery = kelas_mata_pelajaran::where('kelas_id', $kelas->id_kelas)
            ->with('mataPelajaran');

        // Mendapatkan daftar mata pelajaran untuk dropdown
        $mataPelajaranList = $kelasMataPelajaranQuery->get()->pluck('mataPelajaran.nama_matpel', 'mataPelajaran.id_matpel');

        // Filter mata pelajaran jika dipilih
        if ($request->has('mata_pelajaran') && $request->mata_pelajaran) {
            $kelasMataPelajaranQuery->whereHas('mataPelajaran', function ($query) use ($request) {
                $query->where('id_matpel', $request->mata_pelajaran);
            });
        }

        // Mendapatkan tugas yang belum diserahkan
        $kelasMataPelajaran = $kelasMataPelajaranQuery
            ->with([
                'mataPelajaran',
                'tugas' => function ($query) use ($idSiswa) {
                    $query
                        // Tugas yang belum diserahkan
                        ->whereDoesntHave('pengumpulanTugas', function ($subQuery) use ($idSiswa) {
                            $subQuery->where('siswa_id', $idSiswa);
                        })
                        // Tambahan: tugas yang masih aktif (deadline belum lewat)
                        ->whereDate('deadline', '<=', now())
                        ->orderBy('tugas.deadline', 'asc');
                }
            ])
            ->get()
            // Filter out mata pelajaran without tasks
            ->filter(function ($mataPelajaran) {
                return $mataPelajaran->tugas->isNotEmpty();
            });

        return view('siswa.lms.tracking.belum_diserahkan', [
            'kelasMataPelajaran' => $kelasMataPelajaran,
            'mataPelajaranList' => $mataPelajaranList,
            'selectedMataPelajaran' => $request->mata_pelajaran
        ]);
    }

    public function diserahkan(Request $request)
    {
        $idSiswa = auth()->guard('web-siswa')->user()->id_siswa;

        // Mendapatkan kelas siswa
        $kelas = KelasSiswa::with(['kelas', 'tahunAjaran'])
            ->where('id_siswa', $idSiswa)
            ->whereHas('tahunAjaran', function ($query) {
                $query->where('aktif', '1');
            })
            ->firstOrFail()
            ->kelas;

        $kelasMataPelajaranQuery = kelas_mata_pelajaran::where('kelas_id', $kelas->id_kelas)
            ->with('mataPelajaran');

        // Mendapatkan daftar mata pelajaran untuk dropdown
        $mataPelajaranList = $kelasMataPelajaranQuery->get()->pluck('mataPelajaran.nama_matpel', 'mataPelajaran.id_matpel');

        // Filter mata pelajaran jika dipilih
        if ($request->has('mata_pelajaran') && $request->mata_pelajaran) {
            $kelasMataPelajaranQuery->whereHas('mataPelajaran', function ($query) use ($request) {
                $query->where('id_matpel', $request->mata_pelajaran);
            });
        }

        // Mendapatkan tugas yang sudah diserahkan oleh siswa
        $kelasMataPelajaran = $kelasMataPelajaranQuery
            ->with([
                'mataPelajaran',
                'tugas' => function ($query) use ($idSiswa) {
                    $query->whereHas('pengumpulanTugas', function ($subQuery) use ($idSiswa) {
                        $subQuery->where('siswa_id', $idSiswa)
                            ->whereIn('status', ['diserahkan', 'terlambat diserahkan']);
                    })
                        ->with(['pengumpulanTugas' => function ($subQuery) use ($idSiswa) {
                            $subQuery->where('siswa_id', $idSiswa)
                                ->whereIn('status', ['diserahkan', 'terlambat diserahkan']);
                        }])
                        ->orderBy('tugas.created_at', 'asc');
                }
            ])
            ->get()
            // Filter out mata pelajaran without submitted tasks
            ->filter(function ($mataPelajaran) {
                return $mataPelajaran->tugas->isNotEmpty();
            });
        return view('siswa.lms.tracking.diserahkan', [
            'kelasMataPelajaran' => $kelasMataPelajaran,
            'mataPelajaranList' => $mataPelajaranList,
            'selectedMataPelajaran' => $request->mata_pelajaran
        ]);
    }

    public function ditugaskan(Request $request)
    {
        $idSiswa = auth()->guard('web-siswa')->user()->id_siswa;

        // Mendapatkan kelas siswa
        $kelas = KelasSiswa::with(['kelas', 'tahunAjaran'])
            ->where('id_siswa', $idSiswa)
            ->whereHas('tahunAjaran', function ($query) {
                $query->where('aktif', '1');
            })
            ->firstOrFail()
            ->kelas;

        // Query awal untuk mata pelajaran di kelas siswa
        $kelasMataPelajaranQuery = kelas_mata_pelajaran::where('kelas_id', $kelas->id_kelas)
            ->with('mataPelajaran');

        // Mendapatkan daftar mata pelajaran untuk dropdown
        $mataPelajaranList = $kelasMataPelajaranQuery->get()->pluck('mataPelajaran.nama_matpel', 'mataPelajaran.id_matpel');

        // Filter mata pelajaran jika dipilih
        if ($request->has('mata_pelajaran') && $request->mata_pelajaran) {
            $kelasMataPelajaranQuery->whereHas('mataPelajaran', function ($query) use ($request) {
                $query->where('id_matpel', $request->mata_pelajaran);
            });
        }

        // Mendapatkan tugas yang masih ditugaskan
        $kelasMataPelajaran = $kelasMataPelajaranQuery
            ->with([
                'mataPelajaran',
                'tugas' => function ($query) use ($idSiswa) {
                    $query
                        ->whereDate('tugas.deadline', '>=', now())  // Deadline belum lewat
                        ->whereDoesntHave('pengumpulanTugas', function ($subQuery) use ($idSiswa) {
                            $subQuery->where('siswa_id', $idSiswa);
                        })
                        ->orderBy('tugas.deadline', 'asc');  // Urutkan berdasarkan deadline terdekat
                }
            ])
            ->get()
            // Filter out mata pelajaran without tasks
            ->filter(function ($mataPelajaran) {
                return $mataPelajaran->tugas->isNotEmpty();
            });

        return view('siswa.lms.tracking.ditugaskan', [
            'kelasMataPelajaran' => $kelasMataPelajaran,
            'mataPelajaranList' => $mataPelajaranList,
            'selectedMataPelajaran' => $request->mata_pelajaran
        ]);
    }
}
