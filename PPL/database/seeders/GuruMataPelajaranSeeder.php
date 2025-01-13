<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\guru_mata_pelajaran;
use Illuminate\Support\Str;
use App\Models\mata_pelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuruMataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignments = [
            ['guru_nama' => 'Agus Santoso', 'mata_pelajaran' => 'Matematika'],
            ['guru_nama' => 'Agus Santoso', 'mata_pelajaran' => 'IPA'],
            ['guru_nama' => 'Siti Aisyah', 'mata_pelajaran' => 'Bahasa Indonesia'],
            ['guru_nama' => 'Siti Aisyah', 'mata_pelajaran' => 'Bahasa Inggris'],
            ['guru_nama' => 'Budi Setiawan', 'mata_pelajaran' => 'Bahasa Inggris'],
            ['guru_nama' => 'Budi Setiawan', 'mata_pelajaran' => 'Bahasa Indonesia'],
            ['guru_nama' => 'Eka Pratama', 'mata_pelajaran' => 'IPA'],
            ['guru_nama' => 'Eka Pratama', 'mata_pelajaran' => 'Matematika'],
            ['guru_nama' => 'Dewi Kartika', 'mata_pelajaran' => 'IPS'],
            ['guru_nama' => 'Dewi Kartika', 'mata_pelajaran' => 'PKN'],
            ['guru_nama' => 'Rini Marlina', 'mata_pelajaran' => 'PKN'],
            ['guru_nama' => 'Rini Marlina', 'mata_pelajaran' => 'IPS'],
            ['guru_nama' => 'Fajar Hidayat', 'mata_pelajaran' => 'Seni Budaya'],
            ['guru_nama' => 'Fajar Hidayat', 'mata_pelajaran' => 'Prakarya'],
            ['guru_nama' => 'Sri Wahyuni', 'mata_pelajaran' => 'Pendidikan Agama'],
            ['guru_nama' => 'Sri Wahyuni', 'mata_pelajaran' => 'Pendidikan Jasmani'],
            ['guru_nama' => 'Yoga Aditya', 'mata_pelajaran' => 'Pendidikan Jasmani'],
            ['guru_nama' => 'Yoga Aditya', 'mata_pelajaran' => 'Pendidikan Agama'],
            ['guru_nama' => 'Rahmawati Anisa', 'mata_pelajaran' => 'TIK'],
            ['guru_nama' => 'Rahmawati Anisa', 'mata_pelajaran' => 'Pendidikan Agama'],
            ['guru_nama' => 'Andi Prakoso', 'mata_pelajaran' => 'Prakarya'],
            ['guru_nama' => 'Andi Prakoso', 'mata_pelajaran' => 'Seni Budaya'],
            ['guru_nama' => 'Lina Kusuma', 'mata_pelajaran' => 'Bahasa Madura'],
            ['guru_nama' => 'Lina Kusuma', 'mata_pelajaran' => 'Bahasa Indonesia'],
        ];

        foreach ($assignments as $assignment) {
            $guru = Guru::where('nama_guru', $assignment['guru_nama'])->first();
            $matpel = mata_pelajaran::where('nama_matpel', $assignment['mata_pelajaran'])->first();

            if ($guru && $matpel) {
                guru_mata_pelajaran::create([
                    'guru_id' => $guru->id_guru,
                    'matpel_id' => $matpel->id_matpel,
                ]);
            }
        }

    }
}
