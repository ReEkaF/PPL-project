<?php

namespace App\Http\Controllers\pembinaekstra;

use App\Models\KelasSiswa;
use App\Models\tahun_ajaran;
use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use App\Http\Controllers\Controller;
use App\Models\PenilaianEkstrakurikuler;
use App\Models\RegistrasiEkstrakurikuler;
use App\Models\LaporanPenilaianEkstrakurikuler;

class PenilaianEkstraController extends Controller
{
    public function index()
    {
        $tahun_ajaran = tahun_ajaran::get();
        $tahun_ajaran_aktif = tahun_ajaran::where('aktif', '1')->firstOrFail();

        try{
            $ekstra = Ekstrakurikuler::where('guru_id', auth()->guard('web-guru')->user()->id_guru)->firstOrFail();
            $nama_ekstra = $ekstra->nama_ekstrakurikuler;
            $id_ekstra = $ekstra->id_ekstrakurikuler;
            $anggota = RegistrasiEkstrakurikuler::with('siswa')->where('status', 'diterima')->where('id_ekstrakurikuler', $id_ekstra)->get(); //array
            $anggota_aktif = [];

            foreach ($anggota as $a) {
                $siswa = KelasSiswa::with(['siswa', 'tahunajaran'])->where('id_siswa', $a->id_siswa)->whereHas('tahunajaran', function ($query) use ($tahun_ajaran_aktif) {
                    $query->where('tahun_ajaran', $tahun_ajaran_aktif->id_tahun_ajaran);
                })
                    ->firstOrFail();

                array_push($anggota_aktif, $siswa);
            }

            $laporan = LaporanPenilaianEkstrakurikuler::with('siswa')->where('id_ekstrakurikuler', $id_ekstra)->get();
            $penilaian = PenilaianEkstrakurikuler::whereIn('id_siswa', collect($anggota_aktif)->pluck('id_siswa'))->get();
            $laporan_anggota = collect($anggota_aktif)->map(function ($item) use ($laporan, $penilaian) {
                $laporanItem = $laporan->firstWhere('id_siswa', $item->id_siswa);
                $penilaianItem = $penilaian->firstWhere('id_siswa', $item->id_siswa);
                $item->laporan = $laporanItem;
                $item->penilaian = $penilaianItem;
                return $item;
            });

            // dd($laporan_anggota->get(1)->laporan->id_laporan);
            return view('pembina_ekstra.penilaian.index', compact('laporan_anggota', 'nama_ekstra', 'penilaian', 'tahun_ajaran_aktif', 'id_ekstra', 'tahun_ajaran'));

        } catch (\Exception) {
            return view('pembina_ekstra.penilaian.index', ['laporan_anggota' => [], 'nama_ekstra' => $nama_ekstra='Tidak Ada Ekstrakurikuler', 'penilaian' => $penilaian=[], 'tahun_ajaran_aktif' => $tahun_ajaran_aktif, 'id_ekstra' => $id_ekstra=null, 'tahun_ajaran' => $tahun_ajaran]);
        }
    }

    public function show($id)
    {
        $tahun_ajaran = tahun_ajaran::get();
        $tahun_ajaran_aktif = tahun_ajaran::where('id_tahun_ajaran', $id)->firstOrFail();
        try{
            $ekstra = Ekstrakurikuler::where('guru_id', auth()->guard('web-guru')->user()->id_guru)->firstOrFail();
            $nama_ekstra = $ekstra->nama_ekstrakurikuler;
            $id_ekstra = $ekstra->id_ekstrakurikuler;
            $anggota = RegistrasiEkstrakurikuler::with('siswa')->where('status', 'diterima')->where('id_ekstrakurikuler', $id_ekstra)->get(); //array
            $anggota_aktif = [];

            foreach ($anggota as $a) {
                $siswa = KelasSiswa::with(['siswa', 'tahunajaran'])->where('id_siswa', $a->id_siswa)->whereHas('tahunajaran', function ($query) use ($tahun_ajaran_aktif) {
                    $query->where('tahun_ajaran', $tahun_ajaran_aktif->id_tahun_ajaran);
                })
                    ->first();

                array_push($anggota_aktif, $siswa);
            }

            $laporan = LaporanPenilaianEkstrakurikuler::with('siswa')->where('id_ekstrakurikuler', $id_ekstra)->get();
            $penilaian = PenilaianEkstrakurikuler::whereIn('id_siswa', collect($anggota_aktif)->pluck('id_siswa'))->get();

            if ($siswa == null) {
                $laporan_anggota = [];
                return view('pembina_ekstra.penilaian.index', compact('nama_ekstra', 'penilaian', 'tahun_ajaran_aktif', 'id_ekstra', 'tahun_ajaran', 'laporan_anggota'));
            }

            $laporan_anggota = collect($anggota_aktif)->map(function ($item) use ($laporan, $penilaian) {
                $laporanItem = $laporan->firstWhere('id_siswa', $item->id_siswa);
                $penilaianItem = $penilaian->firstWhere('id_siswa', $item->id_siswa);
                $item->laporan = $laporanItem;
                $item->penilaian = $penilaianItem;
                return $item;
            });


            return view('pembina_ekstra.penilaian.index', compact('laporan_anggota', 'nama_ekstra', 'penilaian', 'tahun_ajaran_aktif', 'id_ekstra', 'tahun_ajaran'));
        } catch (\Exception) {
            return view('pembina_ekstra.penilaian.index', ['laporan_anggota' => [], 'nama_ekstra' => $nama_ekstra='Belum Ada Ekstrakurikuler', 'penilaian' => $penilaian=[], 'tahun_ajaran_aktif' => $tahun_ajaran_aktif, 'id_ekstra' => $id_ekstra=null, 'tahun_ajaran' => $tahun_ajaran]);
        }
    }



    public function storeOrUpdate(Request $request, $id_siswa)
    {
        $request->validate([
            'penilaian' => 'required',
            'id_siswa' => 'required',
            'id_laporan' => 'required',
        ]);

        $tahun_ajaran = tahun_ajaran::where('aktif', '1')->firstOrFail()->id_tahun_ajaran;
        $id_ekstra = Ekstrakurikuler::where('guru_id', auth()->guard('web-guru')->user()->id_guru)->firstOrFail()->id_ekstrakurikuler;

        // Mencari data penilaian ekstrakurikuler berdasarkan id_siswa dan id_tahun_ajaran
        $penilaian = PenilaianEkstrakurikuler::where('id_siswa', $id_siswa)->where('id_tahun_ajaran', $tahun_ajaran)->first();
        // Jika data penilaian sudah ada, maka akan diupdate
        if ($penilaian) {
            $penilaian->update([
                'penilaian' => $request->penilaian,
            ]);
        }

        // Jika data penilaian belum ada, maka akan disimpan
        else {

            $penilaian = PenilaianEkstrakurikuler::create([
                'id_siswa' => $id_siswa,
                'id_ekstrakurikuler' => $id_ekstra,
                'id_tahun_ajaran' => $tahun_ajaran,
                'id_laporan' => $request->id_laporan,
                'penilaian' => $request->penilaian,
            ]);
        }

        $tgl_penilaian = PenilaianEkstrakurikuler::where('id_siswa', $id_siswa)->where('id_tahun_ajaran', $tahun_ajaran)->first()->tgl_penilaian;
        return response()->json(['success' => true, 'tgl_penilaian' => $tgl_penilaian]);
    }
}
