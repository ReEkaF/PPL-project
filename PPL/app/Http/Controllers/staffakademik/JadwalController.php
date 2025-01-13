<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use App\Imports\JadwalImport; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalExport;   
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalController extends Controller
{
    /**
     * START JADWAL MANAGEMENT
     */

    //  read jadwal
    public function jadwalIndex(Request $request, $kelas_id = null)
    {
        $kelas = DB::table('kelas')
            ->orderByRaw('LENGTH(nama_kelas)')
            ->orderBy('nama_kelas')
            ->get();

        $hari = DB::table('hari')
            ->orderByRaw("FIELD(nama_hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get();

        // Query untuk data jadwal, dengan filter kelas_id jika ada
        $query = DB::table('kelas_mata_pelajaran')
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->join('tahun_ajaran', 'kelas_mata_pelajaran.tahun_ajaran_id', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select(
                'kelas_mata_pelajaran.id_kelas_mata_pelajaran',
                'kelas_mata_pelajaran.kelas_id',
                'kelas.nama_kelas',
                'kelas_mata_pelajaran.mata_pelajaran_id',
                'mata_pelajaran.nama_matpel',
                'kelas_mata_pelajaran.guru_id',
                'guru.nip',
                'guru.nama_guru',
                'kelas_mata_pelajaran.hari_id',
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'kelas_mata_pelajaran.tahun_ajaran_id',
                'tahun_ajaran.tahun_mulai',
                'tahun_ajaran.tahun_selesai',
                'tahun_ajaran.semester',
                'tahun_ajaran.aktif'
            )
            ->where('tahun_ajaran.aktif', 1) // Hanya tahun ajaran aktif
            ->orderBy('hari.id_hari') // Urutkan berdasarkan hari
            ->orderBy('kelas_mata_pelajaran.waktu_mulai'); // Urutkan berdasarkan waktu mulai

        // Jika kelas_id ada, tambahkan filter berdasarkan kelas
        if (isset($_GET['kelas_id']) && $_GET['kelas_id'] != '') {
            $filter = $_GET['kelas_id'];
            htmlspecialchars($filter);
            $kelas_id = $filter;
            $query->where('kelas_mata_pelajaran.kelas_id', $filter);
        }

        $data = $query->get();

        return view('staff_akademik.jadwalManagemen.index', compact('data', 'kelas', 'kelas_id'));
    }

    // tambah jadwal
    public function createJadwal()
    {
        $tahunAjaran = DB::table('tahun_ajaran')->where('aktif', 1)->first();
        $kelas = DB::table('kelas')
            ->orderByRaw('LENGTH(nama_kelas)')
            ->orderBy('nama_kelas')
            ->get();
        $hari = DB::table('hari')
            ->orderByRaw("FIELD(nama_hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get();
        $guruMataPelajaran = DB::table('guru_mata_pelajaran')
            ->join('guru', 'guru_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('mata_pelajaran', 'guru_mata_pelajaran.matpel_id', '=', 'mata_pelajaran.id_matpel')
            ->select('guru.id_guru', 'guru.nama_guru', 'mata_pelajaran.id_matpel', 'mata_pelajaran.nama_matpel')
            ->get();
        // dd($guruMataPelajaran);
        return view('staff_akademik.jadwalManagemen.create', compact('kelas', 'hari', 'guruMataPelajaran', 'tahunAjaran'));
    }

    public function storeJadwal(Request $request)
    {
        $jadwalData = $request->input('jadwal');
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        $kelasId = $request->input('kelas_id');
        $bentrok = []; // Array untuk menampung jadwal yang bentrok

        foreach ($jadwalData as $jadwal) {
            $guruid_matpelid = explode('_', $jadwal['guru_id']);
            $guruId = $guruid_matpelid[0];
            $mataPelajaranId = $guruid_matpelid[1];

            // Pisahkan waktu mulai dan selesai
            [$waktuMulai, $waktuSelesai] = explode('-', $jadwal['jam_pelajaran']);
            $hariId = $jadwal['hari_id'];

            // Pengecekan bentrok di semua kelas pada tahun ajaran aktif untuk guru
            $bentrokGuru = DB::table('kelas_mata_pelajaran')
                ->where('guru_id', $guruId)
                ->where('hari_id', $hariId)
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->where(function ($query) use ($waktuMulai, $waktuSelesai) {
                    $query->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                        ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                        ->orWhere(function ($query) use ($waktuMulai, $waktuSelesai) {
                            $query->where('waktu_mulai', '<=', $waktuMulai)
                                ->where('waktu_selesai', '>=', $waktuSelesai);
                        });
                })
                ->exists();

            // Pengecekan bentrok di kelas yang sama, hari yang sama, dan jam yang sama
            $bentrokKelas = DB::table('kelas_mata_pelajaran')
                ->where('kelas_id', $kelasId)
                ->where('hari_id', $hariId)
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->where(function ($query) use ($waktuMulai, $waktuSelesai) {
                    $query->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                        ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                        ->orWhere(function ($query) use ($waktuMulai, $waktuSelesai) {
                            $query->where('waktu_mulai', '<=', $waktuMulai)
                                ->where('waktu_selesai', '>=', $waktuSelesai);
                        });
                })
                ->exists();

            // Jika bentrok guru atau bentrok kelas, tambahkan ke array bentrok
            if ($bentrokGuru) {
                $bentrok[] = [
                    'tipe' => 'guru',
                    'nama_guru' => DB::table('guru')->where('id_guru', $guruId)->value('nama_guru'),
                    'nama_kelas' => DB::table('kelas')->where('id_kelas', $kelasId)->value('nama_kelas'),
                    'nama_hari' => DB::table('hari')->where('id_hari', $hariId)->value('nama_hari'),
                    'jam_pelajaran' => "{$waktuMulai}-{$waktuSelesai}"
                ];
            } elseif ($bentrokKelas) {
                $bentrok[] = [
                    'tipe' => 'kelas',
                    'nama_kelas' => DB::table('kelas')->where('id_kelas', $kelasId)->value('nama_kelas'),
                    'nama_hari' => DB::table('hari')->where('id_hari', $hariId)->value('nama_hari'),
                    'jam_pelajaran' => "{$waktuMulai}-{$waktuSelesai}"
                ];
            } else {
                // Jika tidak bentrok, lakukan insert
                DB::table('kelas_mata_pelajaran')->insert([
                    'id_kelas_mata_pelajaran' => (string) Str::uuid(),
                    'kelas_id' => $kelasId,
                    'hari_id' => $hariId,
                    'waktu_mulai' => $waktuMulai,
                    'waktu_selesai' => $waktuSelesai,
                    'guru_id' => $guruId,
                    'mata_pelajaran_id' => $mataPelajaranId,
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Jika ada bentrok, kembalikan ke halaman index dengan pesan error
        if (!empty($bentrok)) {
            return redirect()->route('staff_akademik.jadwal')->with('error', 'List jadwal bentrok')->with('bentrok', $bentrok);
        }

        return redirect()->route('staff_akademik.jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function editJadwal($id)
    {
        $jadwal = DB::table('kelas_mata_pelajaran')->where('id_kelas_mata_pelajaran', $id)->first();
        $kelas = DB::table('kelas')->orderByRaw('LENGTH(nama_kelas)')->orderBy('nama_kelas')->get();
        $hari = DB::table('hari')->orderByRaw("FIELD(nama_hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")->get();
        $guruMataPelajaran = DB::table('guru_mata_pelajaran')
            ->join('guru', 'guru_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('mata_pelajaran', 'guru_mata_pelajaran.matpel_id', '=', 'mata_pelajaran.id_matpel')
            ->select('guru.id_guru', 'guru.nama_guru', 'mata_pelajaran.id_matpel', 'mata_pelajaran.nama_matpel')
            ->get();

        return view('staff_akademik.jadwalManagemen.edit', compact('jadwal', 'kelas', 'hari', 'guruMataPelajaran'));
    }

    public function updateJadwal(Request $request, $id)
    {
        $jadwalData = $request->validate([
            'kelas_id' => 'required',
            'hari_id' => 'required',
            'jam_pelajaran' => 'required',
            'guruid_matpelid' => 'required',
        ]);

        // Ambil waktu mulai dan selesai dari input jam_pelajaran
        [$waktuMulai, $waktuSelesai] = explode('-', $request->input('jam_pelajaran'));
        $kelasId = $request->input('kelas_id');
        $hariId = $request->input('hari_id');
        $guruId = explode('_', $request->input('guruid_matpelid'))[0];

        // Ambil tahun ajaran yang aktif
        $tahunAjaranId = DB::table('tahun_ajaran')
            ->where('aktif', 1)
            ->value('id_tahun_ajaran');

        // Pastikan tahun ajaran aktif ditemukan
        if (!$tahunAjaranId) {
            return redirect()->route('staff_akademik.jadwal')
                ->with('error-update', 'Tahun ajaran aktif tidak ditemukan. Periksa kembali pengaturan tahun ajaran.');
        }

        // Cek bentrok jadwal di kelas yang sama, hari yang sama, jam yang sama, dan tahun ajaran yang aktif
        $bentrokKelas = DB::table('kelas_mata_pelajaran')
            ->where('kelas_id', $kelasId)
            ->where('hari_id', $hariId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('id_kelas_mata_pelajaran', '!=', $id)
            ->where(function ($query) use ($waktuMulai, $waktuSelesai) {
                $query->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                    ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                    ->orWhere(function ($query) use ($waktuMulai, $waktuSelesai) {
                        $query->where('waktu_mulai', '<=', $waktuMulai)
                            ->where('waktu_selesai', '>=', $waktuSelesai);
                    });
            })
            ->first();

        if ($bentrokKelas) {
            $namaKelas = DB::table('kelas')->where('id_kelas', $kelasId)->value('nama_kelas');
            $namaHari = DB::table('hari')->where('id_hari', $hariId)->value('nama_hari');
            $jamBentrok = "{$waktuMulai}-{$waktuSelesai}";

            $pesanError = "Jadwal kelas {$namaKelas} bentrok dengan pelajaran lain pada hari {$namaHari} pukul {$jamBentrok}. Periksa kembali jadwal.";

            return redirect()->route('staff_akademik.jadwal')
                ->with('error-update', $pesanError);
        }

        // Cek bentrok untuk guru di hari dan jam yang sama di tahun ajaran yang aktif, dalam semua kelas
        $bentrokGuru = DB::table('kelas_mata_pelajaran')
            ->where('guru_id', $guruId)
            ->where('hari_id', $hariId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('id_kelas_mata_pelajaran', '!=', $id)
            ->where(function ($query) use ($waktuMulai, $waktuSelesai) {
                $query->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                    ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                    ->orWhere(function ($query) use ($waktuMulai, $waktuSelesai) {
                        $query->where('waktu_mulai', '<=', $waktuMulai)
                            ->where('waktu_selesai', '>=', $waktuSelesai);
                    });
            })
            ->first();

        if ($bentrokGuru) {
            $namaGuru = DB::table('guru')->where('id_guru', $guruId)->value('nama_guru');
            $namaHari = DB::table('hari')->where('id_hari', $hariId)->value('nama_hari');
            $jamBentrok = "{$waktuMulai}-{$waktuSelesai}";

            $pesanError = "Guru {$namaGuru} sudah memiliki jadwal mengajar pada hari {$namaHari} pukul {$jamBentrok}. Periksa kembali jadwal.";

            return redirect()->route('staff_akademik.jadwal')
                ->with('error-update', $pesanError);
        }

        // Jika tidak ada bentrok, lakukan update jadwal
        $dataInput = [
            'kelas_id' => $kelasId,
            'hari_id' => $hariId,
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
            'guru_id' => $guruId,
        ];

        DB::table('kelas_mata_pelajaran')->where('id_kelas_mata_pelajaran', $id)->update($dataInput);

        return redirect()->route('staff_akademik.jadwal')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function deleteJadwal($id)
    {
        try {
            DB::table('kelas_mata_pelajaran')->where('id_kelas_mata_pelajaran', $id)->delete();
            return redirect()->route('staff_akademik.jadwal')->with('success', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('staff_akademik.jadwal')->with('error-delete', 'Jadwal tersebut sedang berlangsung.');
            
        }
    }

    public function importPage(){
        return  view('staff_akademik.jadwalManagemen.importExcel');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        try {
            Excel::import(new JadwalImport, $request->file('file'));
            return redirect()->route('staff_akademik.jadwal')->with('success', 'Jadwal berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('staff_akademik.jadwal')->with('error-excel', $e->getMessage());
        }
    }
    public function exportExcel(Request $request)
    {
        $kelas_id = $request->query('kelas_id');
        return Excel::download(new JadwalExport($kelas_id), 'jadwal.xlsx');
    }
    
    public function exportPdf(Request $request)
    {
        $kelas_id = $request->query('kelas_id');
    
        $query = DB::table('kelas_mata_pelajaran')
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->join('tahun_ajaran', 'kelas_mata_pelajaran.tahun_ajaran_id', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select(
                'kelas.nama_kelas',
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'mata_pelajaran.nama_matpel',
                'guru.nama_guru'
            )
            ->where('tahun_ajaran.aktif', 1)
            ->orderByRaw('LENGTH(kelas.nama_kelas)')
            ->orderBy('kelas.nama_kelas')
            ->orderByRaw("FIELD(hari.nama_hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('kelas_mata_pelajaran.waktu_mulai');
    
        if ($kelas_id) {
            $query->where('kelas_mata_pelajaran.kelas_id', $kelas_id);
        }
    
        $data = $query->get();
    
        $pdf = Pdf::loadView('staff_akademik.jadwalManagemen.pdf', compact('data'));
    
        return $pdf->download('jadwal.pdf');
    }

    /**
     * END JADWAL MANAGEMENT
     */
}
