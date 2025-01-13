<?php

namespace App\Http\Controllers\superadmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\KelolaStaffAkademikRequest;
use App\Models\Staffakademik;
use Illuminate\Http\Request;

class KelolaStaffAkademikController extends Controller
{
    public function index()
    {
        $staffakademik = Staffakademik::all();
        return view('superadmin.crud_staffakademik.index',compact('staffakademik')); // Ensure this path exists
    }
    public function create()
    {
        return view('superadmin.crud_staffakademik.create'); // Ensure this path exists
    }
    public function edit($id)
    {
        $staffakademik = Staffakademik::where('id_staff_akademik',$id)->first();
        return view('superadmin.crud_staffakademik.edit',compact('staffakademik')); // Ensure this path exists
    }
    public function store(KelolaStaffAkademikRequest $request)
    {
        // Enkripsi password sebelum disimpan
        $validatedData = $request->validated();
        // Simpan data ke dalam database
        Staffakademik::create($validatedData);
    
        // Redirect atau berikan respon sukses
        return redirect()->route('superadmin.kelola_staff_akademik')->with('success', 'User created successfully!');
    }
    public function update(KelolaStaffAkademikRequest $request)
    {
        // Enkripsi password sebelum disimpan
        $validatedData = $request->validated();
    
        // Simpan data ke dalam database
        $staffakademik = Staffakademik::find($request->id_staff_akademik);
        $staffakademik->update($validatedData);
    
        // Redirect atau berikan respon sukses
        return redirect()->route('superadmin.kelola_staff_akademik')->with('success', 'User created successfully!');
    }
    public function destroy($id)
    {
        // Find the staff record by ID
        $staff = StaffAkademik::findOrFail($id);

        // Attempt to delete the record
        $staff->delete();

        // Redirect with a success message
        return redirect()->route('superadmin.kelola_staff_akademik')->with('success', 'Staff record deleted successfully');
    }
    
    public function reset($id)
    {
        // Find the staff record by ID
        $staff = StaffAkademik::findOrFail($id);

        // Attempt to delete the record
        $staff = Staffakademik::findOrFail($id);

        // Reset the password to be the same as the username
        $staff->password = bcrypt($staff->username);
        $staff->save();

        // Redirect with a success message
        return redirect()->route('superadmin.kelola_staff_akademik')->with('success', 'Password reset successfully');

        // Redirect with a success message
    }
    
}
