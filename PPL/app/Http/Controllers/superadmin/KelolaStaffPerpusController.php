<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KelolaStaffPeprusRequest;
use App\Services\Superadmin\SuperadminService;

class KelolaStaffPerpusController extends Controller
{
    public function __construct(
        protected SuperadminService $superadminService
    ) {}

    public function index()
    {
        $staffperpus = $this->superadminService->getAllStaffPerpus();

        return view('superadmin.crud_staffperpus.index', compact('staffperpus'));
    }

    public function create()
    {
        return view('superadmin.crud_staffperpus.create');
    }

    public function edit($id)
    {
        $staffperpustakaan = $this->superadminService->findStaffPerpusOrFail($id);

        return view('superadmin.crud_staffperpus.edit', compact('staffperpustakaan'));
    }

    public function store(KelolaStaffPeprusRequest $request)
    {
        $this->superadminService->createStaffPerpus($request->validated());

        return redirect()->route('superadmin.kelola_staff_perpus')->with('success', 'User created successfully!');
    }

    public function update(KelolaStaffPeprusRequest $request)
    {
        $this->superadminService->updateStaffPerpus($request->id_staff_perpustakaan, $request->validated());

        return redirect()->route('superadmin.kelola_staff_perpus')->with('success', 'User created successfully!');
    }

    public function destroy($id)
    {
        $this->superadminService->deleteStaffPerpus($id);

        return redirect()->route('superadmin.kelola_staff_perpus')->with('success', 'Staff record deleted successfully');
    }

    public function reset($id)
    {
        $this->superadminService->resetPasswordStaffPerpus($id);

        return redirect()->route('superadmin.kelola_staff_perpus')->with('success', 'Password reset successfully');
    }
}
