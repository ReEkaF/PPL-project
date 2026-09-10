<?php

namespace App\Http\Controllers\perpustakaan;

use App\Http\Controllers\Controller;
use App\Services\Perpustakaan\PerpustakaanCatalogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RiwayatPengunjungController extends Controller
{
    protected PerpustakaanCatalogService $catalogService;

    public function __construct(PerpustakaanCatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    public function transGuru(Request $request): View|RedirectResponse
    {
        $guru = Auth::guard('web-guru')->user();
        if (! $guru) {
            return redirect()->route('login')->withErrors(['username' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        $transaksis = $this->catalogService->getUserHistory($guru->nip, $request->input('search'));

        return view('guru.perpustakaan.riwayat', compact('transaksis'));
    }

    public function transSiswa(Request $request): View|RedirectResponse
    {
        $siswa = Auth::guard('web-siswa')->user();
        if (! $siswa) {
            return redirect()->route('login')->withErrors(['username' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        $transaksis = $this->catalogService->getUserHistory($siswa->nisn, $request->input('search'));

        return view('siswa.perpustakaan.riwayat', compact('transaksis'));
    }
}
