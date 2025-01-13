<?php

namespace App\Http\Controllers\pengurusekstra;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\PengurusEkstra;
use App\Models\PostingEkstrakurikuler;

class PengurusekstraController extends Controller
{
    public function dashboard()
    {
        // Ambil data pengurus yang login
        $pengurusEkstra = auth()->guard('web-siswa')->user()->id_siswa;
    
        try {
            // Pastikan pengurus memiliki id_ekstrakurikuler
            $ekstra = PengurusEkstra::with('ekstrakurikuler')->where('id_siswa',$pengurusEkstra)->first();
            $id_ekstra = $ekstra->id_ekstrakurikuler;
            // Ambil semua postingan terkait ekstrakurikuler
            $postings = PostingEkstrakurikuler::with(['pengurus.siswa'])
            ->where('id_ekstrakurikuler', $ekstra->id_ekstrakurikuler)
                ->orderBy('tgl_uploud', 'desc')
                ->get();

            $uplouders = $postings->map(function ($posting) {
                return $posting->pengurus->siswa ?? null;
            })->filter();

            $rilStatus = Ekstrakurikuler::where('id_ekstrakurikuler', $ekstra->id_ekstrakurikuler)->firstOrFail()->status;
        } catch (\Exception $e) {
            $rilStatus = 'Tidak ada status';
            $postings = [];
            $id_ekstra = null;
            $uplouders = [];
        }

        return view('pengurus_ekstra.dashboard', compact('postings', 'id_ekstra', 'uplouders', 'rilStatus', 'ekstra'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string',
        ]);
        
        // Ambil data pengurus yang login
        $pengurus = auth()->guard('web-siswa')->user()->id_siswa;
        $id_ekstra = PengurusEkstra::where('id_siswa',$pengurus)->first();
        

        // Validasi id_ekstrakurikuler
        // if (!$id_ekstra) {
        //     return redirect()->back()->with('error', 'Anda belum terkait dengan ekstrakurikuler tertentu.');
        // }

        // Upload gambar
        $path = $request->file('gambar')->store('ekstrakurikuler', 'public');

        // Simpan data ke tabel posting_ekstrakurikuler
        PostingEkstrakurikuler::create([
            'id_ekstrakurikuler' => $id_ekstra->id_ekstrakurikuler,
            'id_pengurus' => $id_ekstra->id_pengurus_ekstra,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'gambar' => $path,
        ]);

        return redirect()->back()->with('success', 'Postingan berhasil ditambahkan.');
    }
    public function destroy($id)
    {
        $posting = PostingEkstrakurikuler::findOrFail($id);
        $posting->delete();

        return redirect()->back()->with('success', 'Postingan berhasil dihapus.');
    }
    public function edit($id)
    {
        $posting = PostingEkstrakurikuler::findOrFail($id);
        return view('pengurus_ekstra.edit', compact('posting'));
    }
    public function show($id)
    {
        $posting = PostingEkstrakurikuler::findOrFail($id);

        return response()->json([
            'id_posting' => $posting->id_posting,
            'judul' => $posting->judul,
            'deskripsi' => $posting->deskripsi,
            'gambar' => $posting->gambar,
            'tgl_uploud' => $posting->tgl_uploud,
        ]);
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $posting = PostingEkstrakurikuler::findOrFail($id);

        // Update gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('ekstrakurikuler', 'public');
            $posting->gambar = $path;
        }

        $posting->judul = $validated['judul'];
        $posting->deskripsi = $validated['deskripsi'];
        $posting->save();

        return redirect()->route('pengurus_ekstra.dashboard')->with('success', 'Postingan berhasil diperbarui.');
        }

    public function updateStatus(Request $request){
        $pengurusEkstra = auth()->guard('web-siswa')->user()->id_siswa;
        $status = $request->input('status');
    
        // Pastikan pengurus memiliki id_ekstrakurikuler
        $ekstra = PengurusEkstra::with('ekstrakurikuler')->where('id_siswa',$pengurusEkstra)->first();
        $id_ekstra = $ekstra->id_ekstrakurikuler;

        // Pastikan pengurus memiliki id_ekstrakurikuler
        $ekstra = Ekstrakurikuler::where('id_ekstrakurikuler',$id_ekstra)->first();

        $ekstra->status = $status;
        $ekstra->save();

        return $this->dashboard();
    }
    
}
