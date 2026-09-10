<?php

namespace App\Services\Ekstrakurikuler;

use App\Models\ekstrakurikuler;
use App\Models\PengurusEkstra;
use App\Models\PostingEkstrakurikuler;
use App\Models\RegistrasiEkstrakurikuler;
use App\Models\Siswa;
use App\Repositories\Contracts\Ekstrakurikuler\EkstrakurikulerRepositoryInterface;
use App\Repositories\Contracts\Ekstrakurikuler\InventarisEkstraRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerService
{
    public function __construct(
        protected EkstrakurikulerRepositoryInterface $ekstraRepo,
        protected InventarisEkstraRepositoryInterface $inventarisRepo
    ) {}

    // ================= SISWA / PUBLIK =================

    public function getRegistrationFormData(string $siswaId): array
    {
        $siswa = Siswa::findOrFail($siswaId);
        $ekstrakurikulerList = $this->ekstraRepo->getOpenEkstrakurikuler();

        return [
            'siswa' => $siswa,
            'ekstrakurikulerList' => $ekstrakurikulerList,
        ];
    }

    public function submitRegistration(string $siswaId, array $data, ?UploadedFile $fileIzin = null, ?UploadedFile $fileDokter = null): void
    {
        $pathIzin = $fileIzin ? $fileIzin->store('berkas/public') : null;
        $pathDokter = $fileDokter ? $fileDokter->store('berkas/public') : null;

        $ekstraIds = $data['pilih_ekskul'] ?? [];

        $this->ekstraRepo->registerStudent($siswaId, $ekstraIds, $data, $pathIzin, $pathDokter);
    }

    public function getPublicDashboardData(): array
    {
        return [
            'ekstrakurikulerList' => $this->ekstraRepo->all(),
            'postingan' => PostingEkstrakurikuler::latest('tgl_uploud')->get(),
        ];
    }

    public function getPublicDetail(string $id): array
    {
        $ekstrakurikuler = $this->ekstraRepo->findOrFail($id);
        $prestasiList = DB::table('prestasi_ektrakurikuler')
            ->where('id_ekstrakurikuler', $id)
            ->get();

        return [
            'ekstrakurikuler' => $ekstrakurikuler,
            'prestasiList' => $prestasiList,
        ];
    }

    // ================= PENGURUS EKSTRA =================

    public function getPengurusDashboardData(string $siswaId): array
    {
        $pengurus = PengurusEkstra::with('ekstrakurikuler')->where('id_siswa', $siswaId)->first();
        if (! $pengurus) {
            return [
                'postings' => collect(),
                'id_ekstra' => null,
                'uplouders' => collect(),
                'rilStatus' => 'Tidak ada status',
                'ekstra' => null,
            ];
        }

        $idEkstra = $pengurus->id_ekstrakurikuler;
        $postings = PostingEkstrakurikuler::with(['pengurus.siswa'])
            ->where('id_ekstrakurikuler', $idEkstra)
            ->orderBy('tgl_uploud', 'desc')
            ->get();

        $uplouders = $postings->map(fn ($p) => $p->pengurus->siswa ?? null)->filter();
        $rilStatus = $pengurus->ekstrakurikuler->status ?? 'tutup';

        return [
            'postings' => $postings,
            'id_ekstra' => $idEkstra,
            'uplouders' => $uplouders,
            'rilStatus' => $rilStatus,
            'ekstra' => $pengurus,
        ];
    }

    public function storePostingan(string $siswaId, array $data, UploadedFile $gambar): Model
    {
        $pengurus = PengurusEkstra::where('id_siswa', $siswaId)->firstOrFail();
        $path = $gambar->store('ekstrakurikuler', 'public');

        return PostingEkstrakurikuler::create([
            'id_ekstrakurikuler' => $pengurus->id_ekstrakurikuler,
            'id_pengurus' => $pengurus->id_pengurus_ekstra,
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $path,
        ]);
    }

    public function updatePostingan(string $id, array $data, ?UploadedFile $gambar = null): bool
    {
        $posting = PostingEkstrakurikuler::findOrFail($id);

        if ($gambar) {
            if ($posting->gambar && Storage::disk('public')->exists($posting->gambar)) {
                Storage::disk('public')->delete($posting->gambar);
            }
            $posting->gambar = $gambar->store('ekstrakurikuler', 'public');
        }

        $posting->judul = $data['judul'];
        $posting->deskripsi = $data['deskripsi'];

        return (bool) $posting->save();
    }

    public function deletePostingan(string $id): bool
    {
        $posting = PostingEkstrakurikuler::findOrFail($id);
        if ($posting->gambar && Storage::disk('public')->exists($posting->gambar)) {
            Storage::disk('public')->delete($posting->gambar);
        }

        return (bool) $posting->delete();
    }

    public function updateStatusEkstra(string $siswaId, string $status, ?string $tglMulai = null, ?string $tglSelesai = null): void
    {
        $pengurus = PengurusEkstra::where('id_siswa', $siswaId)->firstOrFail();
        $ekstra = ekstrakurikuler::findOrFail($pengurus->id_ekstrakurikuler);
        $ekstra->status = $status;
        if ($tglMulai !== null) {
            $ekstra->tgl_mulai_pendaftaran = $tglMulai ? \Carbon\Carbon::parse($tglMulai) : null;
        }
        if ($tglSelesai !== null) {
            $ekstra->tgl_selesai_pendaftaran = $tglSelesai ? \Carbon\Carbon::parse($tglSelesai) : null;
        }
        $ekstra->save();
    }

    public function getPengurusAnggotaData(string $siswaId): array
    {
        $pengurus = PengurusEkstra::with('ekstrakurikuler', 'siswa')
            ->where('id_siswa', $siswaId)
            ->first();

        if (! $pengurus) {
            return [
                'ekstrakurikuler' => 'Tidak Ada',
                'loggedInUsername' => '',
                'totalItems' => 0,
                'members' => collect(),
            ];
        }

        $registrations = RegistrasiEkstrakurikuler::with('siswa')
            ->where('id_ekstrakurikuler', $pengurus->id_ekstrakurikuler)
            ->get();

        $members = $registrations->map(function ($reg) {
            if ($reg->siswa) {
                $reg->siswa->status = $reg->status;
            }

            return $reg->siswa;
        })->filter();

        return [
            'ekstrakurikuler' => $pengurus->ekstrakurikuler->nama_ekstrakurikuler,
            'members' => $members,
            'loggedInUsername' => $pengurus->siswa->nama_siswa ?? '',
            'totalItems' => $members->count(),
        ];
    }

    public function updateMemberStatusPengurus(string $siswaId, string $targetSiswaId, string $status): void
    {
        $pengurus = PengurusEkstra::where('id_siswa', $siswaId)->firstOrFail();
        $registration = RegistrasiEkstrakurikuler::where('id_siswa', $targetSiswaId)
            ->where('id_ekstrakurikuler', $pengurus->id_ekstrakurikuler)
            ->firstOrFail();

        $registration->status = $status;
        $registration->save();
    }

    // ================= PEMBINA EKSTRA =================

    public function getPembinaAnggotaData(string $guruId): array
    {
        $pembinaEkstra = ekstrakurikuler::where('guru_id', $guruId)->first();
        if (! $pembinaEkstra) {
            return [
                'ekstrakurikuler' => 'Tidak Ada Ekstrakurikuler',
                'members' => collect(),
                'totalItems' => 0,
            ];
        }

        $registrations = RegistrasiEkstrakurikuler::with('siswa')
            ->where('id_ekstrakurikuler', $pembinaEkstra->id_ekstrakurikuler)
            ->latest('tgl_registrasi')
            ->get();

        $members = $registrations->map(function ($reg) {
            return (object) [
                'name' => $reg->siswa->nama_siswa ?? '',
                'nisn' => $reg->siswa->nisn ?? '',
                'address' => $reg->siswa->alamat_siswa ?? '',
                'status' => $reg->status,
            ];
        });

        return [
            'ekstrakurikuler' => $pembinaEkstra->nama_ekstrakurikuler,
            'members' => $members,
            'totalItems' => $members->count(),
        ];
    }
}
