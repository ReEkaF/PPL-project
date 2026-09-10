<?php

namespace App\Http\Controllers\staffperpus;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Perpustakaan\KategoriBukuRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected KategoriBukuRepositoryInterface $kategoriRepo;

    public function __construct(KategoriBukuRepositoryInterface $kategoriRepo)
    {
        $this->kategoriRepo = $kategoriRepo;
    }

    public function manageCategory(): View
    {
        $arrayCategory = $this->kategoriRepo->all();

        return view('staff_perpus.kategori_buku', compact('arrayCategory'));
    }

    public function addCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kategori_buku,nama_kategori',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'name.unique' => 'Nama kategori sudah terdaftar.',
        ]);

        $this->kategoriRepo->create([
            'id_kategori_buku' => (string) Str::uuid(),
            'nama_kategori' => $request->input('name'),
        ]);

        return redirect()->route('staff_perpus.managecategories')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function deleteCategory(Request $request): RedirectResponse
    {
        $selected = $request->input('selected_categories');
        if (empty($selected)) {
            return redirect()->route('staff_perpus.managecategories')->with('failed', 'Pilih kategori yang akan dihapus!');
        }

        $ids = explode(',', $selected);
        foreach ($ids as $id) {
            $this->kategoriRepo->delete(trim($id));
        }

        return redirect()->route('staff_perpus.managecategories')->with('success', 'Kategori terpilih berhasil dihapus!');
    }

    public function updateCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kategori_buku,nama_kategori',
            'target' => 'required|exists:kategori_buku,id_kategori_buku',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
        ]);

        $this->kategoriRepo->update($request->input('target'), [
            'nama_kategori' => $request->input('name'),
        ]);

        return redirect()->route('staff_perpus.managecategories')->with('success', 'Kategori berhasil diperbarui!');
    }
}
