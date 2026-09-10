<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Services\Superadmin\SuperadminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperadminController extends Controller
{
    public function __construct(
        protected SuperadminService $superadminService
    ) {}

    // Method for the dashboard
    public function index()
    {
        return view('superadmin.dashboard');
    }

    public function showDataGuru()
    {
        $guruData = $this->superadminService->getPaginatedGuru(5);

        return view('superadmin.keloladataguru.data_guru', compact('guruData'));
    }

    public function showDataSiswa()
    {
        $siswaData = $this->superadminService->getPaginatedSiswa(5);

        return view('superadmin.keloladatasiswa.data_siswa', compact('siswaData'));
    }

    public function searchGuru(Request $request)
    {
        $guruData = $this->superadminService->getPaginatedGuru(5, $request->input('search'));

        return view('superadmin.keloladataguru.data_guru', compact('guruData'));
    }

    public function searchSiswa(Request $request)
    {
        $siswaData = $this->superadminService->getPaginatedSiswa(5, $request->input('search'));

        return view('superadmin.keloladatasiswa.data_siswa', compact('siswaData'));
    }

    public function create()
    {
        return view('superadmin.keloladataguru.tambah');
    }

    public function createSiswa()
    {
        return view('superadmin.keloladatasiswa.tambah');
    }

    public function destroy($id)
    {
        $this->superadminService->deleteGuru($id);

        return redirect()->route('superadmin.keloladataguru')->with('success', 'Data guru berhasil dihapus.');
    }

    public function siswaDestroy($id_siswa)
    {
        $this->superadminService->deleteSiswa($id_siswa);

        return redirect()->route('superadmin.keloladatasiswa')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function edit($id)
    {
        $guru = $this->superadminService->findGuruOrFail($id);

        return view('superadmin.keloladataguru.edit_guru', compact('guru'));
    }

    public function siswaEdit($id_siswa)
    {
        $siswa = $this->superadminService->findSiswaOrFail($id_siswa);

        return view('superadmin.keloladatasiswa.edit_siswa', compact('siswa'));
    }

    public function store(StoreGuruRequest $request)
    {
        $this->superadminService->createGuru($request->validated(), $request->file('foto_guru'));

        return redirect()->route('superadmin.keloladataguru')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function update(UpdateGuruRequest $request, $id_guru)
    {
        $this->superadminService->updateGuru($id_guru, $request->validated(), $request->file('foto_guru'));

        return redirect()->route('superadmin.keloladataguru')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function storeSiswa(StoreSiswaRequest $request)
    {
        $this->superadminService->createSiswa($request->validated(), $request->file('foto_siswa'));

        return redirect()->route('superadmin.keloladatasiswa')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function siswaUpdate(UpdateSiswaRequest $request, $id_siswa)
    {
        $this->superadminService->updateSiswa($id_siswa, $request->validated(), $request->file('foto_siswa'));

        return redirect()->route('superadmin.keloladatasiswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function setting()
    {
        $admin = Auth::guard('web-superadmin')->user();

        return view('superadmin.setting.index', compact('admin'));
    }

    public function setting_update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:8|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'nama_superadmin' => 'required|string|max:255',
            'no_hp' => 'required|string|max:13',
            'new_password' => 'nullable|string|min:8',
        ]);

        $id_admin = Auth::guard('web-superadmin')->user()->id_admin;

        $this->superadminService->updateSuperadminProfile($id_admin, $request->only([
            'username',
            'email',
            'nama_superadmin',
            'no_hp',
            'new_password',
        ]));

        return redirect()->route('superadmin.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
