<?php

namespace App\Http\Controllers\pengurusekstra;

use App\Http\Controllers\Controller;
use App\Models\HistoriInventaris;
use App\Models\InventarisEkstrakurikuler;
use Illuminate\Http\Request;

class HistoriPeminjamanController extends Controller
{
    public function index($id){
        $id_inventaris = $id;
        $items = HistoriInventaris::where('id_inventaris', $id)->latest()->paginate(10);
        $barang = InventarisEkstrakurikuler::where('id_inventaris', $id)->value('nama_barang');
        return view('pengurus_ekstra.perlengkapan.histori', compact(['items', 'id_inventaris', 'barang']));
    }

    public function store(Request $request){

        $request->validate([
            'id_inventaris' => 'required',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'histori_keluar' => 'required',
        ]);

        HistoriInventaris::create($request->all());

        return redirect()->route('pengurus_ekstra.histori', $request->id_inventaris)->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id){
        $request->validate([
            'id_inventaris' => 'required',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'histori_keluar' => 'required',
            'histori_masuk' => 'required',
        ]);

        $item = HistoriInventaris::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('pengurus_ekstra.histori', $request->id_inventaris)->with('success', 'Item updated successfully.');
    }

    public function destroy($id){
        $item = HistoriInventaris::findOrFail($id);
        $id_inventaris = $item->id_inventaris;
        $item->delete();

        return redirect()->route('pengurus_ekstra.histori', $id_inventaris)->with('success', 'Item deleted successfully.');
    }
}
