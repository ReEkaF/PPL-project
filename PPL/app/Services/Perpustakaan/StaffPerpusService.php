<?php

namespace App\Services\Perpustakaan;

use App\Models\buku;
use App\Repositories\Contracts\Perpustakaan\BukuRepositoryInterface;
use App\Repositories\Contracts\Perpustakaan\KategoriBukuRepositoryInterface;
use App\Repositories\Contracts\Perpustakaan\TransaksiPeminjamanRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StaffPerpusService
{
    protected BukuRepositoryInterface $bukuRepo;

    protected KategoriBukuRepositoryInterface $kategoriRepo;

    protected TransaksiPeminjamanRepositoryInterface $transaksiRepo;

    public function __construct(
        BukuRepositoryInterface $bukuRepo,
        KategoriBukuRepositoryInterface $kategoriRepo,
        TransaksiPeminjamanRepositoryInterface $transaksiRepo
    ) {
        $this->bukuRepo = $bukuRepo;
        $this->kategoriRepo = $kategoriRepo;
        $this->transaksiRepo = $transaksiRepo;
    }

    public function getDashboardData(): array
    {
        // 1. Ambil 7 transaksi terbaru dengan join lengkap
        $transaksi = DB::table('transaksi_peminjaman')
            ->join('buku', 'transaksi_peminjaman.id_buku', '=', 'buku.id_buku')
            ->join('kategori_buku', 'buku.id_kategori_buku', '=', 'kategori_buku.id_kategori_buku')
            ->join('jenis_buku', 'buku.id_jenis_buku', '=', 'jenis_buku.id_jenis_buku')
            ->leftJoin('guru', 'guru.nip', '=', 'transaksi_peminjaman.kode_peminjam')
            ->leftJoin('siswa', 'siswa.nisn', '=', 'transaksi_peminjaman.kode_peminjam')
            ->select(
                'transaksi_peminjaman.*',
                'buku.judul_buku',
                'kategori_buku.nama_kategori',
                'jenis_buku.nama_jenis_buku',
                'guru.nama_guru',
                'siswa.nama_siswa'
            )
            ->orderBy('tgl_awal_peminjaman', 'desc')
            ->limit(7)
            ->get();

        // 2. Transaksi 7 hari terakhir untuk grafik tren
        $sevenDaysAgo = Carbon::now()->subDays(7)->toDateString();
        $transactionsevendays = DB::table('transaksi_peminjaman')
            ->join('buku', 'transaksi_peminjaman.id_buku', '=', 'buku.id_buku')
            ->where('transaksi_peminjaman.tgl_awal_peminjaman', '>=', $sevenDaysAgo)
            ->orderBy('transaksi_peminjaman.tgl_awal_peminjaman', 'asc')
            ->get();

        // 3. Agregasi data buku & peminjaman (menggantikan kueri unbounded select * yang memboroskan RAM)
        $borrowCount = DB::table('transaksi_peminjaman')->where('status_pengembalian', 0)->count();
        $backCount = DB::table('transaksi_peminjaman')->where('status_pengembalian', 1)->count();
        $lostCount = DB::table('transaksi_peminjaman')->where('status_pengembalian', 2)->count();
        $totalBookStock = (int) DB::table('buku')->sum('stok_buku');

        // Untuk backward compatibility dengan Blade chart_statbuku & overview
        $alltransSimulated = collect([
            ...(array_fill(0, $borrowCount, (object) ['status_pengembalian' => 0])),
            ...(array_fill(0, $backCount, (object) ['status_pengembalian' => 1])),
            ...(array_fill(0, $lostCount, (object) ['status_pengembalian' => 2])),
        ]);

        $bukuSimulated = collect([(object) ['stok_buku' => $totalBookStock]]);

        // 4. Buku & Kategori terbaru
        $book10 = $this->bukuRepo->getRecentBooks(7);
        $cat10 = $this->kategoriRepo->getRecentCategories(7);
        $totalCategory = $this->kategoriRepo->getTotalCount();

        return [
            'transaksi' => $transaksi,
            'transactionsevendays' => $transactionsevendays,
            'alltrans' => $alltransSimulated,
            'buku' => $bukuSimulated,
            'buku10' => $book10,
            'cat10' => $cat10,
            'totalCategory' => $totalCategory,
        ];
    }

    public function createBook(array $data, ?UploadedFile $photo = null): buku
    {
        $bookId = (string) Str::uuid();
        $photoName = null;

        if ($photo) {
            $photoName = time().'_'.Str::slug($data['judul_buku'] ?? 'buku').'.'.$photo->getClientOriginalExtension();
            $photo->move(public_path('images/Perpustakaan/foto_buku'), $photoName);
        }

        return buku::create([
            'id_buku' => $bookId,
            'id_kategori_buku' => $data['id_kategori_buku'],
            'id_jenis_buku' => $data['id_jenis_buku'],
            'author_buku' => $data['author_buku'],
            'publisher_buku' => $data['publisher_buku'],
            'judul_buku' => $data['judul_buku'],
            'foto_buku' => $photoName,
            'tahun_terbit' => $data['tahun_terbit'],
            'bahasa_buku' => $data['bahasa_buku'] ?? 'Indonesia',
            'stok_buku' => $data['stok_buku'] ?? 1,
            'rak_buku' => $data['rak_buku'] ?? 1,
            'harga_buku' => $data['harga_buku'] ?? 0,
            'tgl_ditambahkan' => now(),
        ]);
    }

    public function updateBook(string $id, array $data, ?UploadedFile $photo = null): bool
    {
        $book = buku::findOrFail($id);

        if ($photo) {
            if ($book->foto_buku && file_exists(public_path('images/Perpustakaan/foto_buku/'.$book->foto_buku))) {
                @unlink(public_path('images/Perpustakaan/foto_buku/'.$book->foto_buku));
            }

            $photoName = time().'_'.Str::slug($data['judul_buku'] ?? 'buku').'.'.$photo->getClientOriginalExtension();
            $photo->move(public_path('images/Perpustakaan/foto_buku'), $photoName);
            $data['foto_buku'] = $photoName;
        }

        return $book->update($data);
    }

    public function deleteBook(string $id): bool
    {
        $book = buku::findOrFail($id);

        if ($book->foto_buku && file_exists(public_path('images/Perpustakaan/foto_buku/'.$book->foto_buku))) {
            @unlink(public_path('images/Perpustakaan/foto_buku/'.$book->foto_buku));
        }

        return (bool) $book->delete();
    }
}
