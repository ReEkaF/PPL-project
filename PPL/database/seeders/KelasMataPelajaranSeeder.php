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
        $tahunAjaran = tahun_ajaran::where('aktif', 1)->first() ?? tahun_ajaran::first();
        if (! $tahunAjaran) {
            $this->command->warn("No active academic year found.\n");

            return;
        }
        $kelasList = kelas::all();
        $hariList = hari::whereIn('nama_hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])->get();
        if ($hariList->isEmpty()) {
            $hariList = hari::all();
        }

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

        foreach ($assignments as $data) {
            $guru = Guru::where('username', $data['username'])->first()
                ?? Guru::where('nama_guru', $data['guru_nama'])->first()
                ?? Guru::where('nama_guru', 'LIKE', '%' . strtok($data['guru_nama'], ',') . '%')->first();

            $matpel = mata_pelajaran::where('nama_matpel', $data['mata_pelajaran'])->first();
            if ($guru && $matpel) {
                guru_mata_pelajaran::firstOrCreate([
                    'guru_id' => $guru->id_guru,
                    'matpel_id' => $matpel->id_matpel,
                ]);
            }
        }

        $hariCount = $hariList->count();
        $timeSlots = [
            ['07:30', '09:30'],
            ['10:00', '12:00'],
        ];

        foreach ($kelasList as $kelas) {
            foreach ($assignments as $index => $assignment) {
                $guru = Guru::where('username', $assignment['username'])->first()
                    ?? Guru::where('nama_guru', $assignment['guru_nama'])->first()
                    ?? Guru::where('nama_guru', 'LIKE', '%' . strtok($assignment['guru_nama'], ',') . '%')->first();

                $matpel = mata_pelajaran::where('nama_matpel', $assignment['mata_pelajaran'])->first();

                if ($guru && $matpel) {
                    $hariId = $hariCount > 0 ? $hariList[$index % $hariCount]->id_hari : null;
                    $slot = $timeSlots[$index % count($timeSlots)];

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
                            'waktu_mulai' => $slot[0],
                            'waktu_selesai' => $slot[1],
                        ]
                    );
                }
            }
        }
    }
}
