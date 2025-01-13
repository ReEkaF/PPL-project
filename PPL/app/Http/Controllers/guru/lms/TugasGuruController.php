<?php

namespace App\Http\Controllers\guru\lms;

use Carbon\Carbon;

use App\Models\topik;
use App\Models\tugas;
use App\Models\materi;
use App\Models\file_tugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\NotifikasUploadTugas;
use App\Models\kelas_mata_pelajaran;
use App\Models\kelas;
use App\Models\pengumpulan_tugas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;

class TugasGuruController extends Controller
{
    public function index()
    {
        $id_guru = auth()->guard('web-guru')->user()->id_guru;
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'kelas',
            'mataPelajaran',
            'tugas' => function ($query) {
                $query->orderBy('deadline', 'asc');
            }
        ])
            ->where('guru_id', $id_guru)
            ->whereHas('tahunAjaran', fn($query) => $query->where('aktif', 1))
            ->get();

        $mataPelajaranGrup = $kelasMataPelajaran->groupBy('mata_pelajaran_id')
            ->map(function ($items) {
                return [
                    'mata_pelajaran' => $items->first()->mataPelajaran->nama_matpel,
                    'kelas' => $items->map(function ($item) {
                        return [
                            'nama_kelas' => $item->kelas->nama_kelas,
                            'id_kelas' => $item->kelas->id_kelas,
                            'id_kelas_matapelajaran' => $item->id_kelas_matapelajaran,
                            'tugas' => $item->tugas
                        ];
                    })
                ];
            });

        $allTasks = $kelasMataPelajaran->flatMap(function ($mapel) {
            return $mapel->tugas;
        })->sortBy('created_at')->groupBy(function ($task) {
            return Carbon::parse($task->created_at)->format('Y-m-d');
        });

        return view('guru.lms.tugas', [
            'mataPelajaranGrup' => $mataPelajaranGrup,
            'allTasks' => $allTasks,
            'kelasMataPelajaran' => $kelasMataPelajaran
        ]);
    }

    public function forumTugas($id)
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'topik' => function ($query) {
                $query->orderBy('created_at', 'desc');
                $query->with([
                    'tugas' => function ($q) {
                        $q->orderBy('created_at', 'desc');
                    },
                    'materi' => function ($q) {
                        $q->orderBy('created_at', 'desc');
                    }
                ]);
            },
            'kelas:id_kelas,nama_kelas',
        ])->findOrFail($id);

        $tugasTanpaTopik = tugas::where('kelas_mata_pelajaran_id', $id)
            ->whereNull('topik_id')
            ->orderBy('created_at', 'desc')
            ->get();

        $materiTanpaTopik = materi::where('kelas_mata_pelajaran_id', $id)
            ->whereNull('topik_id')
            ->orderBy('created_at', 'desc')
            ->get();



        return view('guru.lms.forum_tugas', [
            'id' => $kelasMataPelajaran->id_kelas_mata_pelajaran,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'listTopik' => $kelasMataPelajaran->topik,
            'kelas' => $kelasMataPelajaran->kelas,
            'tugasTanpaTopik' => $tugasTanpaTopik,
            'materiTanpaTopik' => $materiTanpaTopik
        ]);
    }

    public function create($id)
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'kelas:id_kelas,nama_kelas',
        ])->findOrFail($id);
        $topiks = topik::where('kelas_mata_pelajaran_id', $id)->get();
        return view('guru.lms.tugas.create', [
            'id' => $id,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'kelas' => $kelasMataPelajaran->kelas,
            'topiks' => $topiks
        ]);
    }



    public function detail($id)
    {
        $tugas = Tugas::with(['filetugas', 'topik', 'kelasMataPelajaran'])->find($id);

        return view('guru.lms.tugas.detail', compact('tugas'));
    }

    public function store(Request $request)
    {

        // dd($request->all());


        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'files.*' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,xlsx',
                'max:10000'
            ],
            'tenggat' => 'required|date',
            'kelas_mata_pelajaran_id' => 'required|exists:kelas_mata_pelajaran,id_kelas_mata_pelajaran'
        ], [
            'files.*.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
            'files.*.mimes' => 'File harus berupa PDF, DOC, DOCX, PPT, PPTX, atau XLSX.'
        ]);

        $topik_id = $request->topik_id ?? null;
        try {
            DB::beginTransaction();

            $tugas = tugas::create([
                'kelas_mata_pelajaran_id' => $request->kelas_mata_pelajaran_id,
                'topik_id' => $topik_id,
                'judul' => $request->judul_tugas,
                'deskripsi' => $request->deskripsi,
                'deadline' => Carbon::parse($request->tenggat)->format('Y-m-d H:i:s'),
                'created_at' => now(),
            ]);



            if ($request->hasFile('files')) {
                $this->handleFileUploads($request->file('files'), $tugas->id_tugas);
            }

            DB::commit();

            $namaTugas = $tugas->judul;
            $mataPelajaran = $tugas->kelasMataPelajaran->mataPelajaran->nama_matpel;
            $deadline = Carbon::parse($tugas->deadline)->format('d M Y H:i');


            $siswaNomorWhatsApp = Siswa::whereHas('kelas', function ($query) use ($tugas) {
                $query->whereHas('kelasMataPelajaran', function ($query) use ($tugas) {
                    $query->where('id_kelas_mata_pelajaran', $tugas->kelas_mata_pelajaran_id);
                });
            })->pluck('nomor_wa_siswa')->toArray();

            try {
                NotifikasUploadTugas::dispatch($namaTugas, $mataPelajaran, $deadline, $siswaNomorWhatsApp);
                return redirect()->route('guru.dashboard.lms.forum.tugas', $request->kelas_mata_pelajaran_id)->with('success', 'Tugas berhasil dibuat ');
            } catch (\Exception $e) {
                return redirect()->route('guru.dashboard.lms.forum.tugas', $request->kelas_mata_pelajaran_id)->with('success', 'Tugas berhasil dibuat tetapi notifikasi gagal dikirim');
                \Log::error('Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }




    public function edit($id)
    {
        $tugas = tugas::with([
            'filetugas',
            'topik',
            'kelasMataPelajaran' => function ($query) {
                $query->with(['mataPelajaran', 'kelas']);
            }
        ])->findOrFail($id);

        $topiks = topik::where('kelas_mata_pelajaran_id', $tugas->kelas_mata_pelajaran_id)->get();

        return view('guru.lms.tugas.edit', [
            'tugas' => $tugas,
            'mataPelajaran' => $tugas->kelasMataPelajaran->mataPelajaran,
            'kelas' => $tugas->kelasMataPelajaran->kelas,
            'topiks' => $topiks
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xlsx|max:2048',
            'tenggat' => 'required|date',
            'kelas_mata_pelajaran_id' => 'required|exists:kelas_mata_pelajaran,id_kelas_mata_pelajaran'
        ]);

        try {
            DB::beginTransaction();

            // Find the existing task
            $tugas = tugas::findOrFail($id);

            // Update task details
            $tugas->update([
                'topik_id' => $request->topik_id ?? null,
                'judul' => $request->judul_tugas,
                'deskripsi' => $request->deskripsi,
                'deadline' => Carbon::parse($request->tenggat)->format('Y-m-d H:i:s'),
                'updated_at' => now(),
            ]);

            if ($request->has('removed_files')) {
                $removedFileIds = $request->input('removed_files', []);
                // dd($removedFileIds);
                foreach ($removedFileIds as $fileId) {
                    $file = file_tugas::find($fileId);
                    if ($file) {
                        try {
                            // Dapatkan path lengkap file dari storage
                            $filePath = 'public/uploads/file_tugas/' . basename($file->file_path);

                            // Hapus file fisik menggunakan Storage facade
                            if (Storage::exists($filePath)) {
                                Storage::delete($filePath);
                            }
                            // Alternatif: Coba hapus langsung dari disk public
                            if (Storage::disk('public')->exists('uploads/file_tugas/' . basename($file->file_path))) {
                                Storage::disk('public')->delete('uploads/file_tugas/' . basename($file->file_path));
                            }

                            // Hapus record dari database
                            $file->delete();
                        } catch (\Exception $e) {
                            \Log::error('Gagal menghapus file: ' . $e->getMessage());
                            // Tetap hapus record database
                            $file->delete();
                        }
                    }
                }
            }

            // Update the status of late submissions
            $submissions = pengumpulan_tugas::where('tugas_id', $id)
                // Ambil semua pengumpulan tugas yang sudah diserahkan
                ->whereIn('status', ['diserahkan', 'terlambat diserahkan'])
                ->get();

            foreach ($submissions as $submission) {

                $deadline = Carbon::parse($request->tenggat);


                $submissionDate = Carbon::parse($submission->created_at);

                $isLate = $submissionDate->isAfter($deadline);

                $submission->update([
                    'status' => $isLate ? 'terlambat diserahkan' : 'diserahkan'
                ]);
            }

            // Handle new file uploads
            if ($request->hasFile('files')) {
                $this->handleFileUploads($request->file('files'), $tugas->id_tugas);
            }

            DB::commit();
            return redirect()->route('guru.dashboard.lms.forum.tugas', $tugas->kelas_mata_pelajaran_id)
                ->with('success', 'Tugas berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy($id, Request $request)
    {
        $id_kelas_mata_pelajaran = $request->kelas_mata_pelajaran_id;
        try {
            DB::beginTransaction();

            $files = file_tugas::where('tugas_id', $id)->get();
            foreach ($files as $file) {
                try {
                    $filePath = 'uploads/file_tugas/' . basename($file->file_path);

                    // Gunakan disk public untuk konsistensi
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                    $file->delete();
                } catch (\Exception $e) {
                    \Log::error('Failed to delete file: ' . $e->getMessage());
                    $file->delete();
                }
            }
            $tugas = tugas::findOrFail($id);
            $tugas->delete();
            DB::commit();
            return redirect()->route('guru.dashboard.lms.forum.tugas', $id_kelas_mata_pelajaran)->with('success', 'Tugas berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tugasSiswa($id)
    {
        $tugas = tugas::with(['pengumpulanTugas' => function ($query) {
            $query->with(['siswa', 'pengumpulanTugasFile']);
        }, 'kelasMataPelajaran'])->findOrFail($id);
        $siswaList = $tugas->kelasMataPelajaran->kelas->siswa;
        $pengumpulanTugas = $tugas->pengumpulantugas;
        $diserahkan = $pengumpulanTugas->count();
        $kelasMataPelajaran = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran'])->findOrFail($tugas->kelas_mata_pelajaran_id);
        $belumDiserahkan = $siswaList->count() - $diserahkan;

        return view('guru.lms.tugas.tugas_siswa', [
            'tugas' => $tugas,
            'kelas' => $kelasMataPelajaran->kelas,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'KelasMataPelajaranId' => $tugas->kelas_mata_pelajaran_id,
            'siswaList' => $siswaList,
            'pengumpulanTugas' => $pengumpulanTugas,
            'diserahkan' => $diserahkan,
            'belumDiserahkan' => $belumDiserahkan
        ]);
    }

    public function detailTugasSiswa($id)
    {

        $pengumpulan = pengumpulan_tugas::with(['siswa', 'pengumpulanTugasFile', 'tugas'])->findOrFail($id);
        $id_tugas = $pengumpulan->tugas->id_tugas;
        $tugas = tugas::with(['pengumpulanTugas' => function ($query) {
            $query->with(['siswa', 'pengumpulanTugasFile']);
        }, 'kelasMataPelajaran'])->findOrFail($id_tugas);
        $siswaList = $tugas->kelasMataPelajaran->kelas->siswa;
        $pengumpulanTugas = $tugas->pengumpulantugas;
        $kelasMataPelajaran = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran'])->findOrFail($tugas->kelas_mata_pelajaran_id);

        return view('guru.lms.tugas.detail_tugas_siswa', [
            'pengumpulan' => $pengumpulan,
            'tugas' => $tugas,
            'kelas' => $kelasMataPelajaran->kelas,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'KelasMataPelajaranId' => $tugas->kelas_mata_pelajaran_id,
            'siswaList' => $siswaList,
            'pengumpulanTugas' => $pengumpulanTugas,
        ]);
    }

    public function nilaiTugas(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'komentar' => 'nullable|string',
        ]);

        try {
            $pengumpulan = pengumpulan_tugas::findOrFail($id);
            $pengumpulan->update([
                'nilai' => $request->nilai,
                'komentar' => $request->komentar,
            ]);

            return redirect()->back()->with('success', 'Nilai berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function periksaTugas(Request $request)
    {
        $id_guru = auth()->guard('web-guru')->user()->id_guru;

        $kelasId = $request->input('kelas_id');

        $tugasQuery = tugas::with(['kelasMataPelajaran', 'pengumpulanTugas'])
            ->whereHas('kelasMataPelajaran', function ($query) use ($id_guru) {
                $query->where('guru_id', $id_guru);
            });


        if ($kelasId) {
            $tugasQuery->whereHas('kelasMataPelajaran', function ($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            });
        }

        $tugas = $tugasQuery->get();

        $infoTugas = $tugas->map(function ($t) {
            $totalSiswa = $t->kelasMataPelajaran->kelas->siswa->count();
            $siswaMenyerahkan = $t->pengumpulanTugas->count();
            $dinilai = $t->pengumpulanTugas->filter(function ($p) {
                return $p->nilai !== null;
            })->count();
            $siswaBelumMenyerahkan = $totalSiswa - $siswaMenyerahkan;
            $namaKelas = $t->kelasMataPelajaran->kelas->nama_kelas;
            $deadline = $t->deadline;

            return [
                'tugas' => $t,
                'totalSiswa' => $totalSiswa,
                'siswaMenyerahkan' => $siswaMenyerahkan,
                'dinilai' => $dinilai,
                'siswaBelumMenyerahkan' => $siswaBelumMenyerahkan,
                'namaKelas' => $namaKelas,
                'deadline' => $deadline

            ];
        });
        $kelasList = kelas::whereIn('id_kelas', function ($query) use ($id_guru) {
            $query->select('kelas_id')
                ->from('kelas_mata_pelajaran')
                ->where('guru_id', $id_guru);
        })->pluck('nama_kelas', 'id_kelas')->toArray();
        $kelasIds = array_keys($kelasList);
        $kelas = kelas::whereIn('id_kelas', $kelasIds)->orderBy('nama_kelas', 'asc')->get();

        return view('guru.lms.tracking_tugas', [
            'tugas' => $infoTugas,
            'kelasList' => $kelas,
            'kelasId' => $kelasId
        ]);
    }


    private function handleFileUploads($files, $tugas_id)
    {
        foreach ($files as $file) {

            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/file_tugas', $fileName, 'public');
            $fileType = $file->getClientMimeType();

            file_tugas::create([
                'tugas_id' => $tugas_id,
                'file_path' => $path,
                'file_type' => $fileType,
                'original_name' => $file->getClientOriginalName(),
                'upload_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
