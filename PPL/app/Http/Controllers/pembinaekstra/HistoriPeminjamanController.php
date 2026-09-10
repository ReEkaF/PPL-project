<?php

namespace App\Http\Controllers\pembinaekstra;

use App\Http\Controllers\Controller;
use App\Models\InventarisEkstrakurikuler;
use App\Repositories\Contracts\Ekstrakurikuler\InventarisEkstraRepositoryInterface;
use Illuminate\View\View;

class HistoriPeminjamanController extends Controller
{
    public function __construct(
        protected InventarisEkstraRepositoryInterface $inventarisRepo
    ) {}

    public function index(string $id): View
    {
        $id_inventaris = $id;
        $items = $this->inventarisRepo->getHistoriByInventaris($id, 10);
        $barang = InventarisEkstrakurikuler::where('id_inventaris', $id)->value('nama_barang');

        return view('pembina_ekstra.perlengkapan.histori', compact('items', 'id_inventaris', 'barang'));
    }
}
