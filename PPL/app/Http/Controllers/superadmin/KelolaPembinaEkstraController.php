<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KelolaPembinaEkstraRequest;
use App\Models\Guru;

class KelolaPembinaEkstraController extends Controller
{
    public function index()
    {
        $pembinas = Guru::where('role_guru', 'pembina')->with('ekstrakurikuler')->orderBy('updated_at','DESC')->paginate(10);
        return view('superadmin.kelola_data_pembina_ekstra.index',compact('pembinas'));
    }

    public function create()
    {
        $gurus = Guru::where('role_guru', 'guru')->latest()->paginate(10);
        return view('superadmin.kelola_data_pembina_ekstra.create',compact('gurus'));
    }

    public function edit($id)
    {
        $pembina = Guru::where('id_guru',$id)->first();
        return view('superadmin.kelola_data_pembina_ekstra.edit',compact('pembina'));
    }

    /**
    * Update role guru menjadi pembina
    */
    public function store($id)
    {
        $gurur = Guru::findOrFail($id);
        $gurur->update(['role_guru' => 'pembina']);
        
        return redirect()->route('superadmin.kelola_pembina_ekstrakurikuler')->with('success', 'User created successfully!');
    }

    /**
    * Update data pembina
    */
    public function update(KelolaPembinaEkstraRequest $request)
    {
        $validatedData = $request->validated();
        if($request->password){
            $validatedData['password'] = bcrypt($validatedData['password']);
        }
        else{
            unset($validatedData['password']);
        }
        
        $pembina = Guru::find($request->id_guru);
        $pembina->update($validatedData);
    
        return redirect()->route('superadmin.kelola_pembina_ekstrakurikuler')->with('success', 'Pembina berhasil ditambahkan!');
    }

    /**
    * Hapus role pembina
    */
    public function destroy($id)
    {
        $gurur = Guru::findOrFail($id);

        $gurur->update(['role_guru' => 'guru']);

        return redirect()->route('superadmin.kelola_pembina_ekstrakurikuler')->with('success', 'Role pembina telah dicabut');
    }
}
