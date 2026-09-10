<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KelolaPembinaEkstraRequest;
use App\Services\Superadmin\SuperadminService;

class KelolaPembinaEkstraController extends Controller
{
    public function __construct(
        protected SuperadminService $superadminService
    ) {}

    public function index()
    {
        $pembinas = $this->superadminService->getPaginatedPembina(10);

        return view('superadmin.kelola_data_pembina_ekstra.index', compact('pembinas'));
    }

    public function create()
    {
        $gurus = $this->superadminService->getAvailableGuruForPembina(10);

        return view('superadmin.kelola_data_pembina_ekstra.create', compact('gurus'));
    }

    public function edit($id)
    {
        $pembina = $this->superadminService->findGuruOrFail($id);

        return view('superadmin.kelola_data_pembina_ekstra.edit', compact('pembina'));
    }

    /**
     * Update role guru menjadi pembina
     */
    public function store($id)
    {
        $this->superadminService->setPembinaRole($id);

        return redirect()->route('superadmin.kelola_pembina_ekstrakurikuler')->with('success', 'User created successfully!');
    }

    /**
     * Update data pembina
     */
    public function update(KelolaPembinaEkstraRequest $request)
    {
        $this->superadminService->updatePembina($request->id_guru, $request->validated());

        return redirect()->route('superadmin.kelola_pembina_ekstrakurikuler')->with('success', 'Pembina berhasil ditambahkan!');
    }

    /**
     * Hapus role pembina
     */
    public function destroy($id)
    {
        $this->superadminService->removePembinaRole($id);

        return redirect()->route('superadmin.kelola_pembina_ekstrakurikuler')->with('success', 'Role pembina telah dicabut');
    }
}
