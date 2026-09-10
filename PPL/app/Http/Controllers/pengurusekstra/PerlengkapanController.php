<?php

namespace App\Http\Controllers\pengurusekstra;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ekstrakurikuler\StorePerlengkapanRequest;
use App\Http\Requests\Ekstrakurikuler\UpdatePerlengkapanRequest;
use App\Models\InventarisEkstrakurikuler as Perlengkapan;
use App\Models\PengurusEkstra;
use App\Repositories\Contracts\Ekstrakurikuler\InventarisEkstraRepositoryInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PerlengkapanController extends Controller
{
    public function __construct(
        protected InventarisEkstraRepositoryInterface $inventarisRepo
    ) {}

    public function index(): View
    {
        $pengurusEkstra = PengurusEkstra::with('ekstrakurikuler')
            ->where('id_siswa', auth()->guard('web-siswa')->user()->id_siswa)
            ->first();

        if ($pengurusEkstra) {
            $nama_ekstrakurikuler = $pengurusEkstra->ekstrakurikuler->nama_ekstrakurikuler;
            $id_ekstra = $pengurusEkstra->ekstrakurikuler->id_ekstrakurikuler;
            $perlengkapan_ekstras = $this->inventarisRepo->getInventarisByEkstra($id_ekstra, 10);

            return view('pengurus_ekstra.perlengkapan.index', compact(
                'perlengkapan_ekstras',
                'nama_ekstrakurikuler',
                'id_ekstra'
            ));
        }

        return view('pengurus_ekstra.perlengkapan.index', [
            'perlengkapan_ekstras' => [],
            'nama_ekstrakurikuler' => '',
            'id_ekstra' => '',
        ]);
    }

    public function store(StorePerlengkapanRequest $request): RedirectResponse
    {
        $this->inventarisRepo->create($request->validated());

        return redirect()->route('pengurus_ekstra.perlengkapan')->with('success', 'Barang inventaris berhasil ditambahkan.');
    }

    public function update(UpdatePerlengkapanRequest $request, Perlengkapan $id): RedirectResponse
    {
        $id->update($request->validated());

        return redirect()->route('pengurus_ekstra.perlengkapan')->with('success', 'Barang inventaris berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->inventarisRepo->delete($id);

            return redirect()->route('pengurus_ekstra.perlengkapan')->with('success', 'Barang inventaris berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('pengurus_ekstra.perlengkapan')->with('danger', 'Barang tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }
    }
}
