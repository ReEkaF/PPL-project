<?php

namespace App\Http\Controllers\perpustakaan;

use App\Models\buku;
use App\Models\transaksi_peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;  // Pastikan Auth diimport

class RiwayatPengunjungController extends Controller
{
    public function transGuru(Request $request)
    {
        // Ambil data pengguna dari Auth guard
        $guru = Auth::guard('web-guru')->user();

        // Pastikan pengguna login
        if (!$guru) {
            return redirect()->route('login')->withErrors(['username' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        // Mengambil NIP dari guru yang sedang login
        $nip = $guru->nip;

        // Mendapatkan transaksi berdasarkan NIP guru yang login
        $query = transaksi_peminjaman::where('kode_peminjam', '=', $nip)
                          ->join('buku', 'buku.id_buku', '=', 'transaksi_peminjaman.id_buku');

        // Jika ada pencarian berdasarkan judul buku
        if ($request->has('search')) {
            $searchTerm = $request->get('search');
            $query->where('buku.judul_buku', 'like', "%$searchTerm%");
        }

        // Mengambil data transaksi yang telah difilter dan diurutkan
        $transaksis = $query->orderByRaw('status_pengembalian != 1 DESC')  // Transaksi dengan status != 1 di atas
                            ->orderBy('tgl_pengembalian', 'desc')  // Urutkan berdasarkan tanggal transaksi
                            ->get(['transaksi_peminjaman.*', 'buku.judul_buku']);

        return view('guru.perpustakaan.riwayat', compact('transaksis'));
    }


    
    public function transSiswa(Request $request)
    {
        // Ambil data pengguna dari Auth guard
        $siswa = Auth::guard('web-siswa')->user();

        // Pastikan pengguna login
        if (!$siswa) {
            return redirect()->route('login')->withErrors(['username' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        // Mengambil NIP dari siswa yang sedang login
        $nisn = $siswa->nisn;

        // Mendapatkan transaksi berdasarkan NIP siswa yang login
        $query = transaksi_peminjaman::where('kode_peminjam', '=', $nisn)
                          ->join('buku', 'buku.id_buku', '=', 'transaksi_peminjaman.id_buku');

        // Jika ada pencarian berdasarkan judul buku
        if ($request->has('search')) {
            $searchTerm = $request->get('search');
            $query->where('buku.judul_buku', 'like', "%$searchTerm%");
        }

        // Mengambil data transaksi yang telah difilter dan diurutkan
        $transaksis = $query->orderByRaw('status_pengembalian != 1 DESC')  // Transaksi dengan status != 1 di atas
                            ->orderBy('tgl_pengembalian', 'desc')  // Urutkan berdasarkan tanggal transaksi
                            ->get(['transaksi_peminjaman.*', 'buku.judul_buku']);

        return view('siswa.perpustakaan.riwayat', compact('transaksis'));
    }
}
