<?php

namespace App\Http\Controllers\StaffAkademik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akademik\StoreGuruMatpelRequest;
use App\Http\Requests\Akademik\StoreKelasRequest;
use App\Http\Requests\Akademik\StoreMataPelajaranRequest;
use App\Http\Requests\Akademik\UpdateKelasRequest;
use App\Http\Requests\Akademik\UpdateMataPelajaranRequest;
use App\Models\Guru;
use App\Models\guru_mata_pelajaran;
use App\Models\kelas;
use App\Models\mata_pelajaran;
use App\Services\Akademik\AkademikManagementService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelasController extends Controller
{
    public function __construct(
        protected AkademikManagementService $akademikService
    ) {}

    // ================= MATA PELAJARAN =================

    public function index(Request $request): View
    {
        $search = $request->input('search');
        $mataPelajaran = $this->akademikService->getPaginatedMataPelajaran($search, 10);

        return view('staff_akademik.matpel.master_matpel', compact('mataPelajaran', 'search'));
    }

    public function store(StoreMataPelajaranRequest $request): RedirectResponse
    {
        $this->akademikService->createMataPelajaran($request->validated());

        return redirect()->route('staff_akademik.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $mataPelajaran = mata_pelajaran::findOrFail($id);

        return view('staff_akademik.matpel.edit_matpel', compact('mataPelajaran'));
    }

    public function update(UpdateMataPelajaranRequest $request, string $id): RedirectResponse
    {
        $this->akademikService->updateMataPelajaran($id, $request->validated());

        return redirect()->route('staff_akademik.mata-pelajaran.index')
            ->with('update', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->akademikService->deleteMataPelajaran($id);

            return redirect()->route('staff_akademik.mata-pelajaran.index')
                ->with('success', 'Mata pelajaran berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('staff_akademik.mata-pelajaran.index')
                ->with('danger', 'Mata pelajaran tidak bisa dihapus karena sedang digunakan.');
        }
    }

    // ================= KELAS =================

    public function indexKelas(Request $request): View
    {
        $search = $request->input('search');
        $kelas = $this->akademikService->getPaginatedKelas($search, 10);

        return view('staff_akademik.matpel.master_kelas', compact('kelas', 'search'));
    }

    public function storeKelas(StoreKelasRequest $request): RedirectResponse
    {
        $this->akademikService->createKelas($request->validated());

        return redirect()->route('staff_akademik.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function editKelas(string $id): View
    {
        $kelas = kelas::findOrFail($id);

        return view('staff_akademik.kelas.edit_kelas', compact('kelas'));
    }

    public function updateKelas(UpdateKelasRequest $request, string $id): RedirectResponse
    {
        $this->akademikService->updateKelas($id, $request->validated());

        return redirect()->route('staff_akademik.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroyKelas(string $id): RedirectResponse
    {
        $this->akademikService->deleteKelas($id);

        return redirect()->route('staff_akademik.kelas.index')
            ->with('danger', 'Kelas berhasil dihapus.');
    }

    // ================= GURU MATA PELAJARAN =================

    public function indexGuruMataPelajaran(Request $request): View
    {
        $search = $request->input('search');
        $guruMataPelajaran = $this->akademikService->getPaginatedGuruMatpel($search, 10);
        $gurus = Guru::all();
        $mataPelajaran = mata_pelajaran::all();

        return view('staff_akademik.matpel.master_guru', compact('guruMataPelajaran', 'gurus', 'mataPelajaran'));
    }

    public function createGuruMataPelajaran(): View
    {
        $formData = $this->akademikService->getGuruMatpelFormData();

        return view('staff_akademik.guru_mata_pelajaran.create', $formData);
    }

    public function storeGuruMataPelajaran(StoreGuruMatpelRequest $request): RedirectResponse
    {
        $this->akademikService->assignGuruMatpel($request->validated('guru_id'), $request->validated('matpel_id'));

        return redirect()->route('staff_akademik.guru_mata_pelajaran.index')
            ->with('success', 'Penugasan guru ke mata pelajaran berhasil ditambahkan.');
    }

    public function editGuruMataPelajaran(string $id): View
    {
        $penugasan = guru_mata_pelajaran::findOrFail($id);
        $formData = $this->akademikService->getGuruMatpelFormData();

        return view('staff_akademik.guru_mata_pelajaran.edit', array_merge(['penugasan' => $penugasan], $formData));
    }

    public function updateGuruMataPelajaran(StoreGuruMatpelRequest $request, string $id): RedirectResponse
    {
        $this->akademikService->updateGuruMatpel($id, $request->validated('guru_id'), $request->validated('matpel_id'));

        return redirect()->route('staff_akademik.guru_mata_pelajaran.index')
            ->with('update', 'Penugasan guru ke mata pelajaran berhasil diperbarui.');
    }

    public function destroyGuruMataPelajaran(string $id): RedirectResponse
    {
        $this->akademikService->deleteGuruMatpel($id);

        return redirect()->route('staff_akademik.guru_mata_pelajaran.index')
            ->with('danger', 'Penugasan guru ke mata pelajaran berhasil dihapus.');
    }

    // Sidebar views
    public function showMasterGuru(): View
    {
        return view('staff_akademik.matpel.master_guru');
    }

    public function showMasterKelas(): View
    {
        return view('staff_akademik.matpel.master_kelas');
    }

    public function showMasterMatpel(): View
    {
        return view('staff_akademik.matpel.master_matpel');
    }

    // ================= MANAGEMENT KELAS & SISWA =================

    public function daftarkelas(): View
    {
        $kelas = $this->akademikService->getAllKelasWithStudentCount();

        return view('staff_akademik.managementkelas.index', compact('kelas'));
    }

    public function showSiswa(string $id_kelas): View
    {
        $kelas = $this->akademikService->getKelasDetailWithStudents($id_kelas);

        return view('staff_akademik.managementkelas.siswa', compact('kelas'));
    }

    public function tambahSiswa(string $id_kelas): View
    {
        $data = $this->akademikService->getTambahSiswaData($id_kelas);

        return view('staff_akademik.managementkelas.tambah_siswa', $data);
    }

    public function simpanSiswa(Request $request, string $id_kelas): RedirectResponse
    {
        $siswaIds = $request->input('siswa_ids');
        if (empty($siswaIds)) {
            return redirect()->back()->with('error', 'Tidak ada siswa yang dipilih.');
        }

        try {
            $this->akademikService->addStudentsToKelas($id_kelas, $siswaIds);

            return redirect()->route('kelas.siswa', $id_kelas)
                ->with('success', 'Siswa berhasil ditambahkan ke kelas.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function hapusSiswa(string $id_kelas, string $id_siswa): RedirectResponse
    {
        $this->akademikService->removeStudentFromKelas($id_kelas, $id_siswa);

        return redirect()->back()->with('success', 'Siswa berhasil dihapus dari kelas.');
    }

    public function hapusSiswaMassal(Request $request, string $id_kelas): RedirectResponse
    {
        $siswaIds = $request->input('siswa_ids');
        if (! empty($siswaIds)) {
            $this->akademikService->removeStudentsMassalFromKelas($id_kelas, $siswaIds);
        }

        return redirect()->route('kelas.siswa', $id_kelas)
            ->with('success', 'Siswa yang dipilih berhasil dihapus dari kelas.');
    }

    public function editWaliKelas(string $id_kelas): View
    {
        $data = $this->akademikService->getEditWaliKelasData($id_kelas);

        return view('staff_akademik.managementkelas.edit_wali_kelas', $data);
    }

    public function updateWaliKelas(Request $request, string $id_kelas): RedirectResponse
    {
        $waliKelasId = $request->input('wali_kelas');
        $this->akademikService->updateWaliKelas($id_kelas, $waliKelasId);

        return redirect()->route('kelas.siswa', $id_kelas)
            ->with('success', 'Wali Kelas Berhasil Diperbarui Untuk Seluruh Siswa Di Kelas Ini');
    }
}
