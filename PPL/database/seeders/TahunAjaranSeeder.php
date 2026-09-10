<?php

namespace Database\Seeders;

use App\Models\tahun_ajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tahun_ajaran::firstOrCreate(
            [
                'tahun_mulai' => '2024',
                'tahun_selesai' => '2025',
                'semester' => 1,
            ],
            [
                'id_tahun_ajaran' => (string) Str::uuid(),
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        tahun_ajaran::firstOrCreate(
            [
                'tahun_mulai' => '2024',
                'tahun_selesai' => '2025',
                'semester' => 2,
            ],
            [
                'id_tahun_ajaran' => (string) Str::uuid(),
                'aktif' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
