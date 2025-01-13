<?php

namespace App\Http\Controllers\pengurusekstra;

use App\Models\KelasSiswa;
use App\Models\tahun_ajaran;
use Illuminate\Http\Request;
use App\Models\PengurusEkstra;
use App\Models\Ekstrakurikuler;
use App\Http\Controllers\Controller;
use App\Models\PenilaianEkstrakurikuler;
use App\Models\RegistrasiEkstrakurikuler;
use App\Models\LaporanPenilaianEkstrakurikuler;

class PenilaianEkstraPengurusController extends Controller
{
    public function index()
    {
        $tahun_ajaran = tahun_ajaran::get();
        $tahun_ajaran_aktif = tahun_ajaran::where('aktif', '1')->firstOrFail();

        try{
        // Ambil data pengurus dari tabel pengurus_ekstra
        $pengurusEkstra = PengurusEkstra::with('ekstrakurikuler')
            ->where('id_siswa', auth()->guard('web-siswa')->user()->id_siswa)
            ->firstOrFail();
        } catch (\Exception) {
            return view('pengurus_ekstra.laporan_nilai.index', ['laporan_anggota' => [], 'nama_ekstra' => 'Tidak Ada Ekstrakurikuler', 'penilaian', 'tahun_ajaran_aktif', 'id_ekstra', 'tahun_ajaran']);
        }

        $id_ekstra = $pengurusEkstra->id_ekstrakurikuler;
        $nama_ekstra = $pengurusEkstra->ekstrakurikuler->nama_ekstrakurikuler;

        // Ambil data anggota ekstrakurikuler
        $anggota = RegistrasiEkstrakurikuler::with('siswa')
            ->where('status', 'diterima')
            ->where('id_ekstrakurikuler', $id_ekstra)
            ->get();

        $anggota_aktif = [];
        foreach ($anggota as $a) {
            $siswa = KelasSiswa::with(['siswa', 'tahunajaran'])
                ->where('id_siswa', $a->id_siswa)
                ->whereHas('tahunajaran', function ($query) use ($tahun_ajaran_aktif) {
                    $query->where('tahun_ajaran', $tahun_ajaran_aktif->id_tahun_ajaran);
                })
                ->first();

            if ($siswa) {
                $anggota_aktif[] = $siswa;
            }
        }

        // Ambil data laporan dan penilaian
        $laporan = LaporanPenilaianEkstrakurikuler::where('id_ekstrakurikuler', $id_ekstra)->get();
        $penilaian = PenilaianEkstrakurikuler::whereIn('id_siswa', collect($anggota_aktif)->pluck('id_siswa'))->get();

        // Mapping data laporan dan penilaian ke anggota aktif
        $laporan_anggota = collect($anggota_aktif)->map(function ($item) use ($laporan, $penilaian) {
            $laporanItem = $laporan->firstWhere('id_siswa', $item->id_siswa);
            $penilaianItem = $penilaian->firstWhere('id_siswa', $item->id_siswa);
            $item->laporan = $laporanItem;
            $item->penilaian = $penilaianItem;
            return $item;
        });

        return view('pengurus_ekstra.laporan_nilai.index', compact('laporan_anggota', 'nama_ekstra', 'penilaian', 'tahun_ajaran_aktif', 'id_ekstra', 'tahun_ajaran'));
    }

    public function storeOrUpdate(Request $request, $id_siswa)
    {
        $request->validate([
            'isi_laporan' => 'required',
        ]);
        $id_ekstra = PengurusEkstra::with('ekstrakurikuler')->where('id_siswa', auth()->guard('web-siswa')->user()->id_siswa)->firstOrFail()->id_ekstrakurikuler;

        $laporan = LaporanPenilaianEkstrakurikuler::where('id_siswa', $id_siswa)->first();
        // Jika data laporan sudah ada, maka akan diupdate
        if($laporan)
        {
            $laporan->update([
                'isi_laporan' => $request->isi_laporan,
            ]);
        }

        // Jika data laporan belum ada, maka akan disimpan
        else
        {
            $laporan = LaporanPenilaianEkstrakurikuler::create([
                'id_siswa' => $id_siswa,
                'id_ekstrakurikuler' => $id_ekstra,
                'isi_laporan' => $request->isi_laporan,
            ]);
        }

        return redirect()->back()->with('success', 'Isi laporan berhasil diperbarui.');
    }
}
