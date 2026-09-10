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
            ['username' => 'faqih', 'guru_nama' => 'Abdul Rahem Faqih, S.Pd.', 'mata_pelajaran' => 'Matematika'],
            ['username' => 'sabil', 'guru_nama' => 'Sabil Ahmad Hidayat, S.Pd.', 'mata_pelajaran' => 'Bahasa Indonesia'],
            ['username' => 'adiprawono', 'guru_nama' => 'Adi Prawono, S.Pd., M.Ed.', 'mata_pelajaran' => 'Bahasa Inggris'],
            ['username' => 'akbar', 'guru_nama' => 'Abdul Hijjah Akbarul, S.Si.', 'mata_pelajaran' => 'IPA'],
            ['username' => 'rizkyan', 'guru_nama' => 'Rizkyan Dwi Prasetiawan, S.Pd.', 'mata_pelajaran' => 'IPS'],
            ['username' => 'niken', 'guru_nama' => 'Niken Ning Pambudi, S.Pd.', 'mata_pelajaran' => 'PKN'],
            ['username' => 'maulydia', 'guru_nama' => 'Nurul Maulydia Imami, S.Sn.', 'mata_pelajaran' => 'Seni Budaya'],
            ['username' => 'ilham', 'guru_nama' => 'Muhammad Ilham Zakaria, S.Pd.I.', 'mata_pelajaran' => 'Pendidikan Agama'],
            ['username' => 'noval', 'guru_nama' => 'Noval Firdaus, S.Or.', 'mata_pelajaran' => 'Pendidikan Jasmani'],
            ['username' => 'ronggo', 'guru_nama' => 'Ronggo Warsito, S.Pd.', 'mata_pelajaran' => 'Bahasa Daerah'],
        ];

        foreach ($assignments as $assignment) {
            $guru = Guru::where('username', $assignment['username'])->first()
                ?? Guru::where('nama_guru', $assignment['guru_nama'])->first()
                ?? Guru::where('nama_guru', 'LIKE', '%' . strtok($assignment['guru_nama'], ',') . '%')->first();

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
