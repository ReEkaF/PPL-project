<?php

namespace App\Http\Controllers\pengurusekstra;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ekstrakurikuler\StoreHistoriPeminjamanRequest;
use App\Models\HistoriInventaris;
use App\Models\InventarisEkstrakurikuler;
use App\Repositories\Contracts\Ekstrakurikuler\InventarisEkstraRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        return view('pengurus_ekstra.perlengkapan.histori', compact('items', 'id_inventaris', 'barang'));
    }

    public function store(StoreHistoriPeminjamanRequest $request): RedirectResponse
    {
        $this->inventarisRepo->createHistori($request->validated());

        return redirect()->route('pengurus_ekstra.histori', $request->id_inventaris)->with('success', 'Riwayat peminjaman berhasil dicatat.');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'id_inventaris' => 'required',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'histori_keluar' => 'required',
            'histori_masuk' => 'required',
        ]);

        $this->inventarisRepo->updateHistori($id, $request->all());

        return redirect()->route('pengurus_ekstra.histori', $request->id_inventaris)->with('success', 'Riwayat peminjaman berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $item = HistoriInventaris::findOrFail($id);
        $id_inventaris = $item->id_inventaris;
        $this->inventarisRepo->deleteHistori($id);

        return redirect()->route('pengurus_ekstra.histori', $id_inventaris)->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }
}
