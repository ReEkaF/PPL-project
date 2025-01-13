<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BobotPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penilaian = [
            ['jenis_penilaian' => 'Tugas', 'bobot' => 0.3],
            ['jenis_penilaian' => 'UTS', 'bobot' => 0.3],
            ['jenis_penilaian' => 'UAS', 'bobot' => 0.4],
        ];

        foreach ($penilaian as $item) {
            DB::table('bobot_penilaian')->insert([
                'id_bobot_penilaian' => Str::uuid(),
                'jenis_penilaian' => $item['jenis_penilaian'],
                'bobot' => $item['bobot'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
