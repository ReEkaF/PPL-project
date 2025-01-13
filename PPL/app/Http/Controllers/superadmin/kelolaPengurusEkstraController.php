<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\PengurusEkstra;
use App\Models\Ekstrakurikuler;

class KelolaPengurusEkstraController extends Controller
{
    // Menampilkan data pengurus
    public function showDataPengurus()
    {
        // Mengambil data pengurus yang memiliki role sebagai pengurus
        $pengurusData = Siswa::where('role_siswa', 'pengurus')
                            ->with('pengurusEkstra') // Mengambil relasi pengurus ekstra
                            ->paginate(5);
                            
        // Debugging untuk melihat hasil query
        // dd($pengurusData); // Menampilkan isi variabel dan menghentikan eksekusi

        return view('superadmin.crud_pengurusEkstra.data_pengurus', compact('pengurusData')); // Ini tidak akan dieksekusi saat debugging
    }


    // Menambahkan data pengurus
    // Menampilkan halaman tambah pengurus
    public function createPengurus()
    {
        // Mengambil data siswa yang belum menjadi pengurus
        $siswa = Siswa::where('role_siswa', 'siswa')->get();

        // Mengambil data ekstrakurikuler
        $ekstrakurikuler = Ekstrakurikuler::all();

        return view('superadmin.crud_pengurusEkstra.tambah_pengurus', compact('siswa', 'ekstrakurikuler'));
    }

    // Menyimpan data pengurus
    public function storePengurus(Request $request, $id_siswa)
    {
        $request->validate([
            'ekstrakurikuler' => 'required|exists:ekstrakurikuler,id_ekstrakurikuler',
            'role_siswa' => 'required|string',
        ]);

        // Cek apakah siswa sudah menjadi pengurus di ekstrakurikuler yang sama
        $existingPengurus = PengurusEkstra::where('id_siswa', $id_siswa)
            ->where('id_ekstrakurikuler', $request->ekstrakurikuler)
            ->first();

        if ($existingPengurus) {
            return redirect()->back()->withErrors(['error' => 'Siswa ini sudah terdaftar di ekstrakurikuler tersebut.']);
        }

        // Tambahkan siswa ke dalam tabel pengurus_ekstra
        PengurusEkstra::create([
            'id_siswa' => $id_siswa,
            'id_ekstrakurikuler' => $request->ekstrakurikuler,
        ]);

        // Ubah role siswa menjadi 'pengurus'
        $siswa = Siswa::findOrFail($id_siswa);
        $siswa->role_siswa = $request->role_siswa;
        $siswa->save();
        return redirect()->route('superadmin.keloladatapengurus')->with('success', 'Pengurus berhasil ditambahkan!');
    }



    // Menghapus data pengurus
    public function pengurusDestroy($id_pengurus)
    {
        $pengurus = PengurusEkstra::findOrFail($id_pengurus);
        $pengurus->delete();
        return redirect()->route('superadmin.keloladatapengurus')->with('success', 'Data pengurus berhasil dihapus.');
    }

    // Update data pengurus
    public function pengurusUpdate(Request $request, $id_siswa)
    {
        $request->validate([
            'ekstrakurikuler' => 'required|exists:ekstrakurikuler,id_ekstrakurikuler', // Memastikan ekstrakurikuler ada
            'role_siswa' => 'required|string',
            'foto_siswa' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Max size 2MB
        ]);

        // Update data pengurus
        $pengurus = PengurusEkstra::where('id_siswa', $id_siswa)->firstOrFail();
        $pengurus->id_ekstrakurikuler = $request->ekstrakurikuler;
        $pengurus->save();

        // Update role siswa
        $siswa = Siswa::findOrFail($id_siswa);
        $siswa->role_siswa = $request->role_siswa;
        $siswa->save();

        return redirect()->route('superadmin.keloladatapengurus')->with('success', 'Data pengurus berhasil diperbarui.');
    }


    // Mencari pengurus
    public function searchPengurus(Request $request)
    {
        $query = $request->input('search');
        $pengurusData = Siswa::where('role_siswa', 'pengurus')
                             ->where('nama_siswa', 'LIKE', '%' . $query . '%')
                             ->paginate(5);

        return view('superadmin.crud_pengurusEkstra.data_pengurus', compact('pengurusData'));
    }
    public function editPengurus($id)
    {
        $pengurus = Siswa::where('id_siswa', $id)->firstOrFail();
        $ekstrakurikuler = Ekstrakurikuler::all();

        return view('superadmin.crud_pengurusEkstra.edit_pengurus', compact('pengurus', 'ekstrakurikuler'));
    }

    public function updatePengurus(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'role_siswa' => 'required|string',
            'ekstrakurikuler' => 'required|exists:ekstrakurikuler,id_ekstrakurikuler',
        ]);

        // Update data pengurus
        $pengurus = PengurusEkstra::where('id_siswa', $id)->firstOrFail();
        if ($pengurus) {
            // Jika data pengurus sudah ada, perbarui
            $pengurus->id_ekstrakurikuler = $request->ekstrakurikuler;
            $pengurus->save();
        } else {
            // Jika tidak ada, tambahkan data baru (opsional)
            PengurusEkstra::create([
                'id_siswa' => $id,
                'id_ekstrakurikuler' => $request->ekstrakurikuler,
            ]);
        }

        // Update data siswa
        $siswa = Siswa::findOrFail($id);
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->role_siswa = $request->role_siswa;
        $siswa->save();

        return redirect()->route('superadmin.keloladatapengurus')->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function deleteRole($id_siswa)
    {
        // Hapus data di tabel pengurus_ekstra berdasarkan id_siswa
        PengurusEkstra::where('id_siswa', $id_siswa)->delete();

        // Perbarui role siswa menjadi 'siswa'
        $siswa = Siswa::findOrFail($id_siswa);
        $siswa->role_siswa = 'siswa';
        $siswa->save();

        return redirect()->route('superadmin.keloladatapengurus')->with('success', 'Role pengurus berhasil dihapus.');
    }

        

}
