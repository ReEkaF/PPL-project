<?php

namespace App\Http\Controllers\pembinaekstra;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\InventarisEkstrakurikuler as Perlengkapan;
use Illuminate\Http\Request;

class PerlengkapanController extends Controller
{
    public function index()
    {
        if ($pembinaEkstra = Ekstrakurikuler::with('pembinaEkstra')
            ->where('guru_id', auth()->guard('web-guru')->user()->id_guru)
            ->first()){
            
            $nama_ekstrakurikuler = $pembinaEkstra->nama_ekstrakurikuler;
            $id_ekstra = $pembinaEkstra->id_ekstrakurikuler;
            $perlengkapan_ekstras = Perlengkapan::where('id_ekstrakurikuler', $id_ekstra)->latest()->paginate(10);

            return view('pembina_ekstra.perlengkapan.index', compact([
                'perlengkapan_ekstras',
                'nama_ekstrakurikuler',
                'id_ekstra'
            ]));
            
        } else {
            return view('pembina_ekstra.perlengkapan.index', [
                'perlengkapan_ekstras' => [],
                'nama_ekstrakurikuler' => 'Tidak Ada Ekstrakurikuler',
                'id_ekstra' => null
            ]);
        }
    }
}
