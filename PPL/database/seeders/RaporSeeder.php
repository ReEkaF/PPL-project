<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\tahun_ajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RaporSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaran = tahun_ajaran::where('aktif', 1)->first()
            ?? tahun_ajaran::first();

        if (!$tahunAjaran) {
            return;
        }

        $siswaList = Siswa::all();

        foreach ($siswaList as $siswa) {
            $exists = DB::table('rapor')
                ->where('siswa_id', $siswa->id_siswa)
                ->where('tahun_ajaran_id', $tahunAjaran->id_tahun_ajaran)
                ->exists();

            if (!$exists) {
                DB::table('rapor')->insert([
                    'id_rapor' => (string) Str::uuid(),
                    'siswa_id' => $siswa->id_siswa,
                    'tahun_ajaran_id' => $tahunAjaran->id_tahun_ajaran,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Seed subject grades and extracurricular grades for each student's rapor
        $this->call([
            NilaiMatpelSeeder::class,
            NilaiEkstraSeeder::class,
        ]);
    }
}
