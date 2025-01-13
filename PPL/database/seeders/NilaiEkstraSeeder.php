<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NilaiEkstraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil semua rapor
        $raporList = DB::table('rapor')->get();

        // Untuk setiap rapor, pilih 3 ekstrakurikuler secara acak dan masukkan nilai
        foreach ($raporList as $rapor) {
            // Ambil 3 ekstrakurikuler acak
            $ekstrakurikulerList = DB::table('ekstrakurikuler')->inRandomOrder()->limit(2)->get();

            foreach ($ekstrakurikulerList as $ekstrakurikuler) {
                DB::table('nilai_ekstra')->insert([
                    'id_nilai_ekstra' => Str::uuid(),
                    'ekstrakurikuler_id' => $ekstrakurikuler->id_ekstrakurikuler,
                    'rapor_id' => $rapor->id_rapor,
                    'nilai_rata_rata_ekstra' => rand(50, 100), // Nilai rata-rata antara 50 dan 100
                    'pesan' => 'Terus tingkatkan partisipasi dan kinerja!',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
