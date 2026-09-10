<?php

namespace Database\Seeders;

use App\Models\kelas_mata_pelajaran;
use App\Models\topik;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topiks = topik::with(['kelasMataPelajaran'])->get();

        if ($topiks->isEmpty()) {
            return;
        }

        // Realistic question banks by subject keywords
        $sampleQuestions = [
            'Matematika' => [
                [
                    'soal' => 'Hasil dari (-12) + 20 × (-2) - (-15) adalah...',
                    'a' => '-37', 'b' => '-47', 'c' => '37', 'd' => '47',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Bentuk sederhana dari 4x + 12y - 10 + 8x - 5y - 7 adalah...',
                    'a' => '12x + 7y - 17', 'b' => '12x - 7y - 17', 'c' => '12x + 17y - 17', 'd' => '4x + 7y - 3',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Jika x = 4 dan y = -2, maka nilai dari 3x² - 2y + 5 adalah...',
                    'a' => '47', 'b' => '53', 'c' => '57', 'd' => '49',
                    'kunci' => 'C',
                ],
                [
                    'soal' => 'Sebuah segitiga memiliki alas 14 cm dan tinggi 10 cm. Luas segitiga tersebut adalah...',
                    'a' => '70 cm²', 'b' => '140 cm²', 'c' => '35 cm²', 'd' => '24 cm²',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Himpunan penyelesaian dari 2x - 5 = 11 untuk x bilangan bulat adalah...',
                    'a' => '{6}', 'b' => '{8}', 'c' => '{7}', 'd' => '{9}',
                    'kunci' => 'B',
                ],
            ],
            'IPA' => [
                [
                    'soal' => 'Organel sel yang berfungsi sebagai tempat respirasi sel dan penghasil energi utama adalah...',
                    'a' => 'Ribosom', 'b' => 'Mitokondria', 'c' => 'Badan Golgi', 'd' => 'Kloroplas',
                    'kunci' => 'B',
                ],
                [
                    'soal' => 'Satuan Sistem Internasional (SI) untuk besaran intensitas cahaya adalah...',
                    'a' => 'Candela', 'b' => 'Kelvin', 'c' => 'Ampere', 'd' => 'Mole',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Peristiwa perubahan wujud zat dari gas langsung menjadi padat disebut...',
                    'a' => 'Mengkristal (deposisi)', 'b' => 'Menyublim', 'c' => 'Mengembun', 'd' => 'Membeku',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Hewan berikut yang berkembang biak secara ovovivipar adalah...',
                    'a' => 'Kadal dan sebagian jenis hiu', 'b' => 'Ayam dan itik', 'c' => 'Sapi dan kambing', 'd' => 'Katak dan ikan mas',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Benda bermassa 5 kg ditarik dengan gaya 20 N. Percepatan yang dialami benda tersebut adalah...',
                    'a' => '2 m/s²', 'b' => '4 m/s²', 'c' => '5 m/s²', 'd' => '100 m/s²',
                    'kunci' => 'B',
                ],
            ],
            'Bahasa Indonesia' => [
                [
                    'soal' => 'Teks yang menggambarkan suatu objek secara jelas dan terperinci sehingga pembaca seolah-olah melihat sendiri disebut teks...',
                    'a' => 'Eksposisi', 'b' => 'Deskripsi', 'c' => 'Narasi', 'd' => 'Prosedur',
                    'kunci' => 'B',
                ],
                [
                    'soal' => 'Ide pokok dalam sebuah paragraf biasanya tertuang dalam...',
                    'a' => 'Kalimat utama', 'b' => 'Kalimat penjelas', 'c' => 'Judul teks', 'd' => 'Simpulan',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Kata penghubung yang menyatakan hubungan sebab-akibat adalah...',
                    'a' => 'Dan, serta', 'b' => 'Karena, sehingga', 'c' => 'Tetapi, melainkan', 'd' => 'Atau, maupun',
                    'kunci' => 'B',
                ],
                [
                    'soal' => 'Ciri kebahasaan teks fabel yang paling menonjol adalah...',
                    'a' => 'Menggunakan tokoh binatang yang berperilaku seperti manusia', 'b' => 'Berisi fakta ilmiah', 'c' => 'Memuat langkah-langkah kerja', 'd' => 'Bersifat argumentatif',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Penulisan kata baku yang tepat menurut KBBI adalah...',
                    'a' => 'Aktifitas, ijin, antri', 'b' => 'Aktivitas, izin, antre', 'c' => 'Aktivitet, ijin, antri', 'd' => 'Aktif, ijin, antre',
                    'kunci' => 'B',
                ],
            ],
            'Bahasa Inggris' => [
                [
                    'soal' => 'What is the suitable expression to greet your teacher at 7.00 AM?',
                    'a' => 'Good evening, Sir.', 'b' => 'Good morning, Sir.', 'c' => 'Good afternoon, Sir.', 'd' => 'Good night, Sir.',
                    'kunci' => 'B',
                ],
                [
                    'soal' => '"Rani always ... to school on foot every day."',
                    'a' => 'go', 'b' => 'goes', 'c' => 'went', 'd' => 'gone',
                    'kunci' => 'B',
                ],
                [
                    'soal' => 'Which of the following sentences is in Present Continuous Tense?',
                    'a' => 'They are studying in the library.', 'b' => 'They studied yesterday.', 'c' => 'They study English.', 'd' => 'They will study.',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'The opposite of the word "generous" is...',
                    'a' => 'Kind', 'b' => 'Polite', 'c' => 'Stingy', 'd' => 'Honest',
                    'kunci' => 'C',
                ],
                [
                    'soal' => '"Look at the clouds! It ... rain very soon."',
                    'a' => 'is going to', 'b' => 'will be', 'c' => 'was', 'd' => 'has',
                    'kunci' => 'A',
                ],
            ],
            'Umum' => [
                [
                    'soal' => 'Lambang negara Indonesia adalah...',
                    'a' => 'Garuda Pancasila', 'b' => 'Banteng', 'c' => 'Beringin', 'd' => 'Rantai Emas',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Semboyan bangsa Indonesia "Bhinneka Tunggal Ika" memiliki arti...',
                    'a' => 'Berbeda-beda tetapi tetap satu jua', 'b' => 'Bersatu kita teguh bercerai kita runtuh', 'c' => 'Maju terus pantang mundur', 'd' => 'Keadilan sosial bagi semua',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Sila ke-3 Pancasila berbunyi...',
                    'a' => 'Ketuhanan Yang Maha Esa', 'b' => 'Persatuan Indonesia', 'c' => 'Kemanusiaan yang Adil dan Beradab', 'd' => 'Keadilan Sosial',
                    'kunci' => 'B',
                ],
                [
                    'soal' => 'Hak asasi manusia di Indonesia diatur secara tegas dalam UUD 1945 pasal...',
                    'a' => 'Pasal 27 - 34', 'b' => 'Pasal 1 - 5', 'c' => 'Pasal 36', 'd' => 'Pasal 10',
                    'kunci' => 'A',
                ],
                [
                    'soal' => 'Sikap yang mencerminkan pengamalan musyawarah untuk mufakat adalah...',
                    'a' => 'Menghargai pendapat orang lain saat diskusi', 'b' => 'Memaksakan kehendak', 'c' => 'Tidak mau mendengarkan saran', 'd' => 'Meninggalkan ruangan saat voting',
                    'kunci' => 'A',
                ],
            ],
        ];

        // Seed 1-2 exams per schedule
        foreach ($topiks as $topik) {
            $kelasMapel = $topik->kelasMataPelajaran;
            if (!$kelasMapel) {
                continue;
            }

            $matpelName = $kelasMapel->mataPelajaran?->nama_matpel ?? 'Umum';
            $questionsPool = $sampleQuestions[$matpelName] ?? $sampleQuestions['Umum'];

            // Find students in this class
            $students = DB::table('kelas_siswas')
                ->where('id_kelas', $kelasMapel->kelas_id)
                ->pluck('id_siswa');

            if ($students->isEmpty()) {
                continue;
            }

            $ujianList = [
                [
                    'judul' => 'Ulangan Harian 1: ' . $topik->judul_topik,
                    'jenis' => 'Ulangan Harian',
                    'deskripsi' => 'Evaluasi kompetensi dasar untuk topik ' . $topik->judul_topik . '. Kerjakan secara mandiri.',
                    'tanggal' => Carbon::now()->subWeeks(3)->toDateString(),
                ],
                [
                    'judul' => 'Penilaian Tengah Semester (PTS) - ' . $matpelName,
                    'jenis' => 'PTS',
                    'deskripsi' => 'Ujian terstruktur tengah semester genap/ganjil mencakup pemahaman materi komprehensif.',
                    'tanggal' => Carbon::now()->subWeeks(1)->toDateString(),
                ],
            ];

            foreach ($ujianList as $u) {
                $ujianId = (string) Str::uuid();

                DB::table('ujian')->insert([
                    'id_ujian' => $ujianId,
                    'judul' => $u['judul'],
                    'jenis_ujian' => $u['jenis'],
                    'deskripsi' => $u['deskripsi'],
                    'topik_id' => $topik->id_topik,
                    'kelas_mata_pelajaran_id' => $kelasMapel->id_kelas_mata_pelajaran,
                    'tanggal_dibuat' => $u['tanggal'],
                    'created_at' => $u['tanggal'],
                    'updated_at' => $u['tanggal'],
                ]);

                // Insert 5 Soal Ujian
                $createdSoalIds = [];
                foreach ($questionsPool as $idx => $q) {
                    $soalId = (string) Str::uuid();
                    $createdSoalIds[] = ['id' => $soalId, 'kunci' => $q['kunci']];

                    DB::table('soal_ujian')->insert([
                        'id_soal_ujian' => $soalId,
                        'ujian_id' => $ujianId,
                        'judul_ujian' => $u['judul'],
                        'teks_soal' => $q['soal'],
                        'opsi_a' => $q['a'],
                        'opsi_b' => $q['b'],
                        'opsi_c' => $q['c'],
                        'opsi_d' => $q['d'],
                        'kunci_jawaban' => $q['kunci'],
                        'created_at' => $u['tanggal'],
                        'updated_at' => $u['tanggal'],
                    ]);
                }

                // Insert Pengumpulan Ujian & Jawaban Ujian for students
                foreach ($students as $siswaId) {
                    $pengumpulanId = (string) Str::uuid();
                    $score = rand(70, 96);

                    DB::table('pengumpulan_ujian')->insert([
                        'id_pengumpulan_ujian' => $pengumpulanId,
                        'ujian_id' => $ujianId,
                        'siswa_id' => $siswaId,
                        'tanggal_pengumpulan' => $u['tanggal'] . ' 10:30:00',
                        'nilai' => (string) $score,
                        'created_at' => $u['tanggal'],
                        'updated_at' => $u['tanggal'],
                    ]);

                    foreach ($createdSoalIds as $soalItem) {
                        // 85% chance student answered correctly
                        $answeredCorrectly = (rand(1, 100) <= 85);
                        $chosen = $answeredCorrectly
                            ? $soalItem['kunci']
                            : collect(['A', 'B', 'C', 'D'])->reject(fn($val) => $val === $soalItem['kunci'])->random();

                        DB::table('jawaban_ujian')->insert([
                            'id_jawaban_ujian' => (string) Str::uuid(),
                            'pengumpulan_ujian_id' => $pengumpulanId,
                            'soal_id' => $soalItem['id'],
                            'jawaban_dipilih' => $chosen,
                            'created_at' => $u['tanggal'],
                            'updated_at' => $u['tanggal'],
                        ]);
                    }
                }
            }
        }
    }
}
