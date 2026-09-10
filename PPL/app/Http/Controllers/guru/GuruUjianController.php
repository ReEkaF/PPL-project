<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ujian\StoreUjianRequest;
use App\Http\Requests\Ujian\UpdateSoalRequest;
use App\Imports\SoalUjianImport;
use App\Models\jawaban_ujian;
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
        $ujian = ujian::findOrFail($ujian_id);

        return view('guru.ujian.create_soal', compact('ujian_id', 'ujian'));
    }

    public function createUjian(): View
    {
        $data = $this->cbtService->getCreateUjianFormData();

        return view('guru.ujian.create_ujian', $data);
    }

    public function indexUjian(): View
    {
        $ujian = $this->cbtService->getPaginatedUjian(10);

        return view('guru.ujian.view_ujian', compact('ujian'));
    }

    public function storeData(StoreUjianRequest $request): RedirectResponse
    {
        $this->cbtService->createUjian($request->validated());

        return redirect()->route('ujian.show');
    }

    public function createSoal(string $ujian_id): View
    {
        return view('guru.ujian.create_soal', compact('ujian_id'));
    }

    public function showSoal(string $id): View
    {
        $data = $this->cbtService->getQuestionsForExam($id);

        return view('guru.ujian.show_soal', $data);
    }

    public function importSoal(Request $request, string $ujian_id): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'mimes:xlsx,csv'],
        ]);

        Excel::import(new SoalUjianImport($ujian_id), $request->file('file'));

        return redirect()->route('ujian.show')->with('success', 'Soal ujian berhasil diimpor!');
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
