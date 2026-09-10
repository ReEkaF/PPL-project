<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\guru_mata_pelajaran;
use App\Models\hari;
use App\Models\kelas;
use App\Models\kelas_mata_pelajaran;
use App\Models\mata_pelajaran;
use App\Models\tahun_ajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KelasMataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaran = tahun_ajaran::where('aktif', 1)->first();
        if (! $tahunAjaran) {
            echo "No active academic year found.\n";

            return;
        }
        $kelasList = kelas::all();
        $hariList = hari::all();

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

        foreach ($assignments as $data) {
            $guru = Guru::where('nama_guru', $data['guru_nama'])->first();
            $matpel = mata_pelajaran::where('nama_matpel', $data['mata_pelajaran'])->first();
            if ($guru && $matpel) {
                guru_mata_pelajaran::firstOrCreate([
                    'guru_id' => $guru->id_guru,
                    'matpel_id' => $matpel->id_matpel,
                ]);
            }
        }

        $hariCount = $hariList->count();

        foreach ($kelasList as $kelas) {
            foreach ($assignments as $index => $assignment) {
                $guru = Guru::where('nama_guru', $assignment['guru_nama'])->first();
                $matpel = mata_pelajaran::where('nama_matpel', $assignment['mata_pelajaran'])->first();

                if ($guru && $matpel) {
                    $hariId = $hariCount > 0 ? $hariList[$index % $hariCount]->id_hari : null;
                    kelas_mata_pelajaran::firstOrCreate(
                        [
                            'kelas_id' => $kelas->id_kelas,
                            'mata_pelajaran_id' => $matpel->id_matpel,
                            'tahun_ajaran_id' => $tahunAjaran->id_tahun_ajaran,
                        ],
                        [
                            'id_kelas_mata_pelajaran' => (string) Str::uuid(),
                            'guru_id' => $guru->id_guru,
                            'hari_id' => $hariId,
                            'waktu_mulai' => '08:00',
                            'waktu_selesai' => '10:00',
                        ]
                    );
                }
            }
        }
    }
}
