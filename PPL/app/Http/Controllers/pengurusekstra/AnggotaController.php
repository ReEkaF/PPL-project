<?php

namespace App\Http\Controllers\pengurusekstra;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\PengurusEkstra;
use App\Http\Controllers\Controller;
use App\Models\RegistrasiEkstrakurikuler;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $pengurusEkstra = PengurusEkstra::with('ekstrakurikuler', 'siswa')
            ->where('id_siswa', auth()->guard('web-siswa')->user()->id_siswa)
            ->first();

        if (!$pengurusEkstra) {
            return view('pengurus_ekstra.anggota.index', ['ekstrakurikuler' => 'Tidak Ada', 'loggedInUsername' => auth()->guard('web-siswa')->user()->nama_siswa, 'totalItems' => 0, 'members' => []]);
        }

        $siswa = RegistrasiEkstrakurikuler::with('siswa')
            ->where('id_ekstrakurikuler', $pengurusEkstra->id_ekstrakurikuler)
            ->get();

        $members = $siswa->map(function ($registrasi) {
            // Mengatur status dari registrasi pada objek siswa
            $registrasi->siswa->status = $registrasi->status;
            return $registrasi->siswa;
        });


        return view('pengurus_ekstra.anggota.index', [
            'ekstrakurikuler' => $pengurusEkstra->ekstrakurikuler->nama_ekstrakurikuler,
            'members' => $members,
            'loggedInUsername' => $pengurusEkstra->siswa->nama_siswa,
            'totalItems' => $members->count()
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        // Mendapatkan informasi ekstra untuk siswa saat ini
        $pengurusEkstra = PengurusEkstra::where('id_siswa', auth()->guard('web-siswa')->user()->id_siswa)->first();

        if (!$pengurusEkstra) {
            return redirect()->route('pengurus_ekstra.anggota')->withErrors('Ekstrakurikuler tidak ditemukan untuk siswa ini.');
        }

        // Cari registrasi terkait dalam `RegistrasiEkstrakurikuler` untuk siswa dan ekstrakurikuler tertentu
        $registration = RegistrasiEkstrakurikuler::where('id_siswa', $id)
            ->where('id_ekstrakurikuler', $pengurusEkstra->id_ekstrakurikuler)
            ->firstOrFail();

        // Memperbarui status dari permintaan
        $registration->status = $request->input('status');
        $registration->save();

        return redirect()->route('pengurus_ekstra.anggota')->with('success', 'Status berhasil diperbarui.');
    }
}
