<?php

namespace App\Services\Perpustakaan;

use App\Repositories\Contracts\Perpustakaan\BukuRepositoryInterface;
use App\Repositories\Contracts\Perpustakaan\KategoriBukuRepositoryInterface;
use App\Repositories\Contracts\Perpustakaan\TransaksiPeminjamanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PerpustakaanCatalogService
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

    public function getCatalogPageData(?string $search, ?string $kategoriId, int $perPage = 12): array
    {
        $books = $this->bukuRepo->searchBooks($search, $kategoriId, $perPage);
        $categories = $this->kategoriRepo->all();

        return [
            'pages' => $books,
            'categories' => $categories,
            'search' => $search,
            'kategori_buku' => $kategoriId,
        ];
    }

    public function getBookDetail(string $id): array
    {
        $book = $this->bukuRepo->findOrFail($id, ['*'], ['kategoriBuku', 'jenisBuku']);

        return [
            'buku' => $book,
            'kategori' => $book->kategoriBuku,
        ];
    }

    public function getUserHistory(string $userCode, ?string $search = null): Collection
    {
        return $this->transaksiRepo->getUserBorrowingHistory($userCode, $search);
    }
}
