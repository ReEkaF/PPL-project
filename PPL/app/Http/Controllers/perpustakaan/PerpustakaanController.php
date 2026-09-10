<?php

namespace App\Http\Controllers\perpustakaan;

use App\Http\Controllers\Controller;
use App\Services\Perpustakaan\PerpustakaanCatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerpustakaanController extends Controller
{
    protected PerpustakaanCatalogService $catalogService;

    public function __construct(PerpustakaanCatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    public function indexGuru(Request $request): View
    {
        $data = $this->catalogService->getCatalogPageData(
            $request->input('search'),
            $request->input('kategori_buku'),
            12
        );

        $data['pages']->appends([
            'search' => $data['search'],
            'kategori_buku' => $data['kategori_buku'],
        ]);

        return view('guru.perpustakaan.index', $data);
    }

    public function showGuru(string $id): View
    {
        $data = $this->catalogService->getBookDetail($id);

        return view('guru.perpustakaan.detail', $data);
    }

    public function showRulesGuru(): View
    {
        return view('guru.perpustakaan.rules');
    }

    public function indexSiswa(Request $request): View
    {
        $data = $this->catalogService->getCatalogPageData(
            $request->input('search'),
            $request->input('kategori_buku'),
            12
        );

        $data['pages']->appends([
            'search' => $data['search'],
            'kategori_buku' => $data['kategori_buku'],
        ]);

        return view('siswa.perpustakaan.index', $data);
    }

    public function showSiswa(string $id): View
    {
        $data = $this->catalogService->getBookDetail($id);

        return view('siswa.perpustakaan.detail', $data);
    }

    public function showRulesSiswa(): View
    {
        return view('siswa.perpustakaan.rules');
    }
}
