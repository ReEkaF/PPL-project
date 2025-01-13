<?php

namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrestasiSiswaController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        // Query untuk mendapatkan data prestasi, dengan pencarian jika ada
        $prestasi = Prestasi::with('siswa')->where('siswa_id', auth()->guard('web-siswa')->user()->id_siswa)
            ->when($search, function ($query, $search) {
                return $query->where('nama_prestasi', 'like', '%' . $search . '%')
                             ->orWhere('deskripsi_prestasi', 'like', '%' . $search . '%');
            })
            ->paginate(3); // Hasil dipaginasi, 10 per halaman

        return view('siswa.prestasi.index', compact('prestasi'));
    }
    public function create()
    {
        return view('siswa.prestasi.create');
    }
    public function store(Request $request)
    {
        $request->validate([
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
            'siswa_id' => auth()->guard('web-siswa')->user()->id_siswa,
            'nama_prestasi' => $request->nama_prestasi,
            'bukti_prestasi' => $buktiPrestasi,
            'deskripsi_prestasi' => $request->deskripsi_prestasi,
            'status_prestasi' => 0, // Status 'Terverifikasi'
        ]);

        return redirect()->route('siswa.prestasi')->with('success', 'Data prestasi berhasil ditambahkan!');
    }
    public function show($id)
    {
        $prestasi = Prestasi::where('id_prestasi', $id)->first();
        return view('siswa.prestasi.show', compact('prestasi'));
    }
}
