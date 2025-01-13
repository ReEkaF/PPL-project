<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\kelas;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\KelasSiswa;
use App\Models\Superadmin;
use Illuminate\Support\Facades\Auth;

class SuperadminController extends Controller
{
    // Method for the dashboard
    public function index()
    {
        return view('superadmin.dashboard');
    }
    public function showDataGuru()
    {
        $guruData = Guru::orderBy('created_at', 'desc')
            ->paginate(5);
        return view('superadmin.keloladataguru.data_guru', compact('guruData'));
    }

    public function showDataSiswa()
    {
        $siswaData = Siswa::orderBy('created_at', 'desc')
            ->paginate(5);
        return view('superadmin.keloladatasiswa.data_siswa', compact('siswaData'));
    }

    public function searchGuru(Request $request)
    {
        $query = $request->input('search');
        $guruData = Guru::where('nip', 'LIKE', '%' . $query . '%')->paginate(5);

        return view('superadmin.keloladataguru.data_guru', compact('guruData'));
    }

    public function searchSiswa(Request $request)
    {
        $query = $request->input('search');
        $siswaData = Siswa::where('nisn', 'LIKE', '%' . $query . '%')->paginate(5);

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
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return redirect()->route('superadmin.keloladataguru')->with('success', 'Data guru berhasil dihapus.');
    }

    public function siswaDestroy($id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
        $siswa->delete();
        return redirect()->route('superadmin.keloladatasiswa')->with('success', 'Data siswa berhasil dihapus.');
    }
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('superadmin.keloladataguru.edit_guru', compact('guru'));
    }

    public function siswaEdit($id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
        return view('superadmin.keloladatasiswa.edit_siswa', compact('siswa'));
    }

    public function store(StoreGuruRequest $request)
    {
        $guru = new Guru();
        $guru->nama_guru = $request->nama_guru;
        $guru->nip = $request->nip;
        $guru->username = $request->username;
        $guru->password = bcrypt($request->password);
        $guru->alamat_guru = $request->alamat_guru;
        $guru->nomor_wa_guru = $request->nomor_wa_guru;
        $guru->email = $request->email;
        $guru->role_guru = $request->input('role_guru');
        if ($request->hasFile('foto_guru')) {
            $fileName = time() . '.' . $request->foto_guru->extension();
            $request->foto_guru->move(public_path('images/guru'), $fileName);
            $guru->foto_guru = $fileName;
        }
        $guru->save();
        return redirect()->route('superadmin.keloladataguru')->with('success', 'Data guru berhasil ditambahkan.');
    }
    public function update(UpdateGuruRequest $request, $id_guru)
    {
        $guru = Guru::findOrFail($id_guru);
        $guru->nama_guru = $request->nama_guru;
        $guru->nip = $request->nip;
        $guru->username = $request->username;
        $guru->alamat_guru = $request->alamat_guru;
        $guru->nomor_wa_guru = $request->nomor_wa_guru;
        $guru->email = $request->email;
        $guru->role_guru = $request->input('role_guru');
        if ($request->filled('password')) {
            $guru->password = bcrypt($request->password);
        }
        if ($request->hasFile('foto_guru')) {
            $fileName = time() . '.' . $request->foto_guru->extension();
            $request->foto_guru->move(public_path('images/guru'), $fileName);
            $guru->foto_guru = $fileName;
        }
        $guru->save();
        return redirect()->route('superadmin.keloladataguru')->with('success', 'Data guru berhasil diperbarui.');
    }
    public function storeSiswa(StoreSiswaRequest $request)
    {
        $siswa = new Siswa();
        $siswa->nisn = $request->nisn;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->tgl_lahir_siswa = $request->tgl_lahir_siswa;
        $siswa->jenis_kelamin_siswa = $request->jenis_kelamin_siswa;
        $siswa->alamat_siswa = $request->alamat_siswa;
        $siswa->password = bcrypt($request->password);
        $siswa->nomor_wa_siswa = $request->nomor_wa_siswa;
        $siswa->username = $request->username;
        $siswa->email = $request->email;
        $siswa->role_siswa = $request->input('role_siswa');

        if ($request->hasFile('foto_siswa')) {
            $fileName = time() . '.' . $request->foto_siswa->extension();
            $request->foto_siswa->move(public_path('images/siswa'), $fileName);
            $siswa->foto_siswa = $fileName;
        }
        $siswa->save();

        return redirect()->route('superadmin.keloladatasiswa')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function siswaUpdate(UpdateSiswaRequest $request, $id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->nisn = $request->nisn;
        $siswa->username = $request->username;
        $siswa->alamat_siswa = $request->alamat_siswa;
        $siswa->nomor_wa_siswa = $request->nomor_wa_siswa;
        $siswa->email = $request->email;
        $siswa->jenis_kelamin_siswa = $request->jenis_kelamin_siswa;
        $siswa->role_siswa = $request->input('role_siswa');
        $siswa->tgl_lahir_siswa = $request->tgl_lahir_siswa;

        if ($request->filled('password')) {
            $siswa->password = bcrypt($request->password);
        }

        if ($request->hasFile('foto_siswa')) {
            $fileName = time() . '.' . $request->foto_siswa->extension();
            $request->foto_siswa->move(public_path('images/siswa'), $fileName);
            $siswa->foto_siswa = $fileName;
        }

        $siswa->save();

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
    
        // Ambil data pengguna dari Auth guard
        $id_admin = Auth::guard('web-superadmin')->user()->id_admin;
    
        // Ambil admin berdasarkan id_admin
        $admin = Superadmin::where('id_admin', $id_admin)->first();
    
        if (!$admin) {
            // Jika admin tidak ditemukan
            return redirect()->route('superadmin.profile')->with('error', 'Admin tidak ditemukan!');
        }
    
        // Perbarui data lainnya
        $admin->username = $request->username; // Perbarui username
        $admin->email = $request->email; // Perbarui email
        $admin->nama_superadmin = $request->nama_superadmin;
        $admin->no_hp = $request->no_hp;
    
        // Perbarui password jika ada
        if ($request->new_password) {
            $admin->password = bcrypt($request->new_password);
        }
    
        // Simpan perubahan ke database
        $admin->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('superadmin.profile')->with('success', 'Profil berhasil diperbarui!');
    }
    
}
