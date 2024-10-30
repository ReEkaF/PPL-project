<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Staffakademik;
use App\Models\Staffperpus;
use Illuminate\Support\Str;
use App\Models\Superadmin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $idUser1 = Str::uuid(); 
        $idUser2 = Str::uuid(); 
        Superadmin::create([
            'id_admin'=>$idUser1,
            'username' => 'admin',
            'password' => bcrypt('admin123')
        ,
        ]);
        Staffperpus::create([
            'id_staff_perpustakaan'=>$idUser2,
            'username' => 'perpus',
            'password' => bcrypt('perpus123')
        ,
        ]);
        $idUser3 = Str::uuid(); 
        Staffakademik::create([
        'id_staff_akademik'=>$idUser3,
        'username' => 'akademik',
        'password' => bcrypt('akademik123')
,
]);
// Generate UUIDs
$idUser4 = Str::uuid();
$idUser5 = Str::uuid();

// Create siswa with role 'siswa'
Siswa::create([
    'id_siswa' => $idUser4,
    'username' => 'siswa',
    'password' => bcrypt('siswa'),
    'role_siswa' => 'siswa',
]);

// Create siswa with role 'pengurus'
Siswa::create([
    'id_siswa' => $idUser5,
    'username' => 'pengurus',
    'password' => bcrypt('pengurus'),
    'role_siswa' => 'pengurus',
]);
$idUser6 = Str::uuid();
$idUser7 = Str::uuid();
Guru::create([
    'id_guru' => $idUser6,
    'username' => 'guru',
    'password' => bcrypt('guru'),
    'role_guru' => 'guru',
]);
Guru::create([
    'id_guru' => $idUser7,
    'username' => 'pembina',
    'password' => bcrypt('pembina'),
    'role_guru' => 'pembina',
]);
        
    }
}
