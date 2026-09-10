<?php

namespace App\Services\Perpustakaan;

use App\Models\buku;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\transaksi_peminjaman;
use App\Repositories\Contracts\Perpustakaan\TransaksiPeminjamanRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TransaksiPeminjamanService
{
    protected TransaksiPeminjamanRepositoryInterface $transaksiRepo;

    public function __construct(TransaksiPeminjamanRepositoryInterface $transaksiRepo)
    {
        $this->transaksiRepo = $transaksiRepo;
    }

    public function createLoan(array $data): array
    {
        $book = buku::findOrFail($data['id_buku']);

        if ($book->stok_buku < 1) {
            return ['success' => false, 'message' => 'Stok buku tidak mencukupi.'];
        }

        $kodePeminjam = null;
        $tglPengembalian = null;
        $isSiswa = ($data['jenis_peminjam'] === 'siswa');

        if ($isSiswa) {
            $siswa = Siswa::where('nisn', $data['nisn_nip'])->first();
            if (! $siswa) {
                return ['success' => false, 'message' => 'NISN siswa tidak ditemukan.'];
            }
            $kodePeminjam = $siswa->nisn;

            // Syarat: tidak boleh punya 3 atau lebih denda aktif belum dibayar
            $unpaidFines = transaksi_peminjaman::where('kode_peminjam', $kodePeminjam)
                ->where('denda', '>', 0)
                ->where('status_denda', 0)
                ->count();

            if ($unpaidFines >= 3) {
                return ['success' => false, 'message' => 'Siswa memiliki 3 atau lebih denda yang belum dibayar. Tidak dapat meminjam buku.'];
            }

            // Batas maksimal peminjaman buku non-paket yang belum dikembalikan (maks 3)
            $activeNonPackage = transaksi_peminjaman::where('kode_peminjam', $kodePeminjam)
                ->where('stok', 1)
                ->whereHas('buku', fn ($q) => $q->where('id_jenis_buku', 1))
                ->count();

            if ($activeNonPackage >= 3 && $book->id_jenis_buku == 1) {
                return ['success' => false, 'message' => 'Siswa telah mencapai batas peminjaman 3 buku non-paket yang belum dikembalikan.'];
            }

            // Paket: 1 tahun, non-paket: 2 minggu
            $tglPengembalian = ($book->id_jenis_buku == 2) ? now()->addYear() : now()->addWeeks(2);
        } else {
            $guru = Guru::where('nip', $data['nisn_nip'])->first();
            if (! $guru) {
                return ['success' => false, 'message' => 'NIP guru tidak ditemukan.'];
            }
            $kodePeminjam = $guru->nip;

            $unpaidFines = transaksi_peminjaman::where('kode_peminjam', $kodePeminjam)
                ->where('denda', '>', 0)
                ->where('status_denda', 0)
                ->count();

            if ($unpaidFines >= 3) {
                return ['success' => false, 'message' => 'Guru memiliki 3 atau lebih denda yang belum dibayar. Tidak dapat meminjam buku.'];
            }

            $activeNonPackage = transaksi_peminjaman::where('kode_peminjam', $kodePeminjam)
                ->where('stok', 1)
                ->whereHas('buku', fn ($q) => $q->where('id_jenis_buku', 1))
                ->count();

            if ($activeNonPackage >= 3 && $book->id_jenis_buku == 1) {
                return ['success' => false, 'message' => 'Guru telah mencapai batas peminjaman 3 buku non-paket yang belum dikembalikan.'];
            }

            $tglPengembalian = now()->addYear();
        }

        // Simpan transaksi
        $loan = transaksi_peminjaman::create([
            'id_transaksi_peminjaman' => (string) Str::uuid(),
            'id_buku' => $book->id_buku,
            'kode_peminjam' => $kodePeminjam,
            'tgl_awal_peminjaman' => now(),
            'tgl_pengembalian' => $tglPengembalian,
            'denda' => 0,
            'status_pengembalian' => 0,
            'jenis_peminjam' => $isSiswa ? 0 : 1,
            'status_denda' => 0,
            'stok' => 1,
        ]);

        $book->decrement('stok_buku', 1);

        return ['success' => true, 'message' => 'Transaksi peminjaman berhasil ditambahkan.', 'data' => $loan];
    }

    public function processReturnStatus(string $transactionId, int $statusPengembalian, ?int $statusDenda = null): array
    {
        $transaction = transaksi_peminjaman::find($transactionId);
        if (! $transaction) {
            return ['success' => false, 'message' => 'Transaksi tidak ditemukan.'];
        }

        if ($statusDenda !== null && $statusDenda == 1) {
            $transaction->status_denda = 1;
        }

        $book = buku::find($transaction->id_buku);

        if ($statusPengembalian == 1) {
            // Aman / kembali normal
            $transaction->stok = max(0, $transaction->stok - 1);
            if ($book) {
                $book->increment('stok_buku', 1);
            }
            $transaction->status_pengembalian = 1;
            $transaction->save();

            return ['success' => true, 'message' => 'Status pengembalian berhasil diperbarui.'];
        } elseif ($statusPengembalian == 2) {
            // Hilang
            $transaction->stok = max(0, $transaction->stok - 1);
            $transaction->status_pengembalian = 2;
            if ($book) {
                $transaction->denda += $book->harga_buku;
            }
            $transaction->save();

            return ['success' => true, 'message' => 'Status buku hilang berhasil diproses. Denda telah diperbarui.'];
        } elseif ($statusPengembalian == 0) {
            // Telat
            $transaction->stok = max(0, $transaction->stok - 1);
            $transaction->status_pengembalian = 0;

            $today = now();
            $returnDate = Carbon::parse($transaction->tgl_pengembalian);
            $daysLate = (int) $returnDate->diffInDays($today, false);

            if ($daysLate > 0) {
                $transaction->denda += 1000 * $daysLate;
            }

            if ($book) {
                $book->increment('stok_buku', 1);
            }

            $transaction->save();

            return ['success' => true, 'message' => 'Pengembalian terlambat berhasil diproses. Denda telah diperbarui.'];
        }

        return ['success' => false, 'message' => 'Status pengembalian tidak valid.'];
    }

    public function payFine(string $transactionId): bool
    {
        $transaction = transaksi_peminjaman::findOrFail($transactionId);
        $transaction->status_denda = 1;

        return $transaction->save();
    }
}
