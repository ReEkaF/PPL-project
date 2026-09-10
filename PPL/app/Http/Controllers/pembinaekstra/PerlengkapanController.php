<?php

namespace App\Http\Controllers\pembinaekstra;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Repositories\Contracts\Ekstrakurikuler\InventarisEkstraRepositoryInterface;
use Illuminate\View\View;

class PerlengkapanController extends Controller
{
    public function __construct(
        protected InventarisEkstraRepositoryInterface $inventarisRepo
    ) {}

    public function index(): View
    {
        $guruId = auth()->guard('web-guru')->user()->id_guru;
        $pembinaEkstra = Ekstrakurikuler::with('pembinaEkstra')->where('guru_id', $guruId)->first();

        if ($pembinaEkstra) {
            $nama_ekstrakurikuler = $pembinaEkstra->nama_ekstrakurikuler;
            $id_ekstra = $pembinaEkstra->id_ekstrakurikuler;
            $perlengkapan_ekstras = $this->inventarisRepo->getInventarisByEkstra($id_ekstra, 10);

            return view('pembina_ekstra.perlengkapan.index', compact(
                'perlengkapan_ekstras',
                'nama_ekstrakurikuler',
                'id_ekstra'
            ));
        }

        return view('pembina_ekstra.perlengkapan.index', [
            'perlengkapan_ekstras' => [],
            'nama_ekstrakurikuler' => 'Tidak Ada Ekstrakurikuler',
            'id_ekstra' => null,
        ]);
    }
}
