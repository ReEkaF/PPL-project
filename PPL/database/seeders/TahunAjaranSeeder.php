<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\tahun_ajaran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tahun_ajaran::create([
            'id_tahun_ajaran' => Str::uuid(),
            'tahun_mulai' => '2024',
            'tahun_selesai' => '2025',
            'semester' => 1,
            'aktif' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        tahun_ajaran::create([
            'id_tahun_ajaran' => Str::uuid(),
            'tahun_mulai' => '2024',
            'tahun_selesai' => '2025',
            'semester' => 2,
            'aktif' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
