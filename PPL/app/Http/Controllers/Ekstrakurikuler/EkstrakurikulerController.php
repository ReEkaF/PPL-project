<?php

namespace App\Http\Controllers\Ekstrakurikuler;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\ekstrakurikuler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Berkas; // Model untuk tabel berkas
use App\Models\PostingEkstrakurikuler;
use App\Models\RegistrasiEkstrakurikuler; // Model untuk tabel RegistrasiEkstrakurikuler
use Illuminate\Support\Facades\DB;
class EkstrakurikulerController extends Controller
{
    // Fungsi untuk menampilkan form registrasi
    public function showForm()
    {
        // Ambil data siswa yang sedang login
        $siswa = Auth::guard('web-siswa')->user();

        // Ambil semua data ekstrakurikuler
        $ekstrakurikulerList = Ekstrakurikuler::where('status', 'buka')->get();

        // Kirim data siswa dan ekstrakurikuler ke view
        return view('ekstrakurikuler.registrasi', compact('siswa', 'ekstrakurikulerList'));
    }

    // Fungsi untuk mengolah data yang dikirim dari form regis
    public function submitForm(Request $request)
    {
        // Validasi data
        $request->validate([
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'no_hp_orangtua' => 'nullable|string|max:15',
            'alasan_ekskul' => 'nullable|string',
            'pilih_ekskul' => 'nullable|array|max:3', // Maksimal 3 pilihan
            'surat_izin_orang_tua' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:25000',
            'surat_keterangan_dokter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:25000',
        ]);



        // Simpan berkas ke folder
        $fileSuratIzin = $request->file('surat_izin_orang_tua')->store('berkas/public');
        $fileSuratKeterangan = $request->file('surat_keterangan_dokter')->store('berkas/public');

        // Simpan data ke tabel RegistrasiEkstrakurikuler untuk setiap ekstrakurikuler yang dipilih
        foreach ($request->input('pilih_ekskul') as $idEkstrakurikuler) {
            echo($idEkstrakurikuler);
            RegistrasiEkstrakurikuler::create([
                'id_siswa' => Auth::guard('web-siswa')->user()->id_siswa,
                'id_ekstrakurikuler' => $idEkstrakurikuler,
                'riwayat_penyakit' => $request->input('riwayat_penyakit'),
                'alasan' => $request->input('alasan_ekskul'),
                'no_ortu' => $request->input('no_hp_orangtua'),
                'status' => 'menunggu', // Misalnya status awal adalah pending
                'tgl_registrasi' => now(),
            ]);
        }

        $id_regis =  RegistrasiEkstrakurikuler::first()->id_registrasi;
        // Simpan data ke tabel berkas
        Berkas::create([
            'id_registrasi' => $id_regis,
            'surat_izin_ortu' => $fileSuratIzin,
            'surat_riwayat_penyakit' => $fileSuratKeterangan,
        ]);

        return redirect()->route('ekstrakurikuler.registrasi')->with('success', 'Pendaftaran berhasil!');
    }

    public function dashboardEkstra()
    {
        $ekstrakurikulerList = Ekstrakurikuler::all();
        $postingan = PostingEkstrakurikuler::all();
        return view('ekstrakurikuler.dashboardEkstra', compact('ekstrakurikulerList', 'postingan'));
    }

    public function show($id)
    {
        // Ambil data ekstrakurikuler berdasarkan ID
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);

        $prestasiList = DB::table('prestasi_ektrakurikuler')
            ->where('id_ekstrakurikuler', $id)
            ->get();
        // Kirim data ke view
        return view('ekstrakurikuler.detail', compact('ekstrakurikuler', 'prestasiList'));
    }


}
?>
