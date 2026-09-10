<?php

namespace Database\Seeders;

use App\Models\kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                kelas::firstOrCreate(
                    ['nama_kelas' => $i.$kelasItem],
                    ['id_kelas' => (string) Str::uuid()]
                );
            }
        }
    }
}
