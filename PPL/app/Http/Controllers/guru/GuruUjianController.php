<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\jawaban_ujian;
use App\Models\soal_ujian;
use App\Models\ujian;
use App\Models\pengumpulan_ujian;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SoalUjianImport;
use App\Models\Siswa;
use App\Models\topik;
use App\Models\kelas_mata_pelajaran;
use Illuminate\Support\Facades\Auth;

class GuruUjianController extends Controller
{
    //CRUD JAWABAN========================================================================================================
    public function showJawabanUjian()
    {
        $jawabanUjian = jawaban_ujian::all();
        $soalUjian = soal_ujian::all();
        return view("guru.ujian.jawaban_ujian", compact("jawabanUjian", "soalUjian"));
    }

    // public function editJawabanUjian($id)
    // {
    //     $jawaban = jawaban_ujian::findOrFail($id);
    //     return view('guru.ujian.jawaban_ujian_edit', compact('jawaban'));
    // }

    public function editJawabanUjian($id)
    {
        $jawaban = jawaban_ujian::findOrFail($id);

        $soalUjian = soal_ujian::all();

        return view('guru.ujian.jawaban_ujian_edit', compact('jawaban', 'soalUjian'));
    }

    public function destroyJawabanUjian($id)
    {
        $jawaban = jawaban_ujian::findOrFail($id);
        $jawaban->delete();
        return redirect()->route('guru.dashboard.ujian.jawaban_ujian')->with('success', 'Jawaban ujian berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $jawaban = jawaban_ujian::findOrFail($id);
        $soalUjian = soal_ujian::findOrFail($id);

        $jawaban->update($request->all());
        $soalUjian->update($request->all());

        return redirect()->route('guru.dashboard.ujian.jawaban_ujian')->with('success', 'Jawaban ujian berhasil diperbarui.');
    }

    //CRUD SOAL=================================================================================================================
    public function storeSoal(Request $request, $ujian_id)
    {
        $ujian = Ujian::findOrFail($ujian_id);

        return view('guru.ujian.create_soal', compact('ujian_id', 'ujian'));
    }

    public function createUjian()
    {
        // dd(Auth::getDefaultDriver());
        // dd(Auth::user());
        // if (Auth::check()) {
        //     // Pengguna sudah login
        //     $guruId = Auth::user()->id_guru;
        // } else {
        //     // Pengguna belum login
        //     return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        // }

        // $guruId = Auth::guard('web')->user()->id_guru;

        // $kelasMataPelajaran = kelas_mata_pelajaran::where('guru_id', $guruId)->with('kelas', 'mataPelajaran')->get();
        $soalUjian = soal_ujian::all();
        $topik = topik::all();
        $kelasMataPelajaran = kelas_mata_pelajaran::with(['kelas', 'mataPelajaran'])->get();

        return view("guru.ujian.create_ujian", compact("soalUjian", "topik", "kelasMataPelajaran"));
    }

    public function indexUjian()
    {
        $ujian = Ujian::paginate(10);

        return view('guru.ujian.view_ujian', compact('ujian'));
    }

    public function ujianEdit(Request $request, $id) {}

    public function ujianDelete() {}

    public function updateUjian(Request $request, Ujian $ujian) {}

    public function storeData(Request $request)
    {
        $request->validate([
            'judul'                => 'required|string|max:255',
            'deskripsi'            => 'required|string',
            'jenis_ujian'          => 'required|string',
            'topik_id'             => 'required|string',
            'kelas_mata_pelajaran_id' => 'required|string',
            'tanggal_dibuat'       => 'required|date',
        ]);
        // dd($request->all());
        Ujian::create([
            'judul'                => $request->judul,
            'deskripsi'            => $request->deskripsi,
            'jenis_ujian'          => $request->jenis_ujian,
            'topik_id'             => $request->topik_id,
            'kelas_mata_pelajaran_id' => $request->kelas_mata_pelajaran_id,
            'tanggal_dibuat'       => $request->tanggal_dibuat,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        return redirect()->route('ujian.show');
    }

    public function createSoal($ujian_id)
    {
        // dd($ujian_id);
        return view('guru.ujian.create_soal', compact('ujian_id'));
    }
    public function showSoal($id)
    {
        // Cek apakah ujian dengan id ini ada
        $ujian = Ujian::findOrFail($id);

        // Ambil semua soal yang terkait dengan id ujian
        $soalUjian = Soal_ujian::where('ujian_id', $id)->get();

        // Return view dengan data soal ujian
        return view('guru.ujian.show_soal', compact('soalUjian', 'ujian'));
    }

    public function importSoal(Request $request, $ujian_id)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new SoalUjianImport($ujian_id), $request->file('file'));

        return redirect()->route('ujian.show')->with('success', 'Soal ujian berhasil diimpor!');
    }

    public function soalEdit($id)
    {
        $soal = soal_ujian::findOrFail($id); // Find soal by primary key
        $jawaban = soal_ujian::all();

        return view('guru.ujian.soal_edit', compact('soal', 'jawaban'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function soalUpdate(Request $request, $id)
    {
        $request->validate([
            'judul_ujian' => 'required|string|max:255',
            'teks_soal' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'kunci_jawaban' => 'required|string',
        ]);


        $soal = soal_ujian::findOrFail($id);
        $soal->update($request->all());

        return redirect()->route('ujian.show')->with('success', 'Soal Ujian berhasil diperbarui.');
    }


    public function destroySoal($id)
    {
        $soal = soal_ujian::findOrFail($id);
        $soal->delete();

        return redirect()->route('guru.dashboard.ujian.soal_ujian')
            ->with('success', 'Soal ujian berhasil dihapus.');
    }
    public function pengumpulan()
    {
        return view("guru.ujian.pengumpulan");
    }
    //CRUD PENGUMPULAN UJIAN===============================================================================================
    public function index()
    {
        $pengumpulanUjian = pengumpulan_ujian::with(['siswa', 'ujian'])->get();
        // $soalUjian = soal_ujian::with('ujian')->get();
        // $namaSiswa = Siswa::select('nama_siswa')->get();

        return view("guru.ujian.pengumpulan_ujian", compact("pengumpulanUjian"));
    }

    public function destroy($id)
    {
        // Hapus semua jawaban ujian yang terkait dengan pengumpulan ujian
        jawaban_ujian::where('pengumpulan_ujian_id', $id)->delete();

        // Hapus data pengumpulan ujian
        $pengumpulanUjian = pengumpulan_ujian::findOrFail($id);
        $pengumpulanUjian->delete();
        // $pengumpulanUjian = pengumpulan_ujian::findOrFail($id);
        // $pengumpulanUjian->delete();

        return redirect()->route('guru.dashboard.ujian.pengumpulan')->with('success', 'Data berhasil dihapus.');
    }
}
