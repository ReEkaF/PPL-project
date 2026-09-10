<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\guru_mata_pelajaran;
use App\Models\mata_pelajaran;
use Illuminate\Database\Seeder;

class GuruMataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignments = [
            ['guru_nama' => 'Abdul Rahem Faqih', 'mata_pelajaran' => 'Matematika'],
            ['guru_nama' => 'Sabil Ahmad Hidayat', 'mata_pelajaran' => 'Bahasa Indonesia'],
            ['guru_nama' => 'Adi Prawono', 'mata_pelajaran' => 'Bahasa Inggris'],
            ['guru_nama' => 'Abdul Hijjah Akbarul Hidayatulloh', 'mata_pelajaran' => 'IPA'],
            ['guru_nama' => 'Rizkyan Dwi Prasetiawan', 'mata_pelajaran' => 'IPS'],
            ['guru_nama' => 'Niken Ning Pambudi', 'mata_pelajaran' => 'PKN'],
            ['guru_nama' => 'Nurul Maulydia IImami', 'mata_pelajaran' => 'Seni Budaya'],
            ['guru_nama' => 'Muhammad Ilham Zakaria', 'mata_pelajaran' => 'Pendidikan Agama'],
            ['guru_nama' => 'Noval', 'mata_pelajaran' => 'Pendidikan Jasmani'],
            ['guru_nama' => 'Ronggo', 'mata_pelajaran' => 'Bahasa Daerah'],
        ];

        foreach ($assignments as $assignment) {
            $guru = Guru::where('nama_guru', $assignment['guru_nama'])->first();
            $matpel = mata_pelajaran::where('nama_matpel', $assignment['mata_pelajaran'])->first();

            if ($guru && $matpel) {
                guru_mata_pelajaran::firstOrCreate([
                    'guru_id' => $guru->id_guru,
                    'matpel_id' => $matpel->id_matpel,
                ]);
            }
        }
    }
}
