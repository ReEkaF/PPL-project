<?php

namespace Database\Seeders;

use App\Models\Nilai_mapel;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RaporSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->call([
            SiswaSeeder::class,
            GuruSeeder::class,
            BobotGradesSeeder::class,
            BobotPenilaianSeeder::class,
            TahunAjaranSeeder::class,
            KelasMataPelajaranSeeder::class,
            TopikTugasMateriSeeder::class,
            PengumpulanTugasSiswaSeeder::class,
            NilaiMatpelSeeder::class,
            NilaiEkstraSeeder::class
        ]);
         // Mendapatkan tahun ajaran aktif atau yang pertama di tabel
         $tahunAjaran = DB::table('tahun_ajaran')->where('aktif', true)->first();

         // Jika tidak ada tahun ajaran yang aktif, ambil tahun ajaran pertama sebagai alternatif
         if (!$tahunAjaran) {
             $tahunAjaran = DB::table('tahun_ajaran')->first();
         }

         // Mendapatkan semua siswa
         $siswaList = DB::table('siswa')->get();

         // Memasukkan setiap siswa ke tabel rapor untuk tahun ajaran yang dipilih
         foreach ($siswaList as $siswa) {
             DB::table('rapor')->insert([
                'id_rapor' => Str::uuid(),
                'siswa_id' => $siswa->id_siswa,
                'tahun_ajaran_id' => $tahunAjaran->id_tahun_ajaran,
                'created_at' => now(),
                'updated_at' => now(),
             ]);
         }
    }
}
