<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Executes all module seeders in logical dependency order.
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai Seeding Terpadu Seluruh Modul Sistem Sekolah (SMPN 2 Kamal)...');

        $seeders = [
            // 1. Akun Civitas Akademika (Superadmin, Staff Akademik, Staff Perpus, Guru, Siswa)
            AkunSeeder::class,

            // 2. Data Induk Akademik & Jadwal
            TahunAjaranSeeder::class,
            KelasSeeder::class,
            KelasSiswaSeeder::class,
            MataPelajaranSeeder::class,
            GuruMataPelajaranSeeder::class,
            HariSeeder::class,
            KelasMataPelajaranSeeder::class,

            // 3. Modul Pertemuan & Presensi Real-Time
            AbsensiSeeder::class,

            // 4. Modul Pembelajaran LMS (Topik, Materi, Tugas & Pengumpulan)
            TopikTugasMateriSeeder::class,
            PengumpulanTugasSiswaSeeder::class,

            // 5. Modul Evaluasi CBT & Ujian Online
            UjianSeeder::class,

            // 6. Modul Ekstrakurikuler & Organisasi Siswa
            EkstrakurikulerSeeder::class,

            // 7. Modul Prestasi Akademik & Non-Akademik
            PrestasiSeeder::class,

            // 8. Modul Perpustakaan & Sirkulasi Buku
            PerpustakaanSeeder::class,
            TransaksiPeminjamanBukuSeeder::class,

            // 9. Modul Penilaian & E-Rapor Terpadu
            BobotGradesSeeder::class,
            BobotPenilaianSeeder::class,
            RaporSeeder::class,
        ];

        foreach ($seeders as $seederClass) {
            $name = class_basename($seederClass);
            $this->command->comment("📦 Menjalankan [{$name}]...");
            $this->call($seederClass);
        }

        $this->command->info('✅ Seluruh modul sistem telah berhasil di-seed dengan data realistis!');
    }
}
