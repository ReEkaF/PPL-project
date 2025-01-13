<?php

namespace Database\Seeders;

use App\Models\kelas_mata_pelajaran;
use App\Models\KelasSiswa;
use App\Models\pengumpulan_tugas;
use App\Models\tugas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengumpulanTugasSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasSiswaList = KelasSiswa::whereHas('tahunajaran', function ($query) {
            $query->where('aktif', 1);
        })->get();
        // dd($kelasSiswaList);

        $totalSteps = $kelasSiswaList->count();
        $this->command->getOutput()->progressStart($totalSteps);

        foreach ($kelasSiswaList as $kelasSiswa) {
            // ambil kelas mata pelajaran
            $kelasMataPelajaranList = kelas_mata_pelajaran::where('kelas_id', $kelasSiswa->id_kelas)->get();

            foreach ($kelasMataPelajaranList as $kelasMataPelajaran) {
                // ambil semua tugas terkait dengan kelas matapelajaran
                $tugasList = tugas::where('kelas_mata_pelajaran_id', $kelasMataPelajaran->id_kelas_mata_pelajaran)->get();

                foreach ($tugasList as $tugas) {
                    pengumpulan_tugas::create([
                        'tugas_id' => $tugas->id_tugas,
                        'siswa_id' => $kelasSiswa->id_siswa,
                        'status' => 'diserahkan',
                        'tanggal_pengumpulan' => now(),
                        'nilai' => rand(0, 100),
                        'komentar' => 'Tugas ini dikerjakan dengan baik',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
    }
}
