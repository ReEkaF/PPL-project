<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use App\Models\tahun_ajaran;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $query = tahun_ajaran::withCount([
            'kelasmatapelajaran',
            'kelassiswa',
            'rapor',
        ]);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('tahun_mulai', 'like', "%{$search}%")
                    ->orWhere('tahun_selesai', 'like', "%{$search}%")
                    ->orWhere('semester', 'like', "%{$search}%");
            });
        }

        $tahunAjarans = $query->orderBy('tahun_mulai', 'desc')
            ->orderBy('semester', 'desc')
            ->paginate(10)
            ->withQueryString();

        $activeTahunAjaran = tahun_ajaran::where('aktif', 1)->first();

        $totalTahunAjaran = tahun_ajaran::count();

        return view('staff_akademik.tahunAjaran.index', compact(
            'tahunAjarans',
            'activeTahunAjaran',
            'totalTahunAjaran',
            'search'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tahun_mulai' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2099'],
            'tahun_selesai' => ['required', 'integer', 'digits:4', 'gte:tahun_mulai'],
            'semester' => ['required', 'in:1,2'],
            'aktif' => ['nullable', 'boolean'],
        ], [
            'tahun_mulai.required' => 'Tahun mulai wajib diisi.',
            'tahun_mulai.digits' => 'Tahun mulai harus 4 digit angka.',
            'tahun_selesai.required' => 'Tahun selesai wajib diisi.',
            'tahun_selesai.digits' => 'Tahun selesai harus 4 digit angka.',
            'tahun_selesai.gte' => 'Tahun selesai harus sama dengan atau setelah tahun mulai.',
            'semester.required' => 'Semester wajib dipilih.',
            'semester.in' => 'Semester harus bernilai 1 (Ganjil) atau 2 (Genap).',
        ]);

        // Check if identical year and semester already exists
        $exists = tahun_ajaran::where('tahun_mulai', $validated['tahun_mulai'])
            ->where('tahun_selesai', $validated['tahun_selesai'])
            ->where('semester', $validated['semester'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('danger', "Tahun ajaran {$validated['tahun_mulai']}/{$validated['tahun_selesai']} semester {$validated['semester']} sudah ada.");
        }

        $setAktif = $request->boolean('aktif');
        $hasAnyActive = tahun_ajaran::where('aktif', 1)->exists();

        // If no academic year is currently active, set this one as active automatically
        if (!$hasAnyActive) {
            $setAktif = true;
        }

        try {
            DB::transaction(function () use ($validated, $setAktif) {
                if ($setAktif) {
                    tahun_ajaran::query()->update(['aktif' => 0]);
                }

                tahun_ajaran::create([
                    'tahun_mulai' => $validated['tahun_mulai'],
                    'tahun_selesai' => $validated['tahun_selesai'],
                    'semester' => $validated['semester'],
                    'aktif' => $setAktif ? 1 : 0,
                ]);
            });

            return redirect()->route('staff_akademik.tahun-ajaran.index')
                ->with('success', 'Tahun ajaran berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Gagal menambahkan tahun ajaran: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $tahunAjaran = tahun_ajaran::findOrFail($id);

        $validated = $request->validate([
            'tahun_mulai' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2099'],
            'tahun_selesai' => ['required', 'integer', 'digits:4', 'gte:tahun_mulai'],
            'semester' => ['required', 'in:1,2'],
        ], [
            'tahun_mulai.required' => 'Tahun mulai wajib diisi.',
            'tahun_mulai.digits' => 'Tahun mulai harus 4 digit angka.',
            'tahun_selesai.required' => 'Tahun selesai wajib diisi.',
            'tahun_selesai.digits' => 'Tahun selesai harus 4 digit angka.',
            'tahun_selesai.gte' => 'Tahun selesai harus sama dengan atau setelah tahun mulai.',
            'semester.required' => 'Semester wajib dipilih.',
            'semester.in' => 'Semester harus bernilai 1 (Ganjil) atau 2 (Genap).',
        ]);

        $duplicate = tahun_ajaran::where('tahun_mulai', $validated['tahun_mulai'])
            ->where('tahun_selesai', $validated['tahun_selesai'])
            ->where('semester', $validated['semester'])
            ->where('id_tahun_ajaran', '!=', $id)
            ->exists();

        if ($duplicate) {
            return redirect()->back()
                ->withInput()
                ->with('danger', "Tahun ajaran {$validated['tahun_mulai']}/{$validated['tahun_selesai']} semester {$validated['semester']} sudah ada.");
        }

        try {
            $tahunAjaran->update([
                'tahun_mulai' => $validated['tahun_mulai'],
                'tahun_selesai' => $validated['tahun_selesai'],
                'semester' => $validated['semester'],
            ]);

            return redirect()->route('staff_akademik.tahun-ajaran.index')
                ->with('update', 'Data tahun ajaran berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Gagal memperbarui tahun ajaran: ' . $e->getMessage());
        }
    }

    /**
     * Activate the specified academic year.
     */
    public function activate(string $id): RedirectResponse
    {
        $tahunAjaran = tahun_ajaran::findOrFail($id);

        if ($tahunAjaran->aktif) {
            return redirect()->back()
                ->with('info', 'Tahun ajaran ini sudah berstatus aktif.');
        }

        try {
            DB::transaction(function () use ($tahunAjaran) {
                tahun_ajaran::query()->update(['aktif' => 0]);
                $tahunAjaran->update(['aktif' => 1]);
            });

            $semesterText = $tahunAjaran->semester == 1 ? '1 (Ganjil)' : '2 (Genap)';
            return redirect()->route('staff_akademik.tahun-ajaran.index')
                ->with('success', "Tahun ajaran {$tahunAjaran->tahun_mulai}/{$tahunAjaran->tahun_selesai} Semester {$semesterText} berhasil diaktifkan.");
        } catch (Exception $e) {
            return redirect()->back()
                ->with('danger', 'Gagal mengaktifkan tahun ajaran: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $tahunAjaran = tahun_ajaran::findOrFail($id);

        // Guard: Do not allow deletion of active academic year
        if ($tahunAjaran->aktif) {
            return redirect()->back()
                ->with('danger', 'Tahun ajaran yang sedang aktif tidak dapat dihapus. Silakan aktifkan tahun ajaran lain terlebih dahulu.');
        }

        // Guard: Check relations
        $hasJadwal = $tahunAjaran->kelasmatapelajaran()->exists();
        $hasSiswa = $tahunAjaran->kelassiswa()->exists();
        $hasRapor = $tahunAjaran->rapor()->exists();
        $hasEkstra = $tahunAjaran->penilaianekstra()->exists();

        if ($hasJadwal || $hasSiswa || $hasRapor || $hasEkstra) {
            $details = [];
            if ($hasJadwal) $details[] = 'jadwal mata pelajaran';
            if ($hasSiswa) $details[] = 'pembagian siswa kelas';
            if ($hasRapor) $details[] = 'nilai rapor';
            if ($hasEkstra) $details[] = 'penilaian ekstrakurikuler';

            $reasons = implode(', ', $details);

            return redirect()->back()
                ->with('danger', "Tidak dapat menghapus tahun ajaran karena masih memiliki data terikat ({$reasons}).");
        }

        try {
            $tahunAjaran->delete();

            return redirect()->route('staff_akademik.tahun-ajaran.index')
                ->with('success', 'Tahun ajaran berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('danger', 'Gagal menghapus tahun ajaran: ' . $e->getMessage());
        }
    }
}
