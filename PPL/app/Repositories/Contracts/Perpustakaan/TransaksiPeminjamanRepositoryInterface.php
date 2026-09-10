<?php

namespace App\Repositories\Contracts\Perpustakaan;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TransaksiPeminjamanRepositoryInterface extends BaseRepositoryInterface
{
    public function getRecentTransactions(int $limit = 7): Collection;

    public function getTransactionsInPastDays(int $days = 7): Collection;

    public function paginateTransactions(?string $query, int $perPage = 10): LengthAwarePaginator;

    public function getUserBorrowingHistory(string $userCode, ?string $search = null): Collection;

    public function getTotalActiveLoansCount(): int;

    public function getTotalReturnedCount(): int;

    public function getTotalFineSum(): int;
}
