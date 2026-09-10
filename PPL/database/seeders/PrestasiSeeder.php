<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = Siswa::all();
        if ($siswas->isEmpty()) {
            return;
        }

        $prestasiList = [
            [
                'nama' => 'Juara 1 Olimpiade Sains Nasional (OSN) Tingkat Kabupaten Bangkalan',
                'deskripsi' => 'Meraih medali emas dalam bidang kompetisi Ilmu Pengetahuan Alam (IPA) tingkat SMP se-Kabupaten Bangkalan.',
                'bukti' => 'sertifikat_osn_ipa.pdf',
                'status' => 1,
            ],
            [
                'nama' => 'Juara 2 Lomba Cerdas Cermat Bahasa Indonesia Tingkat Karesidenan Madura',
                'deskripsi' => 'Berhasil menduduki peringkat kedua dalam kompetisi kebahasaan dan sastra tingkat SMP se-Madura.',
                'bukti' => 'sertifikat_lcc_bahasa.pdf',
                'status' => 1,
            ],
            [
                'nama' => 'Juara 1 Turnamen Futsal Pelajar SMP Piala Dispora Bangkalan',
                'deskripsi' => 'Mewakili tim futsal sekolah dan sukses mengantarkan sekolah meraih juara pertama.',
                'bukti' => 'piagam_futsal_dispora.pdf',
                'status' => 1,
            ],
            [
                'nama' => 'Juara 3 Festival Seni Tari Tradisional Tingkat Pelajar Jawa Timur',
                'deskripsi' => 'Menampilkan tari kreasi tradisional Madura dan berhasil meraih juara ketiga pada ajang seni provinsi.',
                'bukti' => 'sertifikat_seni_tari.pdf',
                'status' => 1,
            ],
            [
                'nama' => 'Medali Emas Kejuaraan Pencak Silat Pelajar Antar-Perguruan',
                'deskripsi' => 'Meraih podium pertama pada kategori tanding putra kelas C pra-remaja.',
                'bukti' => 'piagam_pencak_silat.pdf',
                'status' => 1,
            ],
            [
                'nama' => 'Juara 2 Lomba Karya Tulis Ilmiah Remaja (KIR) Tingkat SMP',
                'deskripsi' => 'Menyusun penelitian lingkungan tentang pengolahan limbah pesisir Kamal.',
                'bukti' => 'sertifikat_kir_lingkungan.pdf',
                'status' => 1,
            ],
            [
                'nama' => 'Juara 1 Lomba Pidato Bahasa Inggris (English Speech Contest)',
                'deskripsi' => 'Menyampaikan pidato bertema "Youth in Digital Era" dengan skor kefasihan tertinggi.',
                'bukti' => 'sertifikat_english_speech.pdf',
                'status' => 1,
            ],
            [
                'nama' => 'Juara Harapan 1 Lomba Paduan Suara Pelajar SMP',
                'deskripsi' => 'Menampilkan lagu daerah dan lagu nasional dalam festival paduan suara kabupaten.',
                'bukti' => 'piagam_paduan_suara.pdf',
                'status' => 0, // Pending validation for staff testing
            ],
            [
                'nama' => 'Juara 2 Kompetisi Robotika Garis (Line Follower) Pelajar',
                'deskripsi' => 'Merancang dan memprogram robot mikrokontroler dengan catatan waktu tercepat kedua.',
                'bukti' => 'sertifikat_robotika.pdf',
                'status' => 0, // Pending validation for staff testing
            ],
            [
                'nama' => 'Juara 1 Lomba Story Telling Tingkat SMP Se-Kabupaten Bangkalan',
                'deskripsi' => 'Menampilkan cerita rakyat Madura dalam bahasa Inggris dengan ekspresi terbaik.',
                'bukti' => 'sertifikat_story_telling.pdf',
                'status' => 1,
            ],
        ];

        foreach ($prestasiList as $index => $item) {
            $siswa = $siswas[$index % $siswas->count()];

            DB::table('prestasi')->insert([
                'id_prestasi' => (string) Str::uuid(),
                'siswa_id' => $siswa->id_siswa,
                'nama_prestasi' => $item['nama'],
                'bukti_prestasi' => $item['bukti'],
                'deskripsi_prestasi' => $item['deskripsi'],
                'status_prestasi' => $item['status'],
                'created_at' => now()->subDays(rand(5, 90)),
                'updated_at' => now(),
            ]);
        }
    }
}
