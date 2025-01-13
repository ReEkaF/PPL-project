<?php

namespace App\Http\Controllers\staffperpus;

use Carbon\Carbon;
use App\Models\Buku;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\transaksi_peminjaman;

class LaporanController extends Controller
{
    protected $staff_account;
    
    public function __construct()
    {
        $this->staff_account = DB::table('staffperpus')
            ->where('username', '=', session('username'))
            ->first();

        view()->composer('*', function ($view) {
            $view->with('staff_account',  $this->staff_account);
        });
    }

    public function bukumasuk(Request $request)
{
    // Ambil filter rentang bulan dan tahun dari request
    $bulan_awal = (int) $request->input('bulan_awal', 1); // Pastikan ini angka
    $tahun_awal = (int) $request->input('tahun_awal', Carbon::now()->year); // Pastikan ini angka

    $bulan_akhir = (int) $request->input('bulan_akhir', 12); // Pastikan ini angka
    $tahun_akhir = (int) $request->input('tahun_akhir', Carbon::now()->year); // Pastikan ini angka

    // Ambil data buku yang masuk selama rentang bulan dan tahun yang dipilih
    $buku_masuk = Buku::whereBetween('tgl_ditambahkan', [
                            Carbon::create($tahun_awal, $bulan_awal, 1),
                            Carbon::create($tahun_akhir, $bulan_akhir, 1)->endOfMonth()
                        ])
                        ->orderBy('tgl_ditambahkan', 'asc') // Mengurutkan berdasarkan tgl_ditambahkan (ascending)
                            ->paginate(10) // Tambahkan pagination
                            ->withQueryString(); // Pertahankan query string pada pagination


    // Hitung jumlah buku yang masuk dalam rentang waktu yang dipilih
    $jumlah_buku = Buku::whereBetween('tgl_ditambahkan', [
                            Carbon::create($tahun_awal, $bulan_awal, 1),
                            Carbon::create($tahun_akhir, $bulan_akhir, 1)->endOfMonth()
                        ])
                        ->count();

    return view('staff_perpus.laporan.laporanbukumasuk', [
        'buku_masuk' => $buku_masuk,
        'jumlah_buku' => $jumlah_buku,
        'bulan_awal' => $bulan_awal,
        'tahun_awal' => $tahun_awal,
        'bulan_akhir' => $bulan_akhir,
        'tahun_akhir' => $tahun_akhir
    ]);
}

public function bukuhilang(Request $request)
{
    // Ambil filter rentang bulan dan tahun dari request
    $bulan_awal = (int) $request->input('bulan_awal', 1); // Pastikan ini angka
    $tahun_awal = (int) $request->input('tahun_awal', Carbon::now()->year); // Pastikan ini angka

    $bulan_akhir = (int) $request->input('bulan_akhir', 12); // Pastikan ini angka
    $tahun_akhir = (int) $request->input('tahun_akhir', Carbon::now()->year); // Pastikan ini angka

    // Ambil data buku yang hilang (status_pengembalian = 2) selama rentang bulan dan tahun yang dipilih
    $buku_hilang = transaksi_peminjaman::with('buku') // Memuat data buku terkait
                        ->where('status_pengembalian', 2) // Status pengembalian 2 (buku hilang)
                        ->whereBetween('tgl_pengembalian', [
                            Carbon::create($tahun_awal, $bulan_awal, 1),
                            Carbon::create($tahun_akhir, $bulan_akhir, 1)->endOfMonth()
                            
                        ])
                        ->orderBy('tgl_pengembalian', 'asc') // Mengurutkan berdasarkan tgl_ditambahkan (ascending)
                        ->paginate(10) // Tambahkan pagination
                        ->withQueryString(); // Pertahankan query string pada pagination
                    
                        // ->get();

    // Hitung jumlah buku hilang
    $jumlah_buku_hilang = transaksi_peminjaman::where('status_pengembalian', 2) // Status pengembalian 2 (buku hilang)
        ->whereBetween('tgl_pengembalian', [
            Carbon::create($tahun_awal, $bulan_awal, 1),
            Carbon::create($tahun_akhir, $bulan_akhir, 1)->endOfMonth()
        ])
        ->count(); // Menghitung total buku hilang tanpa pagination


    return view('staff_perpus.laporan.laporanbukuhilang', [
        'buku_hilang' => $buku_hilang,
        'jumlah_buku_hilang' => $jumlah_buku_hilang,
        'bulan_awal' => $bulan_awal,
        'tahun_awal' => $tahun_awal,
        'bulan_akhir' => $bulan_akhir,
        'tahun_akhir' => $tahun_akhir
    ]);
}

public function transaksibuku(Request $request)
{
    // Ambil filter rentang bulan dan tahun dari request
    $bulan_awal = (int) $request->input('bulan_awal', 1); // Pastikan ini angka
    $tahun_awal = (int) $request->input('tahun_awal', Carbon::now()->year); // Pastikan ini angka

    $bulan_akhir = (int) $request->input('bulan_akhir', 12); // Pastikan ini angka
    $tahun_akhir = (int) $request->input('tahun_akhir', Carbon::now()->year); // Pastikan ini angka

    // Ambil semua transaksi peminjaman yang terjadi dalam rentang waktu yang dipilih
    $transaksi_buku = transaksi_peminjaman::with('buku') // Memuat data buku terkait
    ->whereBetween('tgl_awal_peminjaman', [
        Carbon::create($tahun_awal, $bulan_awal, 1),
        Carbon::create($tahun_akhir, $bulan_akhir, 1)->endOfMonth()
    ])
    ->orderBy('tgl_awal_peminjaman', 'asc') // Mengurutkan berdasarkan tgl_awal_peminjaman
    ->paginate(10) // Pagination
    ->withQueryString(); // Pertahankan query string pada pagination

    // Hitung jumlah transaksi tanpa pagination
    $jumlah_transaksi = transaksi_peminjaman::whereBetween('tgl_awal_peminjaman', [
            Carbon::create($tahun_awal, $bulan_awal, 1),
            Carbon::create($tahun_akhir, $bulan_akhir, 1)->endOfMonth()
        ])
        ->count(); // Menghitung total transaksi tanpa pagination


    return view('staff_perpus.laporan.laporantransaksi', [
        'transaksi_buku' => $transaksi_buku,
        'jumlah_transaksi' => $jumlah_transaksi,
        'bulan_awal' => $bulan_awal,
        'tahun_awal' => $tahun_awal,
        'bulan_akhir' => $bulan_akhir,
        'tahun_akhir' => $tahun_akhir
    ]);
}


}
