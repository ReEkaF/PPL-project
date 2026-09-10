<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use App\Models\Guru;
use App\Models\HistoriInventaris;
use App\Models\InventarisEkstrakurikuler;
use App\Models\LaporanPenilaianEkstrakurikuler;
use App\Models\PenilaianEkstrakurikuler;
use App\Models\PengurusEkstra;
use App\Models\PostingEkstrakurikuler;
use App\Models\PrestasiEkstrakurikuler;
use App\Models\RegistrasiEkstrakurikuler;
use App\Models\Siswa;
use App\Models\tahun_ajaran;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pembinas = Guru::where('role_guru', 'pembina')->get();
        if ($pembinas->isEmpty()) {
            $pembinas = Guru::all();
        }

        $pengurusSiswa = Siswa::where('role_siswa', 'pengurus')->get();
        $regularSiswa = Siswa::where('role_siswa', 'siswa')->get();
        $tahunAjaranAktif = tahun_ajaran::where('aktif', 1)->value('id_tahun_ajaran')
            ?? tahun_ajaran::first()?->id_tahun_ajaran;

        $ekskulCatalog = [
            [
                'nama' => 'Pramuka (Praja Muda Karana)',
                'deskripsi' => 'Membentuk kepribadian mandiri, disiplin, berjiwa kepemimpinan, kepanduan, dan peduli sesama serta lingkungan alam.',
                'gambar' => 'pramuka.jpg',
                'status' => 'buka',
                'inventaris' => [
                    ['nama' => 'Tenda Regu Dome Kapasitas 6 Orang', 'stok' => 12],
                    ['nama' => 'Tongkat Pramuka Kayu Jati', 'stok' => 50],
                    ['nama' => 'Tali Prusit & Tambang Pramuka 10m', 'stok' => 30],
                ],
                'prestasi' => 'Juara Umum Jambore Ranting Pramuka Penggalang Kecamatan Kamal 2024',
            ],
            [
                'nama' => 'Palang Merah Remaja (PMR)',
                'deskripsi' => 'Mengembangkan keterampilan pertolongan pertama (PP), kesiapsiagaan bencana, donor darah, dan bakti sosial kemanusiaan.',
                'gambar' => 'pmr.jpg',
                'status' => 'buka',
                'inventaris' => [
                    ['nama' => 'Tandu Lipat Standar PMI', 'stok' => 4],
                    ['nama' => 'Kotak P3K Lengkap Obat Pertolongan Pertama', 'stok' => 8],
                    ['nama' => 'Spalk & Bidai Fraktur Tulang', 'stok' => 10],
                ],
                'prestasi' => 'Juara 1 Lomba Pertolongan Pertama (PP) Jumbara PMR Madya Tingkat Kabupaten',
            ],
            [
                'nama' => 'Paskibra (Pasukan Pengibar Bendera)',
                'deskripsi' => 'Melatih ketahanan fisik, baris-berbaris formal (PBB), kedisiplinan tinggi, dan etika kecintaan tanah air Indonesia.',
                'gambar' => 'paskibra.jpg',
                'status' => 'buka',
                'inventaris' => [
                    ['nama' => 'Bendera Merah Putih Upacara 2x3m', 'stok' => 5],
                    ['nama' => 'Sepatu PDU Paskibra Kulit Putih', 'stok' => 20],
                    ['nama' => 'Sabuk & Sarung Tangan Putih Resmi', 'stok' => 25],
                ],
                'prestasi' => 'Juara 2 Lomba Formasi Baris-Berbaris (LKBB) Pelajar SMP se-Madura',
            ],
            [
                'nama' => 'Futsal & Sepak Bola',
                'deskripsi' => 'Pembinaan bakat olahraga sepak bola mini, teknik dasar dribbling, passing, strategi tanding, dan sportivitas tinggi.',
                'gambar' => 'futsal.jpg',
                'status' => 'buka',
                'inventaris' => [
                    ['nama' => 'Bola Futsal Molten Size 4 Standar Match', 'stok' => 10],
                    ['nama' => 'Rompi Latihan Tim (Merah & Hijau)', 'stok' => 24],
                    ['nama' => 'Cone Mangkuk Latihan Kelincahan', 'stok' => 40],
                ],
                'prestasi' => 'Juara 1 Turnamen Futsal Antar-SMP Piala Dispora Bangkalan',
            ],
            [
                'nama' => 'Bola Basket',
                'deskripsi' => 'Melatih teknik bermain bola basket, kerja sama tim (teamwork), ketahanan kardio, dan keikutsertaan kompetisi pelajar.',
                'gambar' => 'basket.jpg',
                'status' => 'buka',
                'inventaris' => [
                    ['nama' => 'Bola Basket Molten GG7X Standar', 'stok' => 8],
                    ['nama' => 'Pompa Bola Manual High Pressure', 'stok' => 3],
                    ['nama' => 'Jaring Ring Basket Nylon', 'stok' => 4],
                ],
                'prestasi' => 'Semifinalis Turnamen DBL Junior Exhibition Bangkalan',
            ],
            [
                'nama' => 'Seni Tari Tradisional',
                'deskripsi' => 'Melestarikan seni kebudayaan tari tradisional Madura dan Nusantara, memperhalus gerak rasa dan estetika panggung.',
                'gambar' => 'tari.jpg',
                'status' => 'buka',
                'inventaris' => [
                    ['nama' => 'Set Kostum Tari Tradisional Madura', 'stok' => 10],
                    ['nama' => 'Sampur Tari Sutra Pelangi', 'stok' => 20],
                    ['nama' => 'Sound Portable Wireless Bluetooth', 'stok' => 2],
                ],
                'prestasi' => 'Penyaji Tari Terbaik Festival Tari Kreasi Pelajar Jawa Timur',
            ],
            [
                'nama' => 'Paduan Suara & Musik',
                'deskripsi' => 'Mempelajari teknik vokal paduan suara, harmonisasi suara, aransemen lagu daerah dan nasional untuk upacara dan lomba.',
                'gambar' => 'musik.jpg',
                'status' => 'buka',
                'inventaris' => [
                    ['nama' => 'Keyboard Yamaha PSR-SX Seri Pendidikan', 'stok' => 1],
                    ['nama' => 'Microphone Dynamic Shure SM58', 'stok' => 4],
                    ['nama' => 'Stand Partitur Musik Besi', 'stok' => 8],
                ],
                'prestasi' => 'Juara 3 Lomba Paduan Suara Lagu Kebangsaan Kabupaten Bangkalan',
            ],
            [
                'nama' => 'KIR (Karya Ilmiah Remaja) & Robotika',
                'deskripsi' => 'Wadah penelitian sains terapan, penulisan karya ilmiah remaja, eksplorasi mikrokontroler Arduino, dan coding robotika.',
                'gambar' => 'robotika.jpg',
                'status' => 'buka',
                'inventaris' => [
                    ['nama' => 'Kit Starter Robot Line Follower Arduino Uno', 'stok' => 6],
                    ['nama' => 'Solder Listrik 60W & Standar Keselamatan', 'stok' => 5],
                    ['nama' => 'Sensor Ultrasonik HC-SR04 & Motor Driver', 'stok' => 15],
                ],
                'prestasi' => 'Juara 2 Kompetisi Inovasi Sains Terapan Pelajar SMP',
            ],
        ];

        foreach ($ekskulCatalog as $index => $item) {
            $pembina = $pembinas[$index % $pembinas->count()];
            $idEkstra = (string) Str::uuid();

            // 1. Create Ekstrakurikuler
            Ekstrakurikuler::create([
                'id_ekstrakurikuler' => $idEkstra,
                'guru_id' => $pembina->id_guru,
                'nama_ekstrakurikuler' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'gambar' => $item['gambar'],
                'status' => $item['status'],
                'tgl_mulai_pendaftaran' => ($item['status'] === 'buka') ? Carbon::now()->subDays(3) : Carbon::now()->subMonths(2),
                'tgl_selesai_pendaftaran' => ($item['status'] === 'buka') ? Carbon::now()->addDays(20) : Carbon::now()->subMonth(),
            ]);

            // 2. Assign Student Leaders (Pengurus)
            $idPengurusEkstra = (string) Str::uuid();
            if ($pengurusSiswa->isNotEmpty()) {
                $leader = $pengurusSiswa[$index % $pengurusSiswa->count()];
                PengurusEkstra::create([
                    'id_pengurus_ekstra' => $idPengurusEkstra,
                    'id_ekstrakurikuler' => $idEkstra,
                    'id_siswa' => $leader->id_siswa,
                ]);
            }

            // 3. Register Members
            if ($regularSiswa->isNotEmpty()) {
                for ($s = 0; $s < 3; $s++) {
                    $student = $regularSiswa[($index * 2 + $s) % $regularSiswa->count()];
                    RegistrasiEkstrakurikuler::create([
                        'id_registrasi' => (string) Str::uuid(),
                        'id_siswa' => $student->id_siswa,
                        'id_ekstrakurikuler' => $idEkstra,
                        'riwayat_penyakit' => ($s === 1) ? 'Asma ringan' : 'Tidak ada',
                        'alasan' => 'Ingin mengembangkan minat dan bakat dalam bidang ' . $item['nama'],
                        'no_ortu' => '081234567' . rand(100, 999),
                        'status' => ($s === 2) ? 'menunggu' : 'diterima',
                        'tgl_registrasi' => Carbon::now()->subDays(rand(10, 60)),
                    ]);

                    // If accepted, add evaluation report & grade
                    if ($s !== 2 && $tahunAjaranAktif) {
                        $idLaporan = (string) Str::uuid();
                        LaporanPenilaianEkstrakurikuler::create([
                            'id_laporan' => $idLaporan,
                            'id_siswa' => $student->id_siswa,
                            'id_ekstrakurikuler' => $idEkstra,
                            'isi_laporan' => 'Siswa menunjukkan antusiasme dan komitmen yang sangat baik dalam kegiatan ' . $item['nama'] . '.',
                        ]);

                        PenilaianEkstrakurikuler::create([
                            'id_penilaian_ekstrakurikuler' => (string) Str::uuid(),
                            'id_ekstrakurikuler' => $idEkstra,
                            'id_siswa' => $student->id_siswa,
                            'id_tahun_ajaran' => $tahunAjaranAktif,
                            'id_laporan' => $idLaporan,
                            'penilaian' => collect(['A', 'B', 'A'])->random(),
                            'tgl_penilaian' => Carbon::now()->subDays(rand(1, 15)),
                        ]);
                    }
                }
            }

            // 4. Inventaris Ekstrakurikuler
            foreach ($item['inventaris'] as $inv) {
                $idInventaris = (string) Str::uuid();
                InventarisEkstrakurikuler::create([
                    'id_inventaris' => $idInventaris,
                    'id_ekstrakurikuler' => $idEkstra,
                    'nama_barang' => $inv['nama'],
                    'stok' => $inv['stok'],
                ]);

                // Create borrowing history
                HistoriInventaris::create([
                    'id_histori' => (string) Str::uuid(),
                    'id_inventaris' => $idInventaris,
                    'keterangan' => 'Peminjaman perlengkapan untuk kegiatan latihan rutin regu',
                    'jumlah' => 2,
                    'histori_keluar' => Carbon::now()->subDays(rand(5, 20)),
                    'histori_masuk' => Carbon::now()->subDays(rand(1, 4)),
                ]);
            }

            // 5. Prestasi Ekstrakurikuler
            PrestasiEkstrakurikuler::create([
                'id_prestasi' => (string) Str::uuid(),
                'id_ekstrakurikuler' => $idEkstra,
                'judul' => $item['prestasi'],
                'deskripsi' => 'Raihan prestasi membanggakan pada kompetisi resmi tingkat pelajar.',
                'gambar' => 'piala_ekskul.jpg',
            ]);

            // 6. Posting Ekstrakurikuler (School news bulletin)
            if ($pengurusSiswa->isNotEmpty()) {
                PostingEkstrakurikuler::create([
                    'id_posting' => (string) Str::uuid(),
                    'id_ekstrakurikuler' => $idEkstra,
                    'id_pengurus' => $idPengurusEkstra,
                    'judul' => 'Agenda Kegiatan Terpadu ' . $item['nama'],
                    'deskripsi' => 'Ekstrakurikuler ' . $item['nama'] . ' SMP Negeri 2 Kamal aktif menyelenggarakan latihan rutin setiap pekan demi memupuk karakter positif dan keterampilan nyata siswa.',
                    'gambar' => $item['gambar'],
                    'tgl_uploud' => Carbon::now()->subDays(rand(3, 30)),
                ]);
            }
        }
    }
}
