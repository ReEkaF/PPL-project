<?php

namespace App\Repositories\Eloquent\Perpustakaan;

use App\Models\transaksi_peminjaman;
use App\Repositories\Contracts\Perpustakaan\TransaksiPeminjamanRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TransaksiPeminjamanRepository extends BaseRepository implements TransaksiPeminjamanRepositoryInterface
{
    public function __construct(transaksi_peminjaman $model)
    {
        parent::__construct($model);
    }

    public function getRecentTransactions(int $limit = 7): Collection
    {
        return $this->model
            ->with(['buku.kategoriBuku', 'buku.jenisBuku'])
            ->orderBy('tgl_awal_peminjaman', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getTransactionsInPastDays(int $days = 7): Collection
    {
        $sinceDate = Carbon::now()->subDays($days)->toDateString();

        return $this->model
            ->with('buku')
            ->where('tgl_awal_peminjaman', '>=', $sinceDate)
            ->orderBy('tgl_awal_peminjaman', 'asc')
            ->get();
    }

    public function paginateTransactions(?string $query, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with(['buku'])
            ->where('stok', '!=', '0')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('kode_peminjam', 'like', '%'.$query.'%');
            })
            ->orderBy('tgl_awal_peminjaman', 'desc')
            ->paginate($perPage);
    }

    public function getUserBorrowingHistory(string $userCode, ?string $search = null): Collection
    {
        return $this->model
            ->with('buku')
            ->where('kode_peminjam', $userCode)
            ->when($search, function ($queryBuilder) use ($search) {
                $queryBuilder->whereHas('buku', function ($bukuQuery) use ($search) {
                    $bukuQuery->where('judul_buku', 'like', '%'.$search.'%');
                });
            })
            ->orderByRaw('status_pengembalian != 1 DESC')
            ->orderBy('tgl_pengembalian', 'desc')
            ->get();
    }

    public function getTotalActiveLoansCount(): int
    {
        return $this->model->where('status_pengembalian', 0)->count();
    }

    public function getTotalReturnedCount(): int
    {
        return $this->model->where('status_pengembalian', 1)->count();
    }

    public function getTotalFineSum(): int
    {
        return (int) $this->model->where('status_denda', 1)->sum('denda');
    }
}
