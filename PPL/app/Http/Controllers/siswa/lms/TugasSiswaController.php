<?php

namespace App\Http\Controllers\siswa\lms;

use Carbon\Carbon;
use App\Models\tugas;
use App\Models\materi;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;
use App\Models\pengumpulan_tugas;
use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use App\Models\PengumpulanTugasFile;
use Illuminate\Support\Facades\Storage;

class TugasSiswaController extends Controller
{
    public function index()
    {
        $idSiswa =  auth()->guard('web-siswa')->user()->id_siswa;


        $kelas = KelasSiswa::with('kelas')->where('id_siswa', $idSiswa)->firstOrFail()->kelas;


        $mataPelajaranList = kelas_mata_pelajaran::where('kelas_id', $kelas->id_kelas)
            ->with([
                'mataPelajaran',
                'tugas' => function ($query) {
                    $query->orderBy('deadline', 'asc');
                }
            ])
            ->get();


        $allTasks = $mataPelajaranList->flatMap(function ($mapel) {
            return $mapel->tugas;
        });


        $allTasks = $allTasks->sortBy('created_at')->groupBy(function ($task) {
            return Carbon::parse($task->created_at)->format('Y-m-d');
        });

        return view('siswa.lms.tugas', [
            'mataPelajaranList' => $mataPelajaranList,
            'allTasks' => $allTasks
        ]);
    }









    public function forumTugas($id)
    {
        $kelasMataPelajaran = kelas_mata_pelajaran::with([
            'mataPelajaran:id_matpel,nama_matpel',
            'topik.tugas',
            'topik.materi'
        ])->findOrFail($id);

        $tugasTanpaTopik = tugas::where('kelas_mata_pelajaran_id', $id)
            ->whereNull('topik_id')
            ->get();

        $materiTanpaTopik = materi::where('kelas_mata_pelajaran_id', $id)
            ->whereNull('topik_id')
            ->get();



        return view('siswa.lms.forum_tugas', [
            'id' => $kelasMataPelajaran->id_kelas_mata_pelajaran,
            'mataPelajaran' => $kelasMataPelajaran->mataPelajaran,
            'listTopik' => $kelasMataPelajaran->topik,
            'tugasTanpaTopik' => $tugasTanpaTopik,
            'materiTanpaTopik' => $materiTanpaTopik
        ]);
    }

    public function detail($id)
    {
        $tugas = tugas::with('kelasMataPelajaran', 'filetugas')->findOrFail($id);
        $pengumpulan = pengumpulan_tugas::with('pengumpulanTugasFile')
            ->where('tugas_id', $id)
            ->where('siswa_id', auth()->guard('web-siswa')->user()->id_siswa)
            ->first();
        $now = Carbon::now();
        // dd($pengumpulan->status);
        $deadline = Carbon::parse($tugas->deadline);

        if ($pengumpulan) {
            if ($pengumpulan->created_at <= $deadline) {
                $status_text = "diserahkan";
                $status_color = "bg-green-100 text-green-800";
            } else {
                $status_text = "terlambat diserahkan";
                $status_color = "bg-red-100 text-red-800";
            }
        } else {
            if ($now > $deadline) {
                $status_text = 'Tidak Diserahkan';
                $status_color = 'bg-red-100 text-red-800';
            } else {
                $status_text = 'Ditugaskan';
                $status_color = 'bg-blue-100 text-blue-800';
            }
        }
        return view('siswa.lms.detail_tugas', [
            "tugas" => $tugas,
            "kelasMataPelajaran" => $tugas->kelasMataPelajaran,
            "filetugas" => $tugas->filetugas,
            "pengumpulan" => $pengumpulan,
            "status_text" => $status_text,
            "status_color" => $status_color
        ]);
    }

    public function submit(Request $request, $id)
    {
        try {
            $request->validate([
                'files.*' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            ]);




            $now = Carbon::now();
            $idSiswa = auth()->guard('web-siswa')->user()->id_siswa;

            $pengumpulan = pengumpulan_tugas::where('tugas_id', $id)
                ->where('siswa_id', $idSiswa)
                ->first();

            if (!$pengumpulan) {
                $status = $this->setStatus($now, tugas::find($id)->deadline);

                $pengumpulan = pengumpulan_tugas::create([
                    'tugas_id' => $id,
                    'siswa_id' => $idSiswa,
                    'tanggal_pengumpulan' => $now,
                    'status' => $status,
                    'nilai' => null,
                    'komentar' => ''
                ]);

            }

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('uploads/pengumpulan_file_tugas', $filename, 'public');
                    $fileType = $file->getMimeType();
 
                    PengumpulanTugasFile::create([
                        'pengumpulan_tugas_id' => $pengumpulan->id_pengumpulan_tugas,
                        'file_path' => $path,
                        'file_type' => $fileType,
                        'original_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            return redirect()->back()
                ->with('success', 'Tugas berhasil dikumpulkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengumpulkan tugas: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function deleteFile($id)
    {
        try {
            $file = PengumpulanTugasFile::findOrFail($id);
            $filePath = 'public/uploads/pengumpulan_file_tugas/' . basename($file->file_path);


            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            if (Storage::disk('public')->exists('uploads/pengumpulan_file_tugas/' . basename($file->file_path))) {
                Storage::disk('public')->delete('uploads/pengumpulan_file_tugas/' . basename($file->file_path));
            }
            $file->delete();
            return redirect()->back()->with('success', 'File berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus file.');
        }
    }

    public function batalPengumpulan($id)
    {
        try {
            $pengumpulan = pengumpulan_tugas::findOrFail($id);

            foreach ($pengumpulan->pengumpulanTugasFile as $file) {
                $filePath = 'public/uploads/pengumpulan_file_tugas/' . basename($file->file_path);
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
                if (Storage::disk('public')->exists('uploads/pengumpulan_file_tugas/' . basename($file->file_path))) {
                    Storage::disk('public')->delete('uploads/pengumpulan_file_tugas/' . basename($file->file_path));
                }
                $file->delete();
            }
            $pengumpulan->delete();

            return redirect()->back()->with('success', 'Penyerahan tugas berhasil dibatalkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membatalkan penyerahan tugas.');
        }
    }


    public function setStatus($submitTime, $deadline)
    {
        if ($submitTime > Carbon::parse($deadline)) {
            return "terlambat diserahkan";
        }
        return "diserahkan";
    }
}
