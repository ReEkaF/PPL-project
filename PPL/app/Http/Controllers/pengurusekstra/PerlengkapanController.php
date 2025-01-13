<?php

namespace App\Http\Controllers\pengurusekstra;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InventarisEkstrakurikuler as Perlengkapan;
use App\Models\PengurusEkstra;

class PerlengkapanController extends Controller
{
    public function index()
    {
        // dd(PengurusEkstra::with('ekstrakurikuler'));
        $pengurusEkstra = PengurusEkstra::with('ekstrakurikuler')->where('id_siswa', auth()->guard('web-siswa')->user()->id_siswa)->get()->first();
        // dd($pengurusEkstra);
        if ($pengurusEkstra != null) {
            $nama_ekstrakurikuler = $pengurusEkstra->ekstrakurikuler->nama_ekstrakurikuler;
            $id_ekstra = $pengurusEkstra->ekstrakurikuler->id_ekstrakurikuler;
            $perlengkapan_ekstras = Perlengkapan::where('id_ekstrakurikuler', $id_ekstra)->latest()->paginate(10);
            return view('pengurus_ekstra.perlengkapan.index', compact([
                'perlengkapan_ekstras',
                'nama_ekstrakurikuler',
                'id_ekstra'
            ]));

        } else {
            return view('pengurus_ekstra.perlengkapan.index', [
                'perlengkapan_ekstras' => [],
                'nama_ekstrakurikuler' => '',
                'id_ekstra' => ''
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ekstrakurikuler' => 'required',
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer',
        ]);

        Perlengkapan::create($request->all());

        return redirect()->route('pengurus_ekstra.perlengkapan')->with('success', 'Item created successfully.');
    }


    public function update(Request $request, Perlengkapan $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer',
        ]);

        $id->update($request->all());

        return redirect()->route('pengurus_ekstra.perlengkapan')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        try{
            $perlengkapan = Perlengkapan::findOrFail($id);
            $perlengkapan->delete();
        }
        catch (\Exception $e) {
            return redirect()->route('pengurus_ekstra.perlengkapan')->with('success', 'Item cannot be deleted.');
        }
        return redirect()->route('pengurus_ekstra.perlengkapan')->with('success', 'Item deleted successfully.');
    }
}
