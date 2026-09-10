<?php

namespace App\Repositories\Contracts\Ekstrakurikuler;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface InventarisEkstraRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get paginated inventory items for an extracurricular.
     */
    public function getInventarisByEkstra(string $idEkstra, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get paginated history for an inventory item.
     */
    public function getHistoriByInventaris(int|string $idInventaris, int $perPage = 10): LengthAwarePaginator;

    /**
     * Create borrowing history record.
     */
    public function createHistori(array $data): Model;

    /**
     * Update borrowing history record.
     */
    public function updateHistori(int|string $id, array $data): bool;

    /**
     * Delete borrowing history record.
     */
    public function deleteHistori(int|string $id): bool;
}
