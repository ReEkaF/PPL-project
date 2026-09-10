<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Staffakademik;
use App\Models\Staffperpus;
use App\Models\Superadmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Superadmin Accounts
        $superadmins = [
            [
                'username' => 'admin',
                'password' => bcrypt('admin123'),
                'email' => 'admin@smpn2kamal.sch.id',
                'nama_superadmin' => 'Administrator Utama',
            ],
            [
                'username' => 'superadmin',
                'password' => bcrypt('admin123'),
                'email' => 'superadmin@smpn2kamal.sch.id',
                'nama_superadmin' => 'Super Admin SST',
            ],
        ];

        foreach ($superadmins as $admin) {
            Superadmin::firstOrCreate(
                ['username' => $admin['username']],
                [
                    'id_admin' => (string) Str::uuid(),
                    'password' => $admin['password'],
                    'email' => $admin['email'],
                    'nama_superadmin' => $admin['nama_superadmin'],
                ]
            );
        }

        // 2. Staff Akademik Accounts
        $staffAkademiks = [
            [
                'username' => 'akademik',
                'password' => bcrypt('akademik123'),
                'email' => 'akademik@smpn2kamal.sch.id',
                'nama_staff_akademik' => 'Bagus Satria Putra Anugrah, S.Pd.',
            ],
            [
                'username' => '123456789999',
                'password' => bcrypt('Akademik123'),
                'email' => 'staff.akademik@smpn2kamal.sch.id',
                'nama_staff_akademik' => 'Dewi Rahmawati, S.Pd.',
            ],
        ];

        foreach ($staffAkademiks as $staff) {
            Staffakademik::firstOrCreate(
                ['username' => $staff['username']],
                [
                    'id_staff_akademik' => (string) Str::uuid(),
                    'nama_staff_akademik' => $staff['nama_staff_akademik'],
                    'email' => $staff['email'],
                    'password' => $staff['password'],
                ]
            );
        }

        // 3. Staff Perpustakaan Accounts
        $staffPerpuses = [
            [
                'username' => 'perpus',
                'password' => bcrypt('perpus123'),
                'email' => 'perpus@smpn2kamal.sch.id',
                'nama_staff_perpustakaan' => 'Ahmad Ar-Rosyid Hidayatullah, S.I.Pust.',
            ],
            [
                'username' => '123456789101',
                'password' => bcrypt('Perpus123'),
                'email' => 'staff.perpus@smpn2kamal.sch.id',
                'nama_staff_perpustakaan' => 'Nurul Hidayati, A.Md.',
            ],
        ];

        foreach ($staffPerpuses as $staff) {
            Staffperpus::firstOrCreate(
                ['username' => $staff['username']],
                [
                    'id_staff_perpustakaan' => (string) Str::uuid(),
                    'nama_staff_perpustakaan' => $staff['nama_staff_perpustakaan'],
                    'password' => $staff['password'],
                    'email' => $staff['email'],
                ]
            );
        }

        // 4. Guru Accounts (Realistic NIP, phone, addresses, and pembina roles)
        $gurus = [
            [
                'username' => 'guru',
                'password' => bcrypt('guru123'),
                'nama_guru' => 'Drs. H. Mulyadi, M.Pd.',
                'nip' => '197005121998021001',
                'email' => 'mulyadi@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Raya Kamal No. 12, Bangkalan',
                'nomor_wa_guru' => '081234567890',
                'role_guru' => 'guru',
            ],
            [
                'username' => 'faqih',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Abdul Rahem Faqih, S.Pd.',
                'nip' => '198501152010011005',
                'email' => 'faqih@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Perum Kamal Asri Blok B No. 4, Bangkalan',
                'nomor_wa_guru' => '089531419612',
                'role_guru' => 'pembina',
            ],
            [
                'username' => 'sabil',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Sabil Ahmad Hidayat, S.Pd.',
                'nip' => '198703222011011009',
                'email' => 'sabil@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Kusuma Bangsa No. 45, Nganjuk',
                'nomor_wa_guru' => '081335678901',
                'role_guru' => 'guru',
            ],
            [
                'username' => 'adiprawono',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Adi Prawono, S.Pd., M.Ed.',
                'nip' => '198308142008011004',
                'email' => 'adiprawono@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Pahlawan No. 78, Bangkalan',
                'nomor_wa_guru' => '085231456782',
                'role_guru' => 'pembina',
            ],
            [
                'username' => 'akbar',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Abdul Hijjah Akbarul, S.Si.',
                'nip' => '199002102014021003',
                'email' => 'akbar@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Trunojoyo No. 19, Bangkalan',
                'nomor_wa_guru' => '085607147641',
                'role_guru' => 'guru',
            ],
            [
                'username' => 'rizkyan',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Rizkyan Dwi Prasetiawan, S.Pd.',
                'nip' => '198811052012011007',
                'email' => 'rizkyan@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Teuku Umar No. 33, Bangkalan',
                'nomor_wa_guru' => '085910652076',
                'role_guru' => 'pembina',
            ],
            [
                'username' => 'niken',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Niken Ning Pambudi, S.Pd.',
                'nip' => '199104182015032002',
                'email' => 'niken@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Perempuan',
                'alamat' => 'Jl. Kartini No. 10, Trenggalek',
                'nomor_wa_guru' => '082234777979',
                'role_guru' => 'guru',
            ],
            [
                'username' => 'maulydia',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Nurul Maulydia Imami, S.Sn.',
                'nip' => '199307252019032011',
                'email' => 'maulydia@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Perempuan',
                'alamat' => 'Jl. Pemuda No. 25, Bangkalan',
                'nomor_wa_guru' => '082338924959',
                'role_guru' => 'pembina',
            ],
            [
                'username' => 'ilham',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Muhammad Ilham Zakaria, S.Pd.I.',
                'nip' => '198609302009021006',
                'email' => 'ilham@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Masjid Agung No. 05, Bangkalan',
                'nomor_wa_guru' => '081703456789',
                'role_guru' => 'pembina',
            ],
            [
                'username' => 'noval',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Noval Firdaus, S.Or.',
                'nip' => '199212012016011008',
                'email' => 'noval@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Stadion Gelora Bangkalan No. 02',
                'nomor_wa_guru' => '087853053661',
                'role_guru' => 'pembina',
            ],
            [
                'username' => 'ronggo',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Ronggo Warsito, S.Pd.',
                'nip' => '198906162013021004',
                'email' => 'ronggo@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Ronggolawe No. 88, Lamongan',
                'nomor_wa_guru' => '085172427944',
                'role_guru' => 'pembina',
            ],
            [
                'username' => 'endah',
                'password' => bcrypt('password123'),
                'nama_guru' => 'Endah Tri Wahyuni, S.Kom.',
                'nip' => '199401202020122015',
                'email' => 'endah@smpn2kamal.sch.id',
                'jenis_kelamin' => 'Perempuan',
                'alamat' => 'Jl. Telang Indah No. 15, Kamal',
                'nomor_wa_guru' => '085331122334',
                'role_guru' => 'pembina',
            ],
        ];

        foreach ($gurus as $guru) {
            Guru::updateOrCreate(
                ['nip' => $guru['nip']],
                [
                    'id_guru' => Guru::where('nip', $guru['nip'])->value('id_guru') ?? (string) Str::uuid(),
                    'nama_guru' => $guru['nama_guru'],
                    'username' => $guru['username'],
                    'password' => $guru['password'],
                    'email' => $guru['email'],
                    'jenis_kelamin' => $guru['jenis_kelamin'],
                    'alamat_guru' => $guru['alamat'],
                    'nomor_wa_guru' => $guru['nomor_wa_guru'],
                    'role_guru' => $guru['role_guru'],
                ]
            );
        }

        // 5. Siswa Accounts (24 Students distributed across Grades 7, 8, and 9)
        $siswas = [
            // --- KELAS 7 ---
            [
                'nisn' => '0081110001',
                'nama_siswa' => 'Ahmad Fauzi Ramadhan',
                'username' => 'siswa',
                'password' => bcrypt('siswa123'),
                'email' => 'ahmad.fauzi@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081234567801',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Jl. Pelabuhan Barat No. 14, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0081110002',
                'nama_siswa' => 'Anisa Rahmawati',
                'username' => 'anisa',
                'password' => bcrypt('siswa123'),
                'email' => 'anisa.rahmawati@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081234567802',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Jl. Telang Raya No. 22, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0081110003',
                'nama_siswa' => 'Budi Santoso',
                'username' => 'budi',
                'password' => bcrypt('siswa123'),
                'email' => 'budi.santoso@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081234567803',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Desa Tanjung Jati, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0081110004',
                'nama_siswa' => 'Dewi Lestari Putri',
                'username' => 'dewi',
                'password' => bcrypt('siswa123'),
                'email' => 'dewi.lestari@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081234567804',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Jl. Trunojoyo No. 40, Bangkalan',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0081110005',
                'nama_siswa' => 'Fajar Nugraha',
                'username' => 'fajar',
                'password' => bcrypt('siswa123'),
                'email' => 'fajar.nugraha@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081234567805',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Desa Banyuajuh, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0081110006',
                'nama_siswa' => 'Nadia Salma Zahira',
                'username' => 'nadia',
                'password' => bcrypt('siswa123'),
                'email' => 'nadia.salma@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081234567806',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Jl. Kusuma Bangsa No. 11, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0081110007',
                'nama_siswa' => 'Dimas Arya Pratama',
                'username' => 'dimas',
                'password' => bcrypt('siswa123'),
                'email' => 'dimas.arya@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081234567807',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Desa Gili Barat, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0081110008',
                'nama_siswa' => 'Zahra Amanda Putri',
                'username' => 'zahra',
                'password' => bcrypt('siswa123'),
                'email' => 'zahra.amanda@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081234567808',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Perum Telang Indah Blok C-10',
                'role_siswa' => 'siswa',
            ],

            // --- KELAS 8 ---
            [
                'nisn' => '0072220001',
                'nama_siswa' => 'Umar Muchtar Khaidzar',
                'username' => 'umar',
                'password' => bcrypt('siswa123'),
                'email' => 'umar.muchtar@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081215784584',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Jl. Majapahit No. 8, Mojokerto',
                'role_siswa' => 'pengurus',
            ],
            [
                'nisn' => '0072220002',
                'nama_siswa' => 'Glendy Hernandez Putra',
                'username' => 'glendy',
                'password' => bcrypt('siswa123'),
                'email' => 'glendy.hernandez@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '089537736073',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Jl. Diponegoro No. 15, Kamal',
                'role_siswa' => 'pengurus',
            ],
            [
                'nisn' => '0072220003',
                'nama_siswa' => 'Muhammad Reza Aditya',
                'username' => 'reza',
                'password' => bcrypt('siswa123'),
                'email' => 'reza.aditya@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081333444555',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Jl. Jokotole No. 27, Bangkalan',
                'role_siswa' => 'pengurus',
            ],
            [
                'nisn' => '0072220004',
                'nama_siswa' => 'Tiara Andini Kusuma',
                'username' => 'tiara',
                'password' => bcrypt('siswa123'),
                'email' => 'tiara.andini@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081255667788',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Jl. Melati No. 04, Kamal',
                'role_siswa' => 'pengurus',
            ],
            [
                'nisn' => '0072220005',
                'nama_siswa' => 'Muhammad Ilham Maulana',
                'username' => 'ilham_m',
                'password' => bcrypt('siswa123'),
                'email' => 'ilham.maulana@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081399887766',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Desa Kamal Permai No. 5',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0072220006',
                'nama_siswa' => 'Safira Nur Aini',
                'username' => 'safira',
                'password' => bcrypt('siswa123'),
                'email' => 'safira.aini@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '082144556677',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Jl. Kenanga No. 12, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0072220007',
                'nama_siswa' => 'Bayu Aji Pamungkas',
                'username' => 'bayu',
                'password' => bcrypt('siswa123'),
                'email' => 'bayu.aji@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '085233445566',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Desa Tajungan, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0072220008',
                'nama_siswa' => 'Citra Kirana Maharani',
                'username' => 'citra',
                'password' => bcrypt('siswa123'),
                'email' => 'citra.kirana@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '087811223344',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Jl. Halim Perdanakusuma No. 6',
                'role_siswa' => 'siswa',
            ],

            // --- KELAS 9 ---
            [
                'nisn' => '0063330001',
                'nama_siswa' => 'Daffa Maulana Akbar',
                'username' => 'daffa',
                'password' => bcrypt('siswa123'),
                'email' => 'daffa.maulana@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '08819448888',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Jl. Anggrek No. 09, Bangkalan',
                'role_siswa' => 'pengurus',
            ],
            [
                'nisn' => '0063330002',
                'nama_siswa' => 'Khalif Ardiansyah',
                'username' => 'khalif',
                'password' => bcrypt('siswa123'),
                'email' => 'khalif.ardiansyah@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '089601614745',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Jl. Semampir Barat No. 3',
                'role_siswa' => 'pengurus',
            ],
            [
                'nisn' => '0063330003',
                'nama_siswa' => 'Nurul Huda Pratama',
                'username' => 'huda',
                'password' => bcrypt('siswa123'),
                'email' => 'nurul.huda@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '082146153816',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Jl. Veteran No. 18, Bojonegoro',
                'role_siswa' => 'pengurus',
            ],
            [
                'nisn' => '0063330004',
                'nama_siswa' => 'Rachel Putri Amelia',
                'username' => 'rachel',
                'password' => bcrypt('siswa123'),
                'email' => 'rachel.amelia@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '085733221100',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Jl. Raya Kamal Timur No. 50',
                'role_siswa' => 'pengurus',
            ],
            [
                'nisn' => '0063330005',
                'nama_siswa' => 'Rendy Septian Pratama',
                'username' => 'rendy',
                'password' => bcrypt('siswa123'),
                'email' => 'rendy.septian@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '081299001122',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Jl. Panglima Sudirman No. 8',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0063330006',
                'nama_siswa' => 'Salma Nabila Farhani',
                'username' => 'salma',
                'password' => bcrypt('siswa123'),
                'email' => 'salma.nabila@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '082344556688',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Desa Kebun, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0063330007',
                'nama_siswa' => 'Wahyu Tri Hidayat',
                'username' => 'wahyu',
                'password' => bcrypt('siswa123'),
                'email' => 'wahyu.tri@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '085277889900',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'alamat_siswa' => 'Jl. Dr. Soetomo No. 14, Kamal',
                'role_siswa' => 'siswa',
            ],
            [
                'nisn' => '0063330008',
                'nama_siswa' => 'Putri Anggita Sari',
                'username' => 'putri',
                'password' => bcrypt('siswa123'),
                'email' => 'putri.anggita@siswa.smpn2kamal.sch.id',
                'nomor_wa_siswa' => '087755443322',
                'jenis_kelamin_siswa' => 'Perempuan',
                'alamat_siswa' => 'Jl. Raya Socah No. 21, Bangkalan',
                'role_siswa' => 'siswa',
            ],
        ];

        foreach ($siswas as $siswa) {
            Siswa::updateOrCreate(
                ['nisn' => $siswa['nisn']],
                [
                    'id_siswa' => Siswa::where('nisn', $siswa['nisn'])->value('id_siswa') ?? (string) Str::uuid(),
                    'nama_siswa' => $siswa['nama_siswa'],
                    'username' => $siswa['username'],
                    'password' => $siswa['password'],
                    'email' => $siswa['email'],
                    'nomor_wa_siswa' => $siswa['nomor_wa_siswa'],
                    'jenis_kelamin_siswa' => $siswa['jenis_kelamin_siswa'],
                    'alamat_siswa' => $siswa['alamat_siswa'],
                    'role_siswa' => $siswa['role_siswa'],
                ]
            );
        }
    }
}
