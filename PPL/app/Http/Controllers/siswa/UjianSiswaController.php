<?php

namespace App\Http\Controllers\siswa;
use App\Models\Ujian;
use App\Models\soal_ujian;
use App\Models\pengumpulan_ujian;
use App\Models\jawaban_ujian;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class UjianSiswaController extends Controller
{
    /**
     * Halaman Daftar Ujian
     */
    public function index()
    {
        $ujians = Ujian::all();
        return view('siswa.ujian.index', compact('ujians'));
    }

    /**
     * Halaman Mulai Ujian
     */
    public function start($id)
    {
        $ujian = Ujian::with(['soalUjian' => function($query) use ($id) {
            $query->where('ujian_id', $id);
        }])->findOrFail($id);

        // Set waktu durasi ujian (contoh: 30 menit)
        $durasi = 60; // dalam menit
        $endTime = now()->addMinutes($durasi);

        // Simpan waktu selesai ujian di session
        Session::put('ujian_end_time', $endTime);

        return view('siswa.ujian.start', compact('ujian', 'endTime'));
    }

    /**
     * Submit Ujian
     */
    public function submit(Request $request, $idUjian)
    {
        // Ambil ID siswa yang sedang login
        $idSiswa = Auth::guard('web-siswa')->user()->id_siswa;

        // Inisialisasi variabel nilai
        $nilai = 0;

        // Simpan data pengumpulan ujian
        $pengumpulanUjian = Pengumpulan_ujian::create([
            'siswa_id' => $idSiswa,
            'ujian_id' => $idUjian,
            'tanggal_pengumpulan' => now(),
            'nilai' => 0, // Sementara diisi 0, akan diperbarui setelah perhitungan nilai
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Iterasi melalui jawaban yang dikirimkan
        foreach ($request->except('_token') as $key => $value) {
            if (str_starts_with($key, 'jawaban_')) {
                // Ambil ID soal dari nama input
                $idSoal = str_replace('jawaban_', '', $key);

                // Cari soal berdasarkan ID soal ujian
                $soal = Soal_ujian::findOrFail($idSoal);

                // Cek apakah jawaban yang dipilih benar
                if (trim(strtolower($value)) === trim(strtolower($soal->kunci_jawaban))) {
                    $nilai += 5; // Tambahkan nilai
                }

                // Simpan jawaban ke tabel jawaban ujian
                jawaban_ujian::create([
                    'pengumpulan_ujian_id' => $pengumpulanUjian->id_pengumpulan_ujian,
                    'soal_id' => $idSoal,
                    'jawaban_dipilih' => $value,
                ]);
            }
        }

        // Perbarui nilai total di pengumpulan ujian
        $pengumpulanUjian->update([
            'nilai' => $nilai,
        ]);

        return view('siswa.ujian.end', [
            'ujian' => $pengumpulanUjian->ujian,
            'jumlahSoal' => $pengumpulanUjian->ujian->soalUjian->count(),
            'jawabanBenar' => $nilai / 5, // Asumsi nilai per soal = 5
            'nilai' => $nilai,
        ]);
        // Redirect dengan pesan sukses
        // return redirect()->route('siswa.dashboard')->with('success', 'Ujian berhasil dikumpulkan!');
    }


}
