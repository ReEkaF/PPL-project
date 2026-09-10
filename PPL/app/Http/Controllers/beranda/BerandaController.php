<?php

namespace App\Http\Controllers\beranda;

use App\Http\Controllers\Controller;
use App\Services\Portal\BerandaService;
use Illuminate\Contracts\View\View;

class BerandaController extends Controller
{
    protected BerandaService $berandaService;

    public function __construct(BerandaService $berandaService)
    {
        $this->berandaService = $berandaService;
    }

    public function home(): View
    {
        $homeData = $this->berandaService->getHomePageData();

        return view('beranda.home', $homeData);
    }

    public function perpustakaanPublik(): View
    {
        $buku = $this->berandaService->getPublicLibraryBooks();

        return view('beranda.perpustakaanPublik', compact('buku'));
    }

    public function tenagaPengajarPublik(): View
    {
        $guru = $this->berandaService->getPublicTeachers();

        return view('beranda.tenagaPengajarPublik', compact('guru'));
    }

    public function prestasiPublik(): View
    {
        $prestasi = $this->berandaService->getPublicAchievements();

        return view('beranda.prestasiPublik', compact('prestasi'));
    }
}
