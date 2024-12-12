<?php

namespace Database\Seeders;

use App\Models\buku;
use App\Models\jenis_buku;
use App\Models\kategori_buku;
use App\Models\transaksi_peminjaman;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;

class PerpustakaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        function randomDate($startDate, $endDate)
        {
            // Mengonversi tanggal awal dan akhir ke timestamp
            $startTimestamp = strtotime($startDate);
            $endTimestamp = strtotime($endDate);

            // Mendapatkan timestamp acak di antara tanggal awal dan akhir
            $randomTimestamp = rand($startTimestamp, $endTimestamp);

            // Mengonversi timestamp acak ke format tanggal
            return date("Y-m-d H:i:s", $randomTimestamp);
        }

        // Generate unique IDs for each jenis_buku
        jenis_buku::firstOrCreate([
            'id_jenis_buku' => 1,
            'nama_jenis_buku' => 'Non-Paket'
        ]);
        
        jenis_buku::firstOrCreate([
            'id_jenis_buku' => 2,
            'nama_jenis_buku' => 'Paket'
        ]);
        // Pastikan kategori buku dimasukkan terlebih dahulu
        $kategori = ['Paket','Komik', 'Novel', 'Ensiklopedia', 'Kamus', 'Artikel', 'Jurnal', 'Biografi'];
        $ArrayCategory = [];
        
        // Masukkan kategori buku dan simpan UUID-nya
        foreach ($kategori as $kategoriName) {
            // Periksa apakah kategori dengan nama yang sama sudah ada
            $existingCategory = kategori_buku::where('nama_kategori', $kategoriName)->first();
        
            if (!$existingCategory) {
                // Jika belum ada, maka buat kategori baru
                $kategoriRecord = kategori_buku::create([
                    'id_kategori_buku' => Str::uuid(), // Menggunakan UUID untuk id_kategori_buku
                    'nama_kategori' => $kategoriName
                ]);
                $ArrayCategory[] = $kategoriRecord->id_kategori_buku; // Simpan UUID kategori yang baru
            }
        }
        
        // Buku manual 
        $bukuData = [
            // novel
            [
                'id_kategori_buku' => $ArrayCategory[2],
                'id_jenis_buku' => 1,
                'author_buku' => 'Tere Liye',
                'publisher_buku' => 'Gramedia Pustaka Utama',
                'judul_buku' => 'Hujan',
                'foto_buku' => 'images/Perpustakaan/foto_buku/hujan.jpg',
                'tahun_terbit' => 2019,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 15,
                'rak_buku' => 1,
                'harga_buku' => 95000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[2],
                'id_jenis_buku' => 1,
                'author_buku' => 'Andrea Hirata',
                'publisher_buku' => 'Bentang Pustaka',
                'judul_buku' => 'Laskar Pelangi',
                'foto_buku' => 'images/Perpustakaan/foto_buku/laskar_pelangi.png',
                'tahun_terbit' => 2005,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 20,
                'rak_buku' => 2,
                'harga_buku' => 120000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[2],
                'id_jenis_buku' => 1,
                'author_buku' => 'Pramoedya Ananta Toer',
                'publisher_buku' => 'Penerbit Hasta Mitra',
                'judul_buku' => 'Bumi Manusia',
                'foto_buku' => 'images/Perpustakaan/foto_buku/bumi_manusia.png',
                'tahun_terbit' => 1980,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 10,
                'rak_buku' => 3,
                'harga_buku' => 150000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[2],
                'id_jenis_buku' => 1,
                'author_buku' => 'Habiburrahman El Shirazy',
                'publisher_buku' => 'Mizan',
                'judul_buku' => 'Ayat-Ayat Cinta',
                'foto_buku' => 'images/Perpustakaan/foto_buku/ayat_ayat_cinta.jpg',
                'tahun_terbit' => 2004,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 18,
                'rak_buku' => 4,
                'harga_buku' => 105000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[2],
                'id_jenis_buku' => 1,
                'author_buku' => 'Dee Lestari',
                'publisher_buku' => 'Mizan',
                'judul_buku' => 'Perahu Kertas',
                'foto_buku' => 'images/Perpustakaan/foto_buku/perahu_kertas.png',
                'tahun_terbit' => 2009,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 12,
                'rak_buku' => 5,
                'harga_buku' => 110000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[2],
                'id_jenis_buku' => 1,
                'author_buku' => 'Dewi Lestari',
                'publisher_buku' => 'Gramedia Pustaka Utama',
                'judul_buku' => 'Supernova: Ksatria, Puteri, dan Bintang Jatuh',
                'foto_buku' => 'images/Perpustakaan/foto_buku/supernova.jpg',
                'tahun_terbit' => 2001,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 8,
                'rak_buku' => 6,
                'harga_buku' => 130000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[2],
                'id_jenis_buku' => 1,
                'author_buku' => 'Tere Liye',
                'publisher_buku' => 'Gramedia Pustaka Utama',
                'judul_buku' => 'Pulang',
                'foto_buku' => 'images/Perpustakaan/foto_buku/pulang.jpg',
                'tahun_terbit' => 2018,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 14,
                'rak_buku' => 7,
                'harga_buku' => 115000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[2],
                'id_jenis_buku' => 1,
                'author_buku' => 'Ruth Ware',
                'publisher_buku' => 'Penguin Books',
                'judul_buku' => 'The Death of Mrs. Westaway',
                'foto_buku' => 'images/Perpustakaan/foto_buku/death_of_mrs_westaway.jpg',
                'tahun_terbit' => 2018,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 9,
                'rak_buku' => 8,
                'harga_buku' => 140000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[2],
                'id_jenis_buku' => 1,
                'author_buku' => 'Moammar Emka',
                'publisher_buku' => 'Rajawali Pers',
                'judul_buku' => 'Jakarta Undercover',
                'foto_buku' => 'images/Perpustakaan/foto_buku/jakarta_undercover.jpg',
                'tahun_terbit' => 2004,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 20,
                'rak_buku' => 9,
                'harga_buku' => 170000
            ],
            // buku komik
            [
                'id_kategori_buku' => $ArrayCategory[1],
                'id_jenis_buku' => 1, // Jenis buku non-paket
                'author_buku' => 'Masashi Kishimoto',
                'publisher_buku' => 'Shueisha',
                'judul_buku' => 'Naruto: Volume 1',
                'foto_buku' => 'images/Perpustakaan/foto_buku/naruto_volume_1.jpg',
                'tahun_terbit' => 1999,
                'bahasa_buku' => 'Jepang',
                'stok_buku' => 15,
                'rak_buku' => 3,
                'harga_buku' => 50000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[1],
                'id_jenis_buku' => 1,
                'author_buku' => 'Eiichiro Oda',
                'publisher_buku' => 'Shueisha',
                'judul_buku' => 'One Piece: Volume 1',
                'foto_buku' => 'images/Perpustakaan/foto_buku/one_piece_volume_1.jpg',
                'tahun_terbit' => 1997,
                'bahasa_buku' => 'Jepang',
                'stok_buku' => 20,
                'rak_buku' => 4,
                'harga_buku' => 100000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[1],
                'id_jenis_buku' => 1,
                'author_buku' => 'Akira Toriyama',
                'publisher_buku' => 'Shueisha',
                'judul_buku' => 'Dragon Ball: Volume 1',
                'foto_buku' => 'images/Perpustakaan/foto_buku/dragon_ball_volume_1.jpg',
                'tahun_terbit' => 1984,
                'bahasa_buku' => 'Jepang',
                'stok_buku' => 10,
                'rak_buku' => 5,
                'harga_buku' => 120000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[1],
                'id_jenis_buku' => 1,
                'author_buku' => 'Tite Kubo',
                'publisher_buku' => 'Shueisha',
                'judul_buku' => 'Bleach: Volume 1',
                'foto_buku' => 'images/Perpustakaan/foto_buku/bleach_volume_1.jpg',
                'tahun_terbit' => 2001,
                'bahasa_buku' => 'Jepang',
                'stok_buku' => 18,
                'rak_buku' => 6,
                'harga_buku' => 95000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[1],
                'id_jenis_buku' => 1,
                'author_buku' => 'Hiro Mashima',
                'publisher_buku' => 'Kodansha',
                'judul_buku' => 'Fairy Tail: Volume 1',
                'foto_buku' => 'images/Perpustakaan/foto_buku/fairy_tail_volume_1.jpg',
                'tahun_terbit' => 2006,
                'bahasa_buku' => 'Jepang',
                'stok_buku' => 25,
                'rak_buku' => 7,
                'harga_buku' => 85000
            ],
            // buku kamus
            [
                'id_kategori_buku' => $ArrayCategory[4],
                'id_jenis_buku' => 1, // Jenis buku non-paket
                'author_buku' => 'John B. Carrol',
                'publisher_buku' => 'Oxford University Press',
                'judul_buku' => 'Oxford English Dictionary',
                'foto_buku' => 'images/Perpustakaan/foto_buku/oxford_english_dictionary.jpg',
                'tahun_terbit' => 2010,
                'bahasa_buku' => 'Inggris',
                'stok_buku' => 10,
                'rak_buku' => 1,
                'harga_buku' => 500000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[4],
                'id_jenis_buku' => 1,
                'author_buku' => 'Henry G. Liddell, Robert Scott',
                'publisher_buku' => 'Oxford University Press',
                'judul_buku' => 'Liddell-Scott Greek-English Lexicon',
                'foto_buku' => 'images/Perpustakaan/foto_buku/liddell_scott_greek_english_lexicon.jpg',
                'tahun_terbit' => 1996,
                'bahasa_buku' => 'Yunani-Inggris',
                'stok_buku' => 8,
                'rak_buku' => 2,
                'harga_buku' => 700000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[4],
                'id_jenis_buku' => 1,
                'author_buku' => 'M. Davidow',
                'publisher_buku' => 'Collins',
                'judul_buku' => 'Collins English Dictionary',
                'foto_buku' => 'images/Perpustakaan/foto_buku/collins_english_dictionary.jpg',
                'tahun_terbit' => 2008,
                'bahasa_buku' => 'Inggris',
                'stok_buku' => 15,
                'rak_buku' => 3,
                'harga_buku' => 350000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[4],
                'id_jenis_buku' => 1,
                'author_buku' => 'John C. Wells',
                'publisher_buku' => 'Cambridge University Press',
                'judul_buku' => 'Longman Pronunciation Dictionary',
                'foto_buku' => 'images/Perpustakaan/foto_buku/longman_pronunciation_dictionary.jpg',
                'tahun_terbit' => 2008,
                'bahasa_buku' => 'Inggris',
                'stok_buku' => 12,
                'rak_buku' => 4,
                'harga_buku' => 450000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[4],
                'id_jenis_buku' => 1,
                'author_buku' => 'Timberlake',
                'publisher_buku' => 'Cambridge University Press',
                'judul_buku' => 'Cambridge Phrasal Verbs Dictionary',
                'foto_buku' => 'images/Perpustakaan/foto_buku/cambridge_phrasal_verbs_dictionary.jpg',
                'tahun_terbit' => 2006,
                'bahasa_buku' => 'Inggris',
                'stok_buku' => 18,
                'rak_buku' => 5,
                'harga_buku' => 400000
            ],
            // buku Ensiklopedia
            [
                'id_kategori_buku' => $ArrayCategory[3],
                'id_jenis_buku' => 1, // Jenis buku non-paket
                'author_buku' => 'Columbia University',
                'publisher_buku' => 'Columbia University Press',
                'judul_buku' => 'Columbia Encyclopedia: Sixth Edition',
                'foto_buku' => 'images/Perpustakaan/foto_buku/columbia_encyclopedia.jpg',
                'tahun_terbit' => 2001,
                'bahasa_buku' => 'Inggris',
                'stok_buku' => 5,
                'rak_buku' => 1,
                'harga_buku' => 1200000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[3],
                'id_jenis_buku' => 1,
                'author_buku' => 'Editors of Encyclopaedia Britannica',
                'publisher_buku' => 'Encyclopædia Britannica, Inc.',
                'judul_buku' => 'Encyclopaedia Britannica: 15th Edition',
                'foto_buku' => 'images/Perpustakaan/foto_buku/encyclopaedia_britannica.jpg',
                'tahun_terbit' => 2010,
                'bahasa_buku' => 'Inggris',
                'stok_buku' => 8,
                'rak_buku' => 2,
                'harga_buku' => 1500000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[3],
                'id_jenis_buku' => 1,
                'author_buku' => 'National Geographic Society',
                'publisher_buku' => 'National Geographic',
                'judul_buku' => 'National Geographic Encyclopedia of Animals',
                'foto_buku' => 'images/Perpustakaan/foto_buku/national_geographic_animals.jpg',
                'tahun_terbit' => 2009,
                'bahasa_buku' => 'Inggris',
                'stok_buku' => 10,
                'rak_buku' => 3,
                'harga_buku' => 850000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[3],
                'id_jenis_buku' => 1,
                'author_buku' => 'Dorling Kindersley',
                'publisher_buku' => 'Dorling Kindersley',
                'judul_buku' => 'The DK Encyclopedia of Science',
                'foto_buku' => 'images/Perpustakaan/foto_buku/dk_encyclopedia_science.jpg',
                'tahun_terbit' => 2008,
                'bahasa_buku' => 'Inggris',
                'stok_buku' => 12,
                'rak_buku' => 4,
                'harga_buku' => 950000
            ],
            [
                'id_kategori_buku' => $ArrayCategory[3],
                'id_jenis_buku' => 1,
                'author_buku' => 'The Editors of Time-Life Books',
                'publisher_buku' => 'Time-Life Books',
                'judul_buku' => 'Time-Life Encyclopedia of the Arts',
                'foto_buku' => 'images/Perpustakaan/foto_buku/time_life_encyclopedia_arts.jpg',
                'tahun_terbit' => 1997,
                'bahasa_buku' => 'Inggris',
                'stok_buku' => 7,
                'rak_buku' => 5,
                'harga_buku' => 1100000
            ],
            // buku paket
            [
                'id_kategori_buku' => $ArrayCategory[0],
                'id_jenis_buku' => 2,
                'author_buku' => 'Sri Handayani Lestari, Victoriani Inabuy, Cece Sutia, Okky Fajar Tri Maryana, Budiyanti Dwi Hardanie',
                'publisher_buku' => 'Pusat Kurikulum dan Perbukuan, Balitbang, Kemdikbud',
                'judul_buku' => 'Buku Panduan Guru Pendidikan Kepercayaan Terhadap Tuhan Yang Maha Esa dan Budi Pekerti untuk SMP Kelas VII',
                'foto_buku' => 'images/Perpustakaan/foto_buku/paket1.jpg',
                'tahun_terbit' => 2022,
                'bahasa_buku' => 'Indonesia',
                'stok_buku' => 20,
                'rak_buku' => 9,
                'harga_buku' => 20000
            ]
        ];
        
        // Menyimpan data buku
        foreach ($bukuData as $buku) {
            buku::create(array_merge($buku, ['id_buku' => Str::uuid(), 'tgl_ditambahkan' => now()]));
        }
        
    }

    

}