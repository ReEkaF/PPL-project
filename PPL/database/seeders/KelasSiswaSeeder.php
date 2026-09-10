<?php

namespace Database\Seeders;

use App\Models\kelas;
use App\Models\Siswa;
use App\Models\tahun_ajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KelasSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaranAktif = tahun_ajaran::where('aktif', 1)->value('id_tahun_ajaran')
            ?? tahun_ajaran::first()?->id_tahun_ajaran;

        if (!$tahunAjaranAktif) {
            return;
        }

        // Get class records
        $kelas7 = kelas::where('nama_kelas', 'LIKE', '7%')->get();
        $kelas8 = kelas::where('nama_kelas', 'LIKE', '8%')->get();
        $kelas9 = kelas::where('nama_kelas', 'LIKE', '9%')->get();

        // 1. Grade 7 students (NISN starts with 008)
        $siswa7 = Siswa::where('nisn', 'LIKE', '008%')->get();
        foreach ($siswa7 as $index => $siswa) {
            $targetKelas = $kelas7[$index % $kelas7->count()] ?? $kelas7->first();
            if ($targetKelas) {
                $this->assignStudent($siswa->id_siswa, $targetKelas->id_kelas, $tahunAjaranAktif);
            }
        }

        // 2. Grade 8 students (NISN starts with 007)
        $siswa8 = Siswa::where('nisn', 'LIKE', '007%')->get();
        foreach ($siswa8 as $index => $siswa) {
            $targetKelas = $kelas8[$index % $kelas8->count()] ?? $kelas8->first();
            if ($targetKelas) {
                $this->assignStudent($siswa->id_siswa, $targetKelas->id_kelas, $tahunAjaranAktif);
            }
        }

        // 3. Grade 9 students (NISN starts with 006)
        $siswa9 = Siswa::where('nisn', 'LIKE', '006%')->get();
        foreach ($siswa9 as $index => $siswa) {
            $targetKelas = $kelas9[$index % $kelas9->count()] ?? $kelas9->first();
            if ($targetKelas) {
                $this->assignStudent($siswa->id_siswa, $targetKelas->id_kelas, $tahunAjaranAktif);
            }
        }

        // Fallback for any other students
        $remainingSiswa = Siswa::whereNotIn('id_siswa', DB::table('kelas_siswas')->pluck('id_siswa'))->get();
        $allKelas = kelas::all();
        foreach ($remainingSiswa as $index => $siswa) {
            $targetKelas = $allKelas[$index % $allKelas->count()];
            $this->assignStudent($siswa->id_siswa, $targetKelas->id_kelas, $tahunAjaranAktif);
        }
    }

    private function assignStudent(string $siswaId, string $kelasId, string $tahunAjaranId): void
    {
        $exists = DB::table('kelas_siswas')
            ->where('id_siswa', $siswaId)
            ->where('tahun_ajaran', $tahunAjaranId)
            ->exists();

        if (!$exists) {
            DB::table('kelas_siswas')->insert([
                'id_kelas_siswa' => (string) Str::uuid(),
                'id_kelas' => $kelasId,
                'id_siswa' => $siswaId,
                'tahun_ajaran' => $tahunAjaranId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
