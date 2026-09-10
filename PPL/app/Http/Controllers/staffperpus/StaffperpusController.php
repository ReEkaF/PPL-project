<?php

namespace App\Http\Controllers\staffperpus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Perpustakaan\StoreBukuRequest;
use App\Http\Requests\Perpustakaan\UpdateBukuRequest;
use App\Models\jenis_buku;
use App\Repositories\Contracts\Perpustakaan\BukuRepositoryInterface;
use App\Repositories\Contracts\Perpustakaan\KategoriBukuRepositoryInterface;
use App\Services\Perpustakaan\StaffPerpusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class StaffperpusController extends Controller
{
    protected StaffPerpusService $staffService;

    protected BukuRepositoryInterface $bukuRepo;

    protected KategoriBukuRepositoryInterface $kategoriRepo;

    public function __construct(
        StaffPerpusService $staffService,
        BukuRepositoryInterface $bukuRepo,
        KategoriBukuRepositoryInterface $kategoriRepo
    ) {
        $this->staffService = $staffService;
        $this->bukuRepo = $bukuRepo;
        $this->kategoriRepo = $kategoriRepo;
    }

    public function index(): View
    {
        $dashboardData = $this->staffService->getDashboardData();

        return view('staff_perpus.dashboard', $dashboardData);
    }

    public function profile(): View
    {
        $staff_account = Auth::guard('web-staffperpus')->user();

        return view('staff_perpus.profile', compact('staff_account'));
    }

    public function editprofile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'user' => 'required|string|max:18',
            'email' => 'required|email',
            'alamat' => 'required|string|max:500',
            'no_wa' => 'required|regex:/^\+?[0-9]{10,15}$/',
        ]);

        $profile = Auth::guard('web-staffperpus')->user();
        if ($profile) {
            $profile->update([
                'nama_staff_perpustakaan' => $validated['nama'],
                'username' => $validated['user'],
                'email' => $validated['email'],
                'alamat_staff_perpustakaan' => $validated['alamat'],
                'wa_staff_perpustakaan' => $validated['no_wa'],
            ]);

            return redirect()->route('staff_perpus.profile')->with('success', 'Profile updated successfully!');
        }

        return redirect()->route('staff_perpus.profile')->with('failed', 'Profile failed to update!');
    }

    public function pwdEdit(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'opwd' => 'required|string',
            'npwd' => 'required|string|min:8|confirmed:rpwd',
            'rpwd' => 'required|string|min:8|confirmed:npwd',
        ], [
            'npwd.confirmed' => 'Password konfirmasi tidak sama.',
            'rpwd.confirmed' => 'Password konfirmasi tidak sama.',
            'npwd.min' => 'Password baru minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff_perpus.profile')
                ->withErrors($validator)
                ->withInput();
        }

        $profile = Auth::guard('web-staffperpus')->user();
        if ($profile && Hash::check($request->input('opwd'), $profile->password)) {
            $profile->update([
                'password' => Hash::make($request->input('npwd')),
            ]);

            return redirect()->route('staff_perpus.profile')->with('success', 'Password berhasil diperbarui!');
        }

        return redirect()->route('staff_perpus.profile')->with('failed', 'Password lama tidak sesuai!');
    }

    public function daftarbuku(Request $request): View
    {
        $search = $request->input('search');
        $kategori_buku = $request->input('kategori_buku');

        $buku = $this->bukuRepo->searchBooks($search, $kategori_buku, 15);
        $kategoriBuku = $this->kategoriRepo->all();

        return view('staff_perpus.buku.daftarbuku', compact('buku', 'kategoriBuku'));
    }

    public function createbuku(): View
    {
        $kategoriBuku = $this->kategoriRepo->all();
        $jenisBuku = jenis_buku::all();

        return view('staff_perpus.buku.create', compact('kategoriBuku', 'jenisBuku'));
    }

    public function storebuku(StoreBukuRequest $request): RedirectResponse
    {
        $this->staffService->createBook(
            $request->validated(),
            $request->file('foto_buku')
        );

        return redirect()->route('staff_perpus.buku.daftarbuku')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function editbuku(string $id): View
    {
        $buku = $this->bukuRepo->findOrFail($id);
        $kategoriBuku = $this->kategoriRepo->all();
        $jenisBuku = jenis_buku::all();

        return view('staff_perpus.buku.edit', compact('buku', 'kategoriBuku', 'jenisBuku'));
    }

    public function updatebuku(UpdateBukuRequest $request, string $id): RedirectResponse
    {
        $this->staffService->updateBook(
            $id,
            $request->validated(),
            $request->file('foto_buku')
        );

        return redirect()->route('staff_perpus.buku.daftarbuku')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroybuku(string $id): RedirectResponse
    {
        $this->staffService->deleteBook($id);

        return redirect()->route('staff_perpus.buku.daftarbuku')->with('success', 'Buku berhasil dihapus.');
    }

    public function show(string $id): View
    {
        $buku = $this->bukuRepo->findOrFail($id, ['*'], ['kategoriBuku', 'jenisBuku']);

        return view('staff_perpus.buku.detail', compact('buku'));
    }

    public function manageCategory(): RedirectResponse
    {
        return redirect()->route('staff_perpus.managecategories');
    }
}
