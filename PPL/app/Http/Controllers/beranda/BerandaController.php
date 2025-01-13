<?php

namespace App\Http\Controllers\beranda;

use App\Models\buku;
use App\Models\Guru;
use App\Models\Staffperpus;
use Illuminate\Http\Request;
use App\Models\Staffakademik;
use App\Http\Controllers\Controller;
use App\Models\PrestasiEkstrakurikuler;

class BerandaController extends Controller
{
    public function home(){
        return view('beranda.home');
    }

    public function perpustakaanPublik(){
        $buku = buku::orderBy('tgl_ditambahkan', 'desc')->limit(4)->get();
        return view('beranda.perpustakaanPublik', compact('buku'));
    }

    public function tenagaPengajarPublik(){
        $guru = Guru::with(['gurumatapelajaran.mataPelajaran'])->get();
        return view('beranda.tenagaPengajarPublik', compact('guru'));
    }

    public function prestasiPublik(){
        $prestasi = PrestasiEkstrakurikuler::with('ekstrakurikuler')->get();
        return view('beranda.prestasiPublik', compact('prestasi'));
    }
}
