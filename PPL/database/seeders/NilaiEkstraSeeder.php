<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NilaiEkstraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $raporList = DB::table('rapor')->get();
        $ekskulList = DB::table('ekstrakurikuler')->get();

        if ($ekskulList->isEmpty()) {
            return;
        }

        $grades = ['A', 'A-', 'B+', 'A', 'A'];
        $notes = [
            'Sangat aktif, berdedikasi tinggi, dan menunjukkan jiwa kepemimpinan dalam kegiatan.',
            'Disiplin dalam menghadiri latihan rutin dan mampu bekerja sama dengan baik dalam tim.',
            'Menunjukkan bakat dan kemauan berkembang yang tinggi dalam setiap kegiatan ekstrakurikuler.',
            'Partisipasi sangat memuaskan, konsisten, dan berinisiatif tinggi membantu rekan regu.',
        ];

        foreach ($raporList as $rapor) {
            $takeCount = min(2, $ekskulList->count());
            $selected = $ekskulList->random($takeCount);

            foreach ($selected as $ekstra) {
                $exists = DB::table('nilai_ekstra')
                    ->where('rapor_id', $rapor->id_rapor)
                    ->where('ekstrakurikuler_id', $ekstra->id_ekstrakurikuler)
                    ->exists();

                if (!$exists) {
                    DB::table('nilai_ekstra')->insert([
                        'id_nilai_ekstra' => (string) Str::uuid(),
                        'ekstrakurikuler_id' => $ekstra->id_ekstrakurikuler,
                        'rapor_id' => $rapor->id_rapor,
                        'nilai_rata_rata_ekstra' => $grades[array_rand($grades)],
                        'pesan' => $notes[array_rand($notes)],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
