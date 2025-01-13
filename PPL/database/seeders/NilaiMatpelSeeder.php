<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NilaiMatpelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil semua mata pelajaran dan semua rapor
        $mataPelajaranList = DB::table('mata_pelajaran')->get();
        $raporList = DB::table('rapor')->get();

        // Untuk setiap rapor dan setiap mata pelajaran, buat nilai matpel
        foreach ($raporList as $rapor) {
            foreach ($mataPelajaranList as $matpel) {
                DB::table('nilai_matpel')->insert([
                    'id_nilai_matpel' => Str::uuid(),
                    'matpel_id' => $matpel->id_matpel,
                    'rapor_id' => $rapor->id_rapor,
                    'nilai_rata_rata_matpel' => rand(50, 100), // Nilai rata-rata antara 50 dan 100
                    'pesan' => 'Pertahankan prestasi dan terus tingkatkan!',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
