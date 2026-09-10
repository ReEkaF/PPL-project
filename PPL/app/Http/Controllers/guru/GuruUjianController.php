<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ujian\StoreUjianRequest;
use App\Http\Requests\Ujian\UpdateSoalRequest;
use App\Exports\TemplateSoalExport;
use App\Imports\SoalUjianImport;
use App\Models\jawaban_ujian;
use App\Models\KelasSiswa;
use App\Models\pengumpulan_ujian;
use App\Models\soal_ujian;
use App\Models\ujian;
use App\Services\Ujian\CbtService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class GuruUjianController extends Controller
{
    public function __construct(
        protected CbtService $cbtService
    ) {}

    // CRUD JAWABAN
    public function showJawabanUjian(): View
    {
        $jawabanUjian = jawaban_ujian::all();
        $soalUjian = soal_ujian::all();

        return view('guru.ujian.jawaban_ujian', compact('jawabanUjian', 'soalUjian'));
    }

    public function editJawabanUjian(string $id): View
    {
        $jawaban = jawaban_ujian::findOrFail($id);
        $soalUjian = soal_ujian::all();

        return view('guru.ujian.jawaban_ujian_edit', compact('jawaban', 'soalUjian'));
    }

    public function destroyJawabanUjian(string $id): RedirectResponse
    {
        $jawaban = jawaban_ujian::findOrFail($id);
        $jawaban->delete();

        return redirect()->route('guru.dashboard.ujian.jawaban_ujian')->with('success', 'Jawaban ujian berhasil dihapus.');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $jawaban = jawaban_ujian::findOrFail($id);
        $soalUjian = soal_ujian::findOrFail($id);

        $jawaban->update($request->all());
        $soalUjian->update($request->all());

        return redirect()->route('guru.dashboard.ujian.jawaban_ujian')->with('success', 'Jawaban ujian berhasil diperbarui.');
    }

    // CRUD SOAL & UJIAN
    public function storeSoal(Request $request, string $ujian_id): View
    {
        return $this->createSoal($ujian_id);
    }

    public function createUjian(): View
    {
        $data = $this->cbtService->getCreateUjianFormData();

        return view('guru.ujian.create_ujian', $data);
    }

    public function indexUjian(Request $request): View
    {
        $kelasFilter = $request->query('kelas');
        $data = $this->cbtService->getGroupedUjianByKelas($kelasFilter);

        return view('guru.ujian.view_ujian', $data);
    }

    public function storeData(StoreUjianRequest $request): RedirectResponse
    {
        $ujian = $this->cbtService->createUjian($request->validated());

        return redirect()->route('guru.ujian.soal.create', $ujian->id_ujian)
            ->with('success', 'Paket ujian berhasil dibuat! Silakan tambahkan butir soal di Step 2 ini (melalui form manual atau upload file Excel).');
    }

    public function detailUjian(string $id): View
    {
        $guruId = auth()->guard('web-guru')->user()?->id_guru;

        $ujian = ujian::with([
            'kelasMataPelajaran.kelas',
            'kelasMataPelajaran.mataPelajaran',
            'topik',
            'soalUjian',
        ])->withCount(['soalUjian', 'pengumpulanUjian'])->findOrFail($id);

        if ($guruId && $ujian->kelasMataPelajaran && $ujian->kelasMataPelajaran->guru_id !== $guruId) {
            abort(403, 'Anda tidak memiliki akses ke paket ujian ini.');
        }

        $pengumpulan = pengumpulan_ujian::where('ujian_id', $id)
            ->with(['siswa', 'jawabanUjian.soalUjian'])
            ->latest('tanggal_pengumpulan')
            ->get();

        // Cari siswa di kelas ini yang belum mengumpulkan ujian
        $kelasId = $ujian->kelasMataPelajaran?->kelas_id;
        $belumMengerjakan = collect();
        if ($kelasId) {
            $submittedSiswaIds = $pengumpulan->pluck('siswa_id')->toArray();
            $belumMengerjakan = KelasSiswa::where('id_kelas', $kelasId)
                ->whereNotIn('id_siswa', $submittedSiswaIds)
                ->with('siswa')
                ->get()
                ->pluck('siswa')
                ->filter();
        }

        // Statistik nilai
        $nilaiList = $pengumpulan->pluck('nilai')->filter(fn ($n) => is_numeric($n))->map(fn ($n) => (float) $n);
        $rataRata = $nilaiList->isNotEmpty() ? round($nilaiList->avg(), 1) : 0;
        $nilaiTertinggi = $nilaiList->isNotEmpty() ? $nilaiList->max() : 0;
        $nilaiTerendah = $nilaiList->isNotEmpty() ? $nilaiList->min() : 0;

        return view('guru.ujian.detail_ujian', compact(
            'ujian',
            'pengumpulan',
            'belumMengerjakan',
            'rataRata',
            'nilaiTertinggi',
            'nilaiTerendah'
        ));
    }

    public function koreksiJawaban(string $id_pengumpulan): View
    {
        $guruId = auth()->guard('web-guru')->user()?->id_guru;

        $pengumpulan = pengumpulan_ujian::with([
            'siswa',
            'ujian.kelasMataPelajaran.mataPelajaran',
            'ujian.kelasMataPelajaran.kelas',
            'ujian.soalUjian',
            'jawabanUjian.soalUjian',
        ])->findOrFail($id_pengumpulan);

        if ($guruId && $pengumpulan->ujian?->kelasMataPelajaran && $pengumpulan->ujian->kelasMataPelajaran->guru_id !== $guruId) {
            abort(403, 'Anda tidak memiliki akses ke lembar jawaban ini.');
        }

        return view('guru.ujian.koreksi_jawaban', compact('pengumpulan'));
    }

    public function updateNilaiPengumpulan(Request $request, string $id_pengumpulan): RedirectResponse
    {
        $request->validate([
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $guruId = auth()->guard('web-guru')->user()?->id_guru;
        $pengumpulan = pengumpulan_ujian::with('ujian.kelasMataPelajaran')->findOrFail($id_pengumpulan);

        if ($guruId && $pengumpulan->ujian?->kelasMataPelajaran && $pengumpulan->ujian->kelasMataPelajaran->guru_id !== $guruId) {
            abort(403, 'Anda tidak memiliki izin memperbarui nilai ujian ini.');
        }

        $pengumpulan->update([
            'nilai' => $request->nilai,
        ]);

        return redirect()->back()->with('success', 'Nilai ujian siswa berhasil diperbarui.');
    }

    public function createSoal(string $ujian_id): View
    {
        $guruId = auth()->guard('web-guru')->user()?->id_guru;

        $ujian = ujian::with([
            'kelasMataPelajaran.kelas',
            'kelasMataPelajaran.mataPelajaran',
            'topik',
            'soalUjian',
        ])->withCount('soalUjian')->findOrFail($ujian_id);

        if ($guruId && $ujian->kelasMataPelajaran && $ujian->kelasMataPelajaran->guru_id !== $guruId) {
            abort(403, 'Anda tidak memiliki akses ke paket ujian ini.');
        }

        return view('guru.ujian.create_soal', compact('ujian', 'ujian_id'));
    }

    public function storeSoalManual(Request $request, string $ujian_id): RedirectResponse
    {
        $request->validate([
            'teks_soal' => ['required', 'string'],
            'opsi_a' => ['required', 'string'],
            'opsi_b' => ['required', 'string'],
            'opsi_c' => ['required', 'string'],
            'opsi_d' => ['required', 'string'],
            'kunci_jawaban' => ['required', 'in:A,B,C,D,a,b,c,d'],
        ]);

        $guruId = auth()->guard('web-guru')->user()?->id_guru;
        $ujian = ujian::with('kelasMataPelajaran')->findOrFail($ujian_id);

        if ($guruId && $ujian->kelasMataPelajaran && $ujian->kelasMataPelajaran->guru_id !== $guruId) {
            abort(403, 'Anda tidak memiliki akses ke paket ujian ini.');
        }

        soal_ujian::create([
            'ujian_id' => $ujian->id_ujian,
            'judul_ujian' => $ujian->judul,
            'teks_soal' => trim($request->teks_soal),
            'opsi_a' => trim($request->opsi_a),
            'opsi_b' => trim($request->opsi_b),
            'opsi_c' => trim($request->opsi_c),
            'opsi_d' => trim($request->opsi_d),
            'kunci_jawaban' => strtoupper($request->kunci_jawaban),
        ]);

        return redirect()->route('guru.ujian.soal.create', $ujian_id)
            ->with('success', 'Butir soal berhasil ditambahkan ke ujian!');
    }

    public function destroySoalStep(string $ujian_id, string $id_soal): RedirectResponse
    {
        $guruId = auth()->guard('web-guru')->user()?->id_guru;
        $ujian = ujian::with('kelasMataPelajaran')->findOrFail($ujian_id);

        if ($guruId && $ujian->kelasMataPelajaran && $ujian->kelasMataPelajaran->guru_id !== $guruId) {
            abort(403, 'Anda tidak memiliki akses ke paket ujian ini.');
        }

        $soal = soal_ujian::where('ujian_id', $ujian_id)->where('id_soal_ujian', $id_soal)->firstOrFail();
        $soal->delete();

        return redirect()->route('guru.ujian.soal.create', $ujian_id)
            ->with('success', 'Butir soal berhasil dihapus.');
    }

    public function downloadTemplateSoal()
    {
        return Excel::download(new TemplateSoalExport(), 'template_soal_ujian.xlsx');
    }

    public function showSoal(string $id): View
    {
        $data = $this->cbtService->getQuestionsForExam($id);

        return view('guru.ujian.show_soal', $data);
    }

    public function importSoal(Request $request, string $ujian_id): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'mimes:xlsx,csv,xls'],
        ]);

        $guruId = auth()->guard('web-guru')->user()?->id_guru;
        $ujian = ujian::with('kelasMataPelajaran')->findOrFail($ujian_id);

        if ($guruId && $ujian->kelasMataPelajaran && $ujian->kelasMataPelajaran->guru_id !== $guruId) {
            abort(403, 'Anda tidak memiliki akses ke paket ujian ini.');
        }

        Excel::import(new SoalUjianImport($ujian_id), $request->file('file'));

        return redirect()->route('guru.ujian.soal.create', $ujian_id)
            ->with('success', 'Berhasil mengimpor butir soal dari file Excel! Daftar soal ujian telah diperbarui di bawah.');
    }

    public function soalEdit(string $id): View
    {
        $soal = soal_ujian::findOrFail($id);
        $jawaban = soal_ujian::all();

        return view('guru.ujian.soal_edit', compact('soal', 'jawaban'));
    }

    public function soalUpdate(UpdateSoalRequest $request, string $id): RedirectResponse
    {
        $this->cbtService->updateQuestion($id, $request->validated());

        return redirect()->route('ujian.show')->with('success', 'Soal Ujian berhasil diperbarui.');
    }

    public function destroySoal(string $id): RedirectResponse
    {
        $this->cbtService->deleteQuestion($id);

        return redirect()->route('guru.dashboard.ujian.soal_ujian')->with('success', 'Soal ujian berhasil dihapus.');
    }

    public function pengumpulan(): View
    {
        return view('guru.ujian.pengumpulan');
    }

    // CRUD PENGUMPULAN UJIAN
    public function index(): View
    {
        $pengumpulanUjian = $this->cbtService->getSubmissions();

        return view('guru.ujian.pengumpulan_ujian', compact('pengumpulanUjian'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->cbtService->deleteSubmission($id);

        return redirect()->route('guru.dashboard.ujian.pengumpulan')->with('success', 'Data berhasil dihapus.');
    }
}
