<?php

namespace App\Http\Controllers\guru\lms;

use Exception;
use App\Models\topik;
use App\Models\materi;
use App\Models\file_materi;
use Illuminate\Http\Request;
use App\Models\notifikasi_sistem;
use App\Http\Controllers\Controller;
use App\Models\kelas_mata_pelajaran;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Jobs\NotifikasiMateri;


class MateriGuruController extends Controller
{
    public function index()
    {
        $data['kelas_mata_pelajaran'] = kelas_mata_pelajaran::with('kelas', 'mataPelajaran')->where('guru_id', auth()->guard(name: 'web-guru')->user()->id_guru)->WhereHas('tahunAjaran', fn($query) => $query->where('aktif', 1))->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')->orderBy('kelas.nama_kelas', 'asc')->get();
        $data['materi'] = materi::whereIn('kelas_mata_pelajaran_id', $data['kelas_mata_pelajaran']->pluck('id_kelas_mata_pelajaran'))->where('status', 1)->get();
        $data['materi_baru'] = materi::whereIn('kelas_mata_pelajaran_id', $data['kelas_mata_pelajaran']->pluck('id_kelas_mata_pelajaran'))->orderBy('created_at', 'desc')->get();
        $data['materi_baru_date'] = $data['materi_baru']->pluck('updated_at')->map(function ($date) {
            return $date->format('d F Y');
        })->unique()->values();

        return view('guru.lms.materi', $data);
    }

    public function detail($id)
    {
        $data['materi'] = materi::findOrFail($id);
        $data['file_materi'] = file_materi::where('materi_id', $id)->get();

        return view('guru.lms.materi.detail', $data);
    }

    public function createView()
    {
        $data['kelas_mata_pelajaran'] = kelas_mata_pelajaran::with('kelas', 'mataPelajaran')->where('guru_id', auth()->guard(name: 'web-guru')->user()->id_guru)->WhereHas('tahunAjaran', fn($query) => $query->where('aktif', 1))->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')->orderBy('kelas.nama_kelas', 'asc')->get();
        $data['topik'] = topik::with('kelasMataPelajaran')->whereIn('kelas_mata_pelajaran_id', $data['kelas_mata_pelajaran']->pluck('id_kelas_mata_pelajaran'))->get();


        return view('guru.lms.materi.create_view', $data);
    }

    public function create($id)
    {
        $data['id'] = $id;
        $data['kelas_mata_pelajaran'] = kelas_mata_pelajaran::findOrFail($id);
        $data['topik'] = topik::where('kelas_mata_pelajaran_id', $id)->get();
        $data['materi_old'] = materi::where('kelas_mata_pelajaran_id', $id)->where('status', 0)->first();
        $data['mata_pelajaran'] = $data['kelas_mata_pelajaran']->mataPelajaran;

        if ($data['materi_old']) $data['file_materi_old'] = file_materi::where('materi_id', $data['materi_old']->id_materi)->get();

        return view('guru.lms.materi.create', $data);
    }

