<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NilaiMatpelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mataPelajaranList = DB::table('mata_pelajaran')->get();
        $raporList = DB::table('rapor')->get();

        $feedbackNotes = [
            'Sangat baik dalam memahami konsep dasar dan terampil dalam penyelesaian soal analitis.',
            'Menunjukkan kemajuan yang signifikan. Pertahankan konsistensi belajar dan keaktifan di kelas.',
            'Mampu menguasai materi dengan sangat memuaskan, rajin berdiskusi, dan disiplin dalam tugas.',
            'Prestasi belajar sangat memuaskan. Tingkatkan daya nalar kritis untuk materi tingkat lanjut.',
            'Pemahaman konsep materi sudah baik. Disarankan lebih teliti dalam evaluasi perhitungan.',
            'Sangat tekun dan memiliki motivasi belajar tinggi. Terus pertahankan prestasimu.',
        ];

        foreach ($raporList as $rapor) {
            foreach ($mataPelajaranList as $matpel) {
                $exists = DB::table('nilai_matpel')
                    ->where('rapor_id', $rapor->id_rapor)
                    ->where('matpel_id', $matpel->id_matpel)
                    ->exists();

                if (!$exists) {
                    $score = rand(74, 96);
                    DB::table('nilai_matpel')->insert([
                        'id_nilai_matpel' => (string) Str::uuid(),
                        'matpel_id' => $matpel->id_matpel,
                        'rapor_id' => $rapor->id_rapor,
                        'nilai_rata_rata_matpel' => $score,
                        'pesan' => $feedbackNotes[array_rand($feedbackNotes)],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
