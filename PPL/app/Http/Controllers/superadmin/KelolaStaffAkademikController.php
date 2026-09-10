<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KelolaStaffAkademikRequest;
use App\Services\Superadmin\SuperadminService;

class KelolaStaffAkademikController extends Controller
{
    public function __construct(
        protected SuperadminService $superadminService
    ) {}

    public function index()
    {
        $staffakademik = $this->superadminService->getAllStaffAkademik();

        return view('superadmin.crud_staffakademik.index', compact('staffakademik'));
    }

    public function create()
    {
        return view('superadmin.crud_staffakademik.create');
    }

    public function edit($id)
    {
        $staffakademik = $this->superadminService->findStaffAkademikOrFail($id);

        return view('superadmin.crud_staffakademik.edit', compact('staffakademik'));
    }

    public function store(KelolaStaffAkademikRequest $request)
    {
        $this->superadminService->createStaffAkademik($request->validated());

        return redirect()->route('superadmin.kelola_staff_akademik')->with('success', 'User created successfully!');
    }

    public function update(KelolaStaffAkademikRequest $request)
    {
        $this->superadminService->updateStaffAkademik($request->id_staff_akademik, $request->validated());

        return redirect()->route('superadmin.kelola_staff_akademik')->with('success', 'User created successfully!');
    }

    public function destroy($id)
    {
        $this->superadminService->deleteStaffAkademik($id);

        return redirect()->route('superadmin.kelola_staff_akademik')->with('success', 'Staff record deleted successfully');
    }

    public function reset($id)
    {
        $this->superadminService->resetPasswordStaffAkademik($id);

        return redirect()->route('superadmin.kelola_staff_akademik')->with('success', 'Password reset successfully');
    }
}
