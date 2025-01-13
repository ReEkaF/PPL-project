<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\superadmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\KelolaStaffPeprusRequest;
use App\Models\Staffperpus;
class KelolaStaffPerpusController extends Controller
{
    public function index()
    {
        $staffperpus= Staffperpus::all();
        return view('superadmin.crud_staffperpus.index',compact('staffperpus')); // Ensure this path exists
    }
    public function create()
    {
        return view('superadmin.crud_staffperpus.create'); // Ensure this path exists
    }
    public function edit($id)
    {
        $staffperpustakaan = Staffperpus::where('id_staff_perpustakaan',$id)->first();
        return view('superadmin.crud_staffperpus.edit',compact('staffperpustakaan')); // Ensure this path exists
    }
    public function store(KelolaStaffPeprusRequest $request)
    {
        
        // Enkripsi password sebelum disimpan
        $validatedData = $request->validated();
        // Simpan data ke dalam database
        Staffperpus::create($validatedData);
        
        // Redirect atau berikan respon sukses
        return redirect()->route('superadmin.kelola_staff_perpus')->with('success', 'User created successfully!');
    }
    public function update(KelolaStaffPeprusRequest $request)
    {
        // Enkripsi password sebelum disimpan
        $validatedData = $request->validated();
    
        // Simpan data ke dalam database
        $staffperpus = Staffperpus::find($request->id_staff_perpustakaan);
        $staffperpus->update($validatedData);
    
        // Redirect atau berikan respon sukses
        return redirect()->route('superadmin.kelola_staff_perpus')->with('success', 'User created successfully!');
    }
    public function destroy($id)
    {
        // Find the staff record by ID
        $staff = Staffperpus::findOrFail($id);

        // Attempt to delete the record
        $staff->delete();

        // Redirect with a success message
        return redirect()->route('superadmin.kelola_staff_perpus')->with('success', 'Staff record deleted successfully');
    }
    
    public function reset($id)
    {
        // Find the staff record by ID
        $staff = Staffperpus::findOrFail($id);

        // Attempt to delete the record
        $staff = Staffperpus::findOrFail($id);

        // Reset the password to be the same as the username
        $staff->password = bcrypt($staff->username);
        $staff->save();

        // Redirect with a success message
        return redirect()->route('superadmin.kelola_staff_perpus')->with('success', 'Password reset successfully');

        // Redirect with a success message
    }
}
