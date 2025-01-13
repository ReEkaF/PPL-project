<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Support\Str;

class PrestasiController extends Controller
{
    // Menampilkan form tambah prestasi
    public function create()
    {
        $siswa = Siswa::all();
        return view("staff_akademik.prestasiSiswa.create", [
            'siswa' => $siswa
        ]);
    }

    // Menyimpan data prestasi
    public function store(Request $request)
    {
        
        $request->validate([
            'siswa_id' => 'required|string|max:36|exists:siswa,id_siswa',
            'nama_prestasi' => 'required|string|max:255',
            'bukti_prestasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'deskripsi_prestasi' => 'required|string',
        ]);

        $buktiPrestasi = null;
        if ($request->hasFile('bukti_prestasi')) {
            $buktiPrestasi = $request->file('bukti_prestasi')->store('uploads/prestasi', 'public');
        }
        Prestasi::create([
            'id_prestasi' => Str::uuid(),
            'siswa_id' => $request->siswa_id,
            'nama_prestasi' => $request->nama_prestasi,
            'bukti_prestasi' => $buktiPrestasi,
            'deskripsi_prestasi' => $request->deskripsi_prestasi,
            'status_prestasi' => 1, // Status 'Terverifikasi'
        ]);

        return redirect()->route('prestasi.index')->with('success', 'Data prestasi berhasil ditambahkan!');
    }

    // Menampilkan daftar prestasi dengan pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query untuk mendapatkan data prestasi, dengan pencarian jika ada
        $prestasi = Prestasi::with('siswa')
            ->when($search, function ($query, $search) {
                return $query->where('nama_prestasi', 'like', '%' . $search . '%')
                             ->orWhere('deskripsi_prestasi', 'like', '%' . $search . '%');
            })
            ->paginate(3); // Hasil dipaginasi, 10 per halaman

        return view('staff_akademik.prestasiSiswa.index', compact('prestasi'));
    }


    // Menampilkan detail prestasi
    public function show($id)
    {
        $prestasi = Prestasi::where('id_prestasi', $id)->first();
        return view('staff_akademik.prestasiSiswa.show', compact('prestasi'));
    }

    // Mengupdate data prestasi
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'deskripsi_prestasi' => 'required|string',
        ]);

        $prestasi = Prestasi::findOrFail($id);
        $prestasi->update($request->only('nama_prestasi', 'deskripsi_prestasi'));

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil diupdate.');
    }

    // Menghapus data prestasi
    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->delete();

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }

    // Menampilkan daftar pengajuan prestasi
    // public function pengajuan()
    // {
    //     $pengajuan = Prestasi::with('siswa')->where('status_prestasi', 0)->get(); // Mengambil yang belum diverifikasi
    //     return view("staff_akademik.prestasiSiswa.pengajuan", compact('pengajuan'));
    // }
    public function pengajuan(Request $request)
    {
        $search = $request->input('search');
    
        $pengajuan = Prestasi::with('siswa')
            ->where('status_prestasi', 0) // Mengambil prestasi yang belum diverifikasi
            ->when($search, function ($query, $search) {
                return $query->where('nama_prestasi', 'like', '%' . $search . '%')
                             ->orWhere('deskripsi_prestasi', 'like', '%' . $search . '%');
            })
            ->paginate(3); // Paginasi, 3 data per halaman
    
        return view("staff_akademik.prestasiSiswa.pengajuan", compact('pengajuan'));
    }
    
    // Menyetujui prestasi
    public function setujui($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->status_prestasi = 1; // Setujui
        $prestasi->save();

        return redirect()->route('prestasi.pengajuan')->with('success', 'Prestasi berhasil disetujui.');
    }

    // Menolak prestasi
    public function tolak($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->delete();

        return redirect()->route('prestasi.pengajuan')->with('error', 'Prestasi ditolak.');
    }
}