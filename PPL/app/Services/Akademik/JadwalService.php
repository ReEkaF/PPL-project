<?php

namespace App\Services\Akademik;

use App\Repositories\Contracts\Akademik\JadwalRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JadwalService
{
    public function __construct(
        protected JadwalRepositoryInterface $jadwalRepo
    ) {}

    public function getJadwalIndexData(?string $kelasId = null): array
    {
        $kelasList = DB::table('kelas')
            ->orderByRaw('LENGTH(nama_kelas)')
            ->orderBy('nama_kelas')
            ->get();

        $data = $this->jadwalRepo->getJadwalForKelas($kelasId);

        return [
            'data' => $data,
            'kelas' => $kelasList,
            'kelas_id' => $kelasId,
        ];
    }

    public function getCreateFormData(): array
    {
        $tahunAjaran = DB::table('tahun_ajaran')->where('aktif', 1)->first();
        $kelasList = DB::table('kelas')
            ->orderByRaw('LENGTH(nama_kelas)')
            ->orderBy('nama_kelas')
            ->get();

        $hariList = DB::table('hari')
            ->orderByRaw("FIELD(nama_hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get();

        $guruMataPelajaran = DB::table('guru_mata_pelajaran')
            ->join('guru', 'guru_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('mata_pelajaran', 'guru_mata_pelajaran.matpel_id', '=', 'mata_pelajaran.id_matpel')
            ->select('guru.id_guru', 'guru.nama_guru', 'mata_pelajaran.id_matpel', 'mata_pelajaran.nama_matpel')
            ->get();

        return [
            'kelas' => $kelasList,
            'hari' => $hariList,
            'guruMataPelajaran' => $guruMataPelajaran,
            'tahunAjaran' => $tahunAjaran,
        ];
    }

    public function storeJadwalBatch(string $kelasId, string $tahunAjaranId, array $jadwalData): array
    {
        $bentrok = [];

        foreach ($jadwalData as $item) {
            $parts = explode('_', $item['guru_id']);
            $guruId = $parts[0];
            $matpelId = $parts[1] ?? null;

            [$waktuMulai, $waktuSelesai] = explode('-', $item['jam_pelajaran']);
            $hariId = $item['hari_id'];

            // Check teacher conflict
            $bentrokGuru = $this->jadwalRepo->checkBentrokGuru(
                $guruId,
                $hariId,
                $tahunAjaranId,
                $waktuMulai,
                $waktuSelesai
            );

            // Check class conflict
            $bentrokKelas = $this->jadwalRepo->checkBentrokKelas(
                $kelasId,
                $hariId,
                $tahunAjaranId,
                $waktuMulai,
                $waktuSelesai
            );

            if ($bentrokGuru) {
                $bentrok[] = [
                    'tipe' => 'guru',
                    'nama_guru' => DB::table('guru')->where('id_guru', $guruId)->value('nama_guru'),
                    'nama_kelas' => DB::table('kelas')->where('id_kelas', $kelasId)->value('nama_kelas'),
                    'nama_hari' => DB::table('hari')->where('id_hari', $hariId)->value('nama_hari'),
                    'jam_pelajaran' => "{$waktuMulai}-{$waktuSelesai}",
                ];
            } elseif ($bentrokKelas) {
                $bentrok[] = [
                    'tipe' => 'kelas',
                    'nama_kelas' => DB::table('kelas')->where('id_kelas', $kelasId)->value('nama_kelas'),
                    'nama_hari' => DB::table('hari')->where('id_hari', $hariId)->value('nama_hari'),
                    'jam_pelajaran' => "{$waktuMulai}-{$waktuSelesai}",
                ];
            } else {
                $this->jadwalRepo->createJadwal([
                    'id_kelas_mata_pelajaran' => (string) Str::uuid(),
                    'kelas_id' => $kelasId,
                    'hari_id' => $hariId,
                    'waktu_mulai' => $waktuMulai,
                    'waktu_selesai' => $waktuSelesai,
                    'guru_id' => $guruId,
                    'mata_pelajaran_id' => $matpelId,
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return $bentrok;
    }

    public function getEditFormData(string $id): array
    {
        $jadwal = DB::table('kelas_mata_pelajaran')->where('id_kelas_mata_pelajaran', $id)->first();
        if (! $jadwal) {
            throw new Exception('Jadwal tidak ditemukan.');
        }

        $kelasList = DB::table('kelas')->orderByRaw('LENGTH(nama_kelas)')->orderBy('nama_kelas')->get();
        $hariList = DB::table('hari')->orderByRaw("FIELD(nama_hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")->get();
        $guruMataPelajaran = DB::table('guru_mata_pelajaran')
            ->join('guru', 'guru_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('mata_pelajaran', 'guru_mata_pelajaran.matpel_id', '=', 'mata_pelajaran.id_matpel')
            ->select('guru.id_guru', 'guru.nama_guru', 'mata_pelajaran.id_matpel', 'mata_pelajaran.nama_matpel')
            ->get();

        return [
            'jadwal' => $jadwal,
            'kelas' => $kelasList,
            'hari' => $hariList,
            'guruMataPelajaran' => $guruMataPelajaran,
        ];
    }

    public function updateJadwal(string $id, array $data): void
    {
        [$waktuMulai, $waktuSelesai] = explode('-', $data['jam_pelajaran']);
        $kelasId = $data['kelas_id'];
        $hariId = $data['hari_id'];
        $parts = explode('_', $data['guruid_matpelid']);
        $guruId = $parts[0];
        $matpelId = $parts[1] ?? null;

        $tahunAjaranId = DB::table('tahun_ajaran')->where('aktif', 1)->value('id_tahun_ajaran');
        if (! $tahunAjaranId) {
            throw new Exception('Tahun ajaran aktif tidak ditemukan.');
        }

        $bentrokKelas = $this->jadwalRepo->checkBentrokKelas(
            $kelasId,
            $hariId,
            $tahunAjaranId,
            $waktuMulai,
            $waktuSelesai,
            $id
        );

        if ($bentrokKelas) {
            $namaKelas = DB::table('kelas')->where('id_kelas', $kelasId)->value('nama_kelas');
            $namaHari = DB::table('hari')->where('id_hari', $hariId)->value('nama_hari');
            throw new Exception("Jadwal kelas {$namaKelas} bentrok dengan pelajaran lain pada hari {$namaHari} pukul {$waktuMulai}-{$waktuSelesai}.");
        }

        $bentrokGuru = $this->jadwalRepo->checkBentrokGuru(
            $guruId,
            $hariId,
            $tahunAjaranId,
            $waktuMulai,
            $waktuSelesai,
            $id
        );

        if ($bentrokGuru) {
            $namaGuru = DB::table('guru')->where('id_guru', $guruId)->value('nama_guru');
            $namaHari = DB::table('hari')->where('id_hari', $hariId)->value('nama_hari');
            throw new Exception("Guru {$namaGuru} sudah memiliki jadwal mengajar pada hari {$namaHari} pukul {$waktuMulai}-{$waktuSelesai}.");
        }

        $updateData = [
            'kelas_id' => $kelasId,
            'hari_id' => $hariId,
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
            'guru_id' => $guruId,
        ];
        if ($matpelId) {
            $updateData['mata_pelajaran_id'] = $matpelId;
        }

        $this->jadwalRepo->updateJadwal($id, $updateData);
    }

    public function deleteJadwal(string $id): void
    {
        $deleted = $this->jadwalRepo->deleteJadwal($id);
        if (! $deleted) {
            throw new Exception('Jadwal tidak dapat dihapus.');
        }
    }

    public function getJadwalForGuru(?string $guruId = null): Collection
    {
        return $this->jadwalRepo->getJadwalForGuru($guruId);
    }

    public function getJadwalForSiswa(string $siswaId): array
    {
        $kelasSiswa = DB::table('kelas_siswas')->where('id_siswa', $siswaId)->first();
        if (! $kelasSiswa) {
            return [
                'jadwal' => collect(),
                'has_kelas' => false,
            ];
        }

        $jadwal = DB::table('kelas_mata_pelajaran')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->where('kelas_mata_pelajaran.kelas_id', $kelasSiswa->id_kelas)
            ->orderBy('hari.id_hari')
            ->orderBy('kelas_mata_pelajaran.waktu_mulai')
            ->select(
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'mata_pelajaran.nama_matpel',
                'guru.nama_guru'
            )
            ->get();

        return [
            'jadwal' => $jadwal,
            'has_kelas' => true,
        ];
    }
}