    public function store(Request $request)
    {
        // Validation
        $rule = [
            'judul_materi' => 'required|string|max:255',
            'file_materi.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xlsx|max:10240',
        ];
        if ($request->has('id_materi')) {
            $fileMateri = file_materi::where('materi_id', $request->id_materi)->count();
            $countRemovedFiles = $request->has('removed_files') ? count($request->removed_files) : 0;
            if ($countRemovedFiles == $fileMateri) $rule['file_materi'] = 'required|array';
        } else {
            $rule['file_materi'] = 'required|array';
        }

        $request->validate($rule, [
            'judul_materi.required' => 'Judul Materi harus diisi',
            'judul_materi.max' => 'Judul Materi maksimal 255 karakter',
            'file_materi.required' => 'File Materi harus diisi',
            'file_materi.*.file' => 'File harus berupa file dengan ekstensi: pdf, doc, docx, ppt, pptx, xlsx',
            'file_materi.*.mimes' => 'File harus berupa file dengan ekstensi: pdf, doc, docx, ppt, pptx, xlsx',
            'file_materi.*.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            DB::beginTransaction();

            // Insert / Update into Materi Table
            $status = $request->has('post') ? 1 : 0;
            if ($request->has('id_materi')) {
                $materi = materi::findOrFail($request->id_materi);
                $materi->update(
                    [
                        'kelas_mata_pelajaran_id' => $request->id_kelas_mata_pelajaran,
                        'topik_id' => $request->topik_id,
                        'judul_materi' => $request->judul_materi,
                        'deskripsi' => $request->deskripsi,
                        'status' => $status,
                    ]
                );
            } else {
                $materi = materi::create(
                    [
                        'kelas_mata_pelajaran_id' => $request->id_kelas_mata_pelajaran,
                        'topik_id' => $request->topik_id,
                        'judul_materi' => $request->judul_materi,
                        'deskripsi' => $request->deskripsi,
                        'status' => $status,
                    ]
                );
            }

            // Remove file materi
            if ($request->has('removed_files')) {
                $removedFileIds = $request->input('removed_files', []);
                foreach ($removedFileIds as $fileId) {
                    $file = file_materi::find($fileId);
                    \Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
            }

            // Insert into File Materi Table
            if ($request->hasFile('file_materi')) {
                $this->handleFileUploads($request->file('file_materi'), $materi->id_materi);
            }

            DB::commit();

            if ($request->has('post')) {
                DB::beginTransaction();

                // Insert into Notifikasi Table
                $kelas_mata_pelajaran = kelas_mata_pelajaran::with('kelas')->findOrFail($request->id_kelas_mata_pelajaran);
                $siswa = $kelas_mata_pelajaran->kelas->siswa;

                foreach ($siswa as $item) {
                    notifikasi_sistem::create(
                        [
                            'materi_id' => $materi->id_materi,
                            'siswa_id' => $item->id_siswa,
                            'status' => 0,
                        ]
                    );
                }

                DB::commit();

                // Send notification to Whatsapp
                $siswaNomorWhatsApp = Siswa::whereHas('kelas', function ($query) use ($materi) {
                    $query->whereHas('kelasMataPelajaran', function ($query) use ($materi) {
                        $query->where('id_kelas_mata_pelajaran', $materi->kelas_mata_pelajaran_id);
                    });
                })->pluck('nomor_wa_siswa')->toArray();

                try {
                    NotifikasiMateri::dispatch($materi, $kelas_mata_pelajaran, $siswaNomorWhatsApp, 'store');
                    return redirect()->route('guru.dashboard.lms.materi')->with('success', 'Materi berhasil dibuat dan notifikasi berhasil dikirim.');
                } catch (Exception $e) {
                    DB::rollBack();
                    return redirect()->route('guru.dashboard.lms.materi')->with('success', 'Materi berhasil dibuat tetapi notifikasi gagal dikirim.');
                    \Log::error('Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
                }
            } else {
                return redirect()->route('guru.dashboard.lms.materi')->with('success', 'Draft Materi berhasil dibuat.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['id'] = $id;
        $data['materi'] = materi::findOrFail($id);
        $data['kelas_mata_pelajaran'] = kelas_mata_pelajaran::findOrFail($data['materi']->kelas_mata_pelajaran_id);
        $data['topik'] = topik::where('kelas_mata_pelajaran_id', $data['kelas_mata_pelajaran']->id_kelas_mata_pelajaran)->get();
        $data['file_materi_old'] = file_materi::where('materi_id', $id)->get();
        $data['mata_pelajaran'] = $data['kelas_mata_pelajaran']->mataPelajaran;

        return view('guru.lms.materi.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $rule = [
            'judul_materi' => 'required|string|max:255',
            'file_materi.*' => 'file|mimes:pdf,doc,docx,ppt,pptx,xlsx|max:2048',
        ];

        $fileMateri = file_materi::where('materi_id', $id)->count();
        $countRemovedFiles = $request->has('removed_files') ? count($request->removed_files) : 0;
        if ($countRemovedFiles == $fileMateri) $rule['file_materi'] = 'required|array';

        $request->validate($rule);

        try {
            DB::beginTransaction();

            $materi = materi::findOrFail($id);
            $materi->update(
                [
                    'kelas_mata_pelajaran_id' => $request->id_kelas_mata_pelajaran,
                    'topik_id' => $request->topik_id,
                    'judul_materi' => $request->judul_materi,
                    'deskripsi' => $request->deskripsi,
                    'updated_at' => now()
                ]
            );

            // Remove file materi
            if ($request->has('removed_files')) {
                $removedFileIds = $request->input('removed_files', []);
                foreach ($removedFileIds as $fileId) {
                    $file = file_materi::find($fileId);
                    \Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
            }

            if ($request->hasFile('file_materi')) {
                $this->handleFileUploads($request->file('file_materi'), $id);
            }

            DB::commit();

            // Send notification to Whatsapp
            $siswaNomorWhatsApp = Siswa::whereHas('kelas', function ($query) use ($materi) {
                $query->whereHas('kelasMataPelajaran', function ($query) use ($materi) {
                    $query->where('id_kelas_mata_pelajaran', $materi->kelas_mata_pelajaran_id);
                });
            })->pluck('nomor_wa_siswa')->toArray();

            $kelas_mata_pelajaran = kelas_mata_pelajaran::with('kelas')->findOrFail($request->id_kelas_mata_pelajaran);
            try {
                NotifikasiMateri::dispatch($materi, $kelas_mata_pelajaran, $siswaNomorWhatsApp, 'update');
                return redirect()->route('guru.dashboard.lms.materi')->with('success', 'Materi berhasil diubah dan notifikasi berhasil dikirim.');
            } catch (Exception $e) {
                return redirect()->route('guru.dashboard.lms.materi')->with('success', 'Materi berhasil diubah tetapi notifikasi gagal dikirim.');
                \Log::error('Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $materi = materi::findOrFail($id);
            if ($materi) {
                // delete file materi
                $fileMateri = file_materi::where('materi_id', $id)->get();
                if ($fileMateri) {
                    foreach ($fileMateri as $file) {
                        \Storage::disk('public')->delete($file->file_path);
                        $file->delete();
                    }
                }

                // delete notifikasi sistem
                notifikasi_sistem::where('materi_id', $id)->delete();

                // delete materi
                $materi->delete();
                DB::commit();
            }

            return redirect()->route('guru.dashboard.lms.materi')->with('success', 'Materi berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function handleFileUploads($files, $materi_id)
    {
        foreach ($files as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/file_materi', $fileName, 'public');
            $fileType = $file->getClientMimeType();

            file_materi::create(
                [
                    'materi_id' => $materi_id,
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_type' => $fileType,
                    'upload_at' => now(),
                    'status' => 1
                ]
            );
        }
    }
}
