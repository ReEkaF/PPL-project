<?php

namespace Database\Seeders;

use App\Models\kelas_mata_pelajaran;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all active kelas_mata_pelajaran (schedules)
        $kelasMapels = kelas_mata_pelajaran::with(['kelas.siswa'])->get();

        if ($kelasMapels->isEmpty()) {
            return;
        }

        // Generate 6 meetings per schedule across recent dates
        $startDate = Carbon::now()->subWeeks(6);

        foreach ($kelasMapels as $kelasMapel) {
            // Find students in this class
            $students = DB::table('kelas_siswas')
                ->where('id_kelas', $kelasMapel->kelas_id)
                ->pluck('id_siswa');

            if ($students->isEmpty()) {
                continue;
            }

            for ($i = 0; $i < 6; $i++) {
                $meetingDate = $startDate->copy()->addDays($i * 7);
                $isLatest = ($i === 5);

                $pertemuanId = (string) Str::uuid();

                // 1. Create Pertemuan
                DB::table('pertemuan')->insert([
                    'id_pertemuan' => $pertemuanId,
                    'kelas_mata_pelajaran_id' => $kelasMapel->id_kelas_mata_pelajaran,
                    'tanggal_pertemuan' => $meetingDate->format('Y-m-d'),
                    'qr_code' => 'SST-QR-' . strtoupper(Str::random(16)),
                    'status' => $isLatest ? 'Aktif' : 'Tidak Aktif',
                    'created_at' => $meetingDate,
                    'updated_at' => $meetingDate,
                ]);

                // 2. Create Absensi for all students in this class
                foreach ($students as $siswaId) {
                    // Realistic attendance distribution: 85% Hadir, 5% Izin, 5% Sakit, 5% Alpa
                    $rand = rand(1, 100);
                    if ($rand <= 85) {
                        $statusAbsensi = 'Hadir';
                    } elseif ($rand <= 90) {
                        $statusAbsensi = 'Izin';
                    } elseif ($rand <= 95) {
                        $statusAbsensi = 'Sakit';
                    } else {
                        $statusAbsensi = 'Alpa';
                    }

                    DB::table('absensi_siswa')->insert([
                        'id_absensi_siswa' => (string) Str::uuid(),
                        'siswa_id' => $siswaId,
                        'pertemuan_id' => $pertemuanId,
                        'status_absensi' => $statusAbsensi,
                        'created_at' => $meetingDate,
                        'updated_at' => $meetingDate,
                    ]);
                }
            }
        }
    }
}
