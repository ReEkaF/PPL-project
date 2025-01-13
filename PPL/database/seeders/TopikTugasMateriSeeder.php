<?php

namespace Database\Seeders;

use App\Models\kelas_mata_pelajaran;
use Illuminate\Database\Seeder;
use App\Models\Topik;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\notifikasi_sistem;
use Faker\Factory as Faker;

class TopikTugasMateriSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Retrieve all kelas_mata_pelajaran records
        $kelasMataPelajaranRecords = kelas_mata_pelajaran::all();

        foreach ($kelasMataPelajaranRecords as $kelas) {
            $namaMataPelajaran = $kelas->mataPelajaran->nama_matpel;
            $namaKelas = $kelas->kelas->nama_kelas;
            // For each kelas_mata_pelajaran, create 3 topik entries
            for ($i = 1; $i <= 2; $i++) {
                $topik = Topik::create([
                    'mata_pelajaran_id' => $kelas->mata_pelajaran_id,
                    'judul_topik' => "Bab $i $namaMataPelajaran - $namaKelas",
                    'kelas_mata_pelajaran_id' => $kelas->id_kelas_mata_pelajaran,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                for ($j = 1; $j <= 2; $j++) {
                    $materi = Materi::create([
                        'judul_materi' => "Materi $j untuk Bab $i  - $namaMataPelajaran - $namaKelas",
                        'topik_id' => $topik->id_topik,
                        'deskripsi' => $faker->paragraphs(3, true),
                        'kelas_mata_pelajaran_id' => $kelas->id_kelas_mata_pelajaran,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'status' => 1,
                    ]);

                    // Retrieve all siswa records associated with the kelas
                    $siswaRecords = $kelas->kelas->siswa;

                    foreach ($siswaRecords as $siswa) {
                        notifikasi_sistem::create([
                            'materi_id' => $materi->id_materi,
                            'siswa_id' => $siswa->id_siswa,
                            'status' => 0,
                        ]);
                    }
                }

                // For each topik, create 2 tugas entries
                for ($k = 1; $k <= 2; $k++) {
                    Tugas::create([
                        'judul' => "Tugas $k untuk Bab $i - $namaMataPelajaran - $namaKelas",
                        'deskripsi' => $faker->paragraphs(3, true),
                        'topik_id' => $topik->id_topik,
                        'kelas_mata_pelajaran_id' => $kelas->id_kelas_mata_pelajaran,
                        'deadline' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
