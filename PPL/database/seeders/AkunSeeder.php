<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Staffakademik;
use App\Models\Staffperpus;
use App\Models\Superadmin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $akun_seeder = [
            'superadmin' => [
                [
                    'username' => 'admin',
                    'password' => 'admin123',
                    'email' => 'andreeka852@gmail.com',
                    "nama_superadmin" => "Andre"
                ]
            ],
            'staff_akademik' => [
                [
                    'nama_staff_akademik' => 'Bagus Satria Putra Anugrah',
                    'email' => 'bagusanugrah777@gmail.com',
                    'username' => 'bagussatria69',
                    'password' => 'bagussatria'
                ]
            ],

            'staff_perpus' => [
                [
                    'nama_staff_perpustakaan' => 'Ahmad Ar-rosyid Hidayatullah',
                    'username' => 'amir',
                    'password' => 'amir',
                    'email' => 'ychronos13@gmail.com',
                ]
            ],

            'guru' => [
                [
                    'nama_guru' => 'Abdul Rahem Faqih',
                    'nip' => '220411100029',
                    'username' => 'faqih',
                    'password' => 'faqih',
                    'email' => 'faqih3935@gmail.com',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Bangkalan',
                    'nomor_wa_guru' => '+6289531419612',
                    'role_guru' => 'guru'
                ],
                [
                    'nama_guru' => 'Sabil Ahmad Hidayat',
                    'nip' => '220411100058',
                    'username' => 'sabilAhmad',
                    'password' => 'sabilahmad11',
                    'email' => 'sabilahmad615@gmail.com',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Nganjuk',
                    'nomor_wa_guru' => null,
                    'role_guru' => 'guru'
                ],
                [
                    'nama_guru' => 'Adi Prawono',
                    'nip' => '220411100165',
                    'username' => 'AdiPWN',
                    'password' => 'adiprawono1',
                    'email' => 'adiprawono85@gmail.com',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Bangkalan',
                    'nomor_wa_guru' => null,
                    'role_guru' => 'guru'
                ],
                [
                    'nama_guru' => 'Abdul Hijjah Akbarul Hidayatulloh',
                    'nip' => '220411100134',
                    'username' => 'cakakbar',
                    'password' => 'cakakbar123',
                    'email' => 'abdul.hijjah.akbarul.hidayatulloh@gmail.com',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Bangkalan',
                    'nomor_wa_guru' => '+6285607147641',
                    'role_guru' => 'guru'
                ],
                [
                    'nama_guru' => 'Rizkyan Dwi Prasetiawan',
                    'nip' => '220411100026',
                    'username' => 'rizky',
                    'password' => 'rizky123',
                    'email' => 'rizkyandwip@gmail.com',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => null,
                    'nomor_wa_guru' => '+62859106520760',
                    'role_guru' => 'guru'
                ],
                [
                    'nama_guru' => 'Niken Ning Pambudi',
                    'nip' => '220411100128',
                    'username' => 'nikenpambudi',
                    'password' => 'kenpambudi',
                    'email' => 'nikenpambudi123@gmail.com',
                    'jenis_kelamin' => 'Perempuan',
                    'alamat' => 'Trenggalek',
                    'nomor_wa_guru' => '+6282234777979',
                    'role_guru' => 'guru'
                ],
                [
                    'nama_guru' => 'Nurul Maulydia IImami',
                    'nip' => '220411100059',
                    'username' => 'maulydia',
                    'password' => 'lydia',
                    'email' => 'nurulmaulydiaimami@gmail.com',
                    'jenis_kelamin' => 'Perempuan',
                    'alamat' => 'Bangkalan',
                    'nomor_wa_guru' => '+682338924959',
                    'role_guru' => 'guru'
                ],
                [
                    'nama_guru' => 'Muhammad Ilham Zakaria',
                    'nip' => '220411100100',
                    'username' => 'ilhamz',
                    'password' => 'querosero7013#@Pl',
                    'email' => 'ilhamzakaria3024@gmail.com',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Bangkalan',
                    'nomor_wa_guru' => null,
                    'role_guru' => 'guru'
                ],
                [
                    'nama_guru' => 'Noval',
                    'nip' => '220411100001',
                    'username' => 'noval',
                    'password' => 'noval',
                    'email' => 'noval@gmail.com',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Bangkalan',
                    'nomor_wa_guru' => '+6287853053661',
                    'role_guru' => 'guru'
                ],
                [
                    'nama_guru' => 'Ronggo',
                    'nip' => '220411100061',
                    'email' => 'ronggofc@gmail.com',
                    'username' => 'ranwiesiel',
                    'password' => 'ronggo123',
                    'nomor_wa_guru' => '+6285172427944',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Lamongan',
                    'role_guru' => 'pembina'
                ]
            ],

            'siswa' => [
                [
                    'nisn' => '220411100108',
                    'nama_siswa' => 'Umar Muchtar Khaidzar',
                    'email' => 'umuchtar0@gmail.com',
                    'username' => 'XiaoHongShu',
                    'password' => 'bisadipercepatngga',
                    'nomor_wa_siswa' => '+6281215784584',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Mojokerto',
                    'role_siswa' => 'siswa'
                ],
                [
                    'nisn' => '220411100076',
                    'nama_siswa' => 'Glendy Hernandez Putra Mahardika Gunantoro',
                    'email' => 'glendygunantoro@gmail.com',
                    'username' => 'HeraldGrace',
                    'password' => '1sampai2',
                    'nomor_wa_siswa' => '+62895377360736',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Ngawi',
                    'role_siswa' => 'siswa'
                ],
                [
                    'nisn' => '220411100072',
                    'nama_siswa' => 'Adi Sahrul Ramadhan',
                    'email' => 'adisahrul383@gmail.com',
                    'username' => 'adisahrul1',
                    'password' => 'adisahrul1',
                    'nomor_wa_siswa' => '+6281233658802',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Surabaya',
                    'role_siswa' => 'siswa'
                ],
                [
                    'nisn' => '220411100086',
                    'nama_siswa' => 'Ali Syamsuddin',
                    'email' => 'alisyamsuddin05@gmail.com',
                    'username' => 'alisyamsuddin',
                    'password' => 'alisyamsuddin',
                    'nomor_wa_siswa' => '+6281235232515',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Sampang',
                    'role_siswa' => 'siswa'
                ],
                [
                    'nisn' => '220411100059',
                    'nama_siswa' => 'Nur Rohma Widiya Ningsih',
                    'email' => 'nurrohmawidiyaningsih@gmail.com',
                    'username' => 'widiya',
                    'password' => 'widiya',
                    'nomor_wa_siswa' => '+6285745612946',
                    'jenis_kelamin' => 'Perempuan',
                    'alamat' => 'Gresik',
                    'role_siswa' => 'siswa'
                ],
                [
                    'nisn' => '220411100041',
                    'nama_siswa' => 'Muhammad Saiful Huda',
                    'email' => 'muhammadsaifulhuda01@gmail.com',
                    'username' => 'huda',
                    'password' => 'huda',
                    'nomor_wa_siswa' => '+6282146153816',
                    'jenis_kelamin' => 'Laki-laki',
                    'alamat' => 'Bojonegoro',
                    'role_siswa' => 'pengurus'
                ]
            ],
        ];

        foreach ($akun_seeder['superadmin'] as $superadmin) {
            Superadmin::create([
                'nama_superadmin' => $superadmin['nama_superadmin'],
                'username' => $superadmin['username'],
                'password' => bcrypt($superadmin['password']),
                'email' => $superadmin['email']
            ]);
        }

        foreach ($akun_seeder['staff_akademik'] as $staff) {
            Staffakademik::create([
                'nama_staff_akademik' => $staff['nama_staff_akademik'],
                'email' => $staff['email'],
                'username' => $staff['username'],
                'password' => bcrypt($staff['password'])
            ]);
        }

        foreach ($akun_seeder['staff_perpus'] as $staff) {
            Staffperpus::create([
                'nama_staff_perpustakaan' => $staff['nama_staff_perpustakaan'],
                'username' => $staff['username'],
                'password' => bcrypt($staff['password']),
                'email' => $staff['email']
            ]);
        }

        foreach ($akun_seeder['guru'] as $guru) {
            Guru::create([
                'nama_guru' => $guru['nama_guru'],
                'nip' => $guru['nip'],
                'username' => $guru['username'],
                'password' => bcrypt($guru['password']),
                'email' => $guru['email'],
                'jenis_kelamin' => $guru['jenis_kelamin'],
                'alamat_guru' => $guru['alamat'] ?? null,
                'nomor_wa_guru' => $guru['nomor_wa_guru'] ?? null,
                'role_guru' => $guru['role_guru']
            ]);
        }

        foreach ($akun_seeder['siswa'] as $siswa) {
            Siswa::create([
                'nisn' => $siswa['nisn'],
                'nama_siswa' => $siswa['nama_siswa'],
                'email' => $siswa['email'],
                'username' => $siswa['username'],
                'password' => bcrypt($siswa['password']),
                'nomor_wa_siswa' => $siswa['nomor_wa_siswa'],
                'jenis_kelamin_siswa' => $siswa['jenis_kelamin'],
                'alamat_siswa' => $siswa['alamat'] ?? null,
                'role_siswa' => $siswa['role_siswa']
            ]);
        }
    }
}
