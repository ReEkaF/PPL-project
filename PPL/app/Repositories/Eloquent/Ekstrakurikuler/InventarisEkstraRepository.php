<?php

namespace App\Repositories\Eloquent\Ekstrakurikuler;

use App\Models\HistoriInventaris;
use App\Models\InventarisEkstrakurikuler;
use App\Repositories\Contracts\Ekstrakurikuler\InventarisEkstraRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class InventarisEkstraRepository extends BaseRepository implements InventarisEkstraRepositoryInterface
{
    public function __construct(InventarisEkstrakurikuler $model)
    {
        parent::__construct($model);
    }

    public function getInventarisByEkstra(string $idEkstra, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->where('id_ekstrakurikuler', $idEkstra)
            ->latest()
            ->paginate($perPage);
    }

    public function getHistoriByInventaris(int|string $idInventaris, int $perPage = 10): LengthAwarePaginator
    {
        return HistoriInventaris::where('id_inventaris', $idInventaris)
            ->latest()
            ->paginate($perPage);
    }

    public function createHistori(array $data): Model
    {
        return HistoriInventaris::create($data);
    }

    public function updateHistori(int|string $id, array $data): bool
    {
        $histori = HistoriInventaris::find($id);
        if ($histori) {
            return (bool) $histori->update($data);
        }

        return false;
    }

    public function deleteHistori(int|string $id): bool
    {
        $histori = HistoriInventaris::find($id);
        if ($histori) {
            return (bool) $histori->delete();
        }

        return false;
    }
}
