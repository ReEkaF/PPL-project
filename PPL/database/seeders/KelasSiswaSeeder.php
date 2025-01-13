<?php

namespace Database\Seeders;

use App\Models\kelas;
use App\Models\Siswa;
use Illuminate\Support\Str;
use App\Models\tahun_ajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaranAktif = tahun_ajaran::where('aktif', 1)->pluck('id_tahun_ajaran')->first();

        $siswaIds = Siswa::pluck('id_siswa')->toArray();
        $kelasIds = kelas::where('nama_kelas', "7A")->pluck('id_kelas')->toArray();

        foreach ($siswaIds as $siswaId) {
            $kelasId = $kelasIds[array_rand($kelasIds)];
            DB::table('kelas_siswas')->insert([
                'id_kelas_siswa' => Str::uuid(),
                'id_kelas' => $kelasId,
                'id_siswa' => $siswaId,
                'tahun_ajaran' => $tahunAjaranAktif,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
