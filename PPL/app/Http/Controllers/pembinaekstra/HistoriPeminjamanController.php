<?php

namespace App\Http\Controllers\pembinaekstra;

use Illuminate\Http\Request;
use App\Models\HistoriInventaris;
use App\Http\Controllers\Controller;
use App\Models\InventarisEkstrakurikuler;

class HistoriPeminjamanController extends Controller
{
    public function index($id){
        $id_inventaris = $id;
        $items = HistoriInventaris::where('id_inventaris', $id)->latest()->paginate(10);
        $barang = InventarisEkstrakurikuler::where('id_inventaris', $id)->value('nama_barang');
        return view('pembina_ekstra.perlengkapan.histori', compact(['items', 'id_inventaris', 'barang']));
    }
}
