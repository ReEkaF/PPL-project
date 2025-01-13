<?php

namespace Database\Seeders;

use App\Models\kelas;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = ['A', 'B', 'C'];
        for ($i = 7; $i <= 9; $i++) {
            foreach ($kelas as $kelasItem) {
                $idKelas = Str::uuid();
                kelas::create([
                    'id_kelas' => $idKelas,
                    'nama_kelas' => $i . $kelasItem,
                ]);
            }
        }
    }
    
}
