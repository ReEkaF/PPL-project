<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\Superadmin\SuperadminService;
use Exception;
use Illuminate\Http\Request;

class KelolaPengurusEkstraController extends Controller
{
    public function __construct(
        protected SuperadminService $superadminService
    ) {}

    // Menampilkan data pengurus
    public function showDataPengurus()
    {
        $pengurusData = $this->superadminService->getPaginatedPengurus(5);

        return view('superadmin.crud_pengurusEkstra.data_pengurus', compact('pengurusData'));
    }

    // Menampilkan halaman tambah pengurus
    public function createPengurus()
    {
        $formData = $this->superadminService->getCreatePengurusFormData();

        return view('superadmin.crud_pengurusEkstra.tambah_pengurus', $formData);
    }

    // Menyimpan data pengurus
    public function storePengurus(Request $request, $id_siswa)
    {
        $request->validate([
            'ekstrakurikuler' => 'required|exists:ekstrakurikuler,id_ekstrakurikuler',
            'role_siswa' => 'required|string',
        ]);

        try {
            $this->superadminService->storePengurus($id_siswa, $request->ekstrakurikuler, $request->role_siswa);

            return redirect()->route('superadmin.keloladatapengurus')->with('success', 'Pengurus berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Menghapus data pengurus
    public function pengurusDestroy($id_pengurus)
    {
        $this->superadminService->deletePengurus($id_pengurus);

        return redirect()->route('superadmin.keloladatapengurus')->with('success', 'Data pengurus berhasil dihapus.');
    }

    // Update data pengurus (legacy/fallback)
    public function pengurusUpdate(Request $request, $id_siswa)
    {
        return $this->updatePengurus($request, $id_siswa);
    }

    // Mencari pengurus
    public function searchPengurus(Request $request)
    {
        $pengurusData = $this->superadminService->getPaginatedPengurus(5, $request->input('search'));

        return view('superadmin.crud_pengurusEkstra.data_pengurus', compact('pengurusData'));
    }

    public function editPengurus($id)
    {
        $formData = $this->superadminService->getEditPengurusFormData($id);

        return view('superadmin.crud_pengurusEkstra.edit_pengurus', $formData);
    }

    public function updatePengurus(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'nullable|string|max:255',
            'role_siswa' => 'required|string',
            'ekstrakurikuler' => 'required|exists:ekstrakurikuler,id_ekstrakurikuler',
        ]);

        $namaSiswa = $request->nama_siswa ?? $this->superadminService->findSiswaOrFail($id)->nama_siswa;
        $this->superadminService->updatePengurus($id, $request->ekstrakurikuler, $namaSiswa, $request->role_siswa);

        return redirect()->route('superadmin.keloladatapengurus')->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function deleteRole($id_siswa)
    {
        $this->superadminService->removePengurusRole($id_siswa);

        return redirect()->route('superadmin.keloladatapengurus')->with('success', 'Role pengurus berhasil dihapus.');
    }
}
