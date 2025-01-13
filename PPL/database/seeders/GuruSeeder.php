<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $gurus = [
            ['nip' => '1985123456', 'nama_guru' => 'Agus Santoso', 'email' => 'agus.santoso@example.com', 'foto_guru' => 'foto1.jpg', 'nomor_wa_guru' => '081234567890', 'username' => 'agus_santoso', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 1', 'role_guru' => 'pembina'],
            ['nip' => '1985123457', 'nama_guru' => 'Siti Aisyah', 'email' => 'siti.aisyah@example.com', 'foto_guru' => 'foto2.jpg', 'nomor_wa_guru' => '081234567891', 'username' => 'siti_aisyah', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 2', 'role_guru' => 'pembina'],
            ['nip' => '1985123458', 'nama_guru' => 'Budi Setiawan', 'email' => 'budi.setiawan@example.com', 'foto_guru' => 'foto3.jpg', 'nomor_wa_guru' => '081234567892', 'username' => 'budi_setiawan', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 3', 'role_guru' => 'pembina'],
            ['nip' => '1985123459', 'nama_guru' => 'Eka Pratama', 'email' => 'eka.pratama@example.com', 'foto_guru' => 'foto4.jpg', 'nomor_wa_guru' => '081234567893', 'username' => 'eka_pratama', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 4', 'role_guru' => 'pembina'],
            ['nip' => '1985123460', 'nama_guru' => 'Dewi Kartika', 'email' => 'dewi.kartika@example.com', 'foto_guru' => 'foto5.jpg', 'nomor_wa_guru' => '081234567894', 'username' => 'dewi_kartika', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 5', 'role_guru' => 'pembina'],
            ['nip' => '1985123461', 'nama_guru' => 'Rini Marlina', 'email' => 'rini.marlina@example.com', 'foto_guru' => 'foto6.jpg', 'nomor_wa_guru' => '081234567895', 'username' => 'rini_marlina', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 6', 'role_guru' => 'pembina'],
            ['nip' => '1985123462', 'nama_guru' => 'Fajar Hidayat', 'email' => 'fajar.hidayat@example.com', 'foto_guru' => 'foto7.jpg', 'nomor_wa_guru' => '081234567896', 'username' => 'fajar_hidayat', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 7', 'role_guru' => 'pembina'],
            ['nip' => '1985123463', 'nama_guru' => 'Sri Wahyuni', 'email' => 'sri.wahyuni@example.com', 'foto_guru' => 'foto8.jpg', 'nomor_wa_guru' => '081234567897', 'username' => 'sri_wahyuni', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 8', 'role_guru' => 'guru'],
            ['nip' => '1985123464', 'nama_guru' => 'Yoga Aditya', 'email' => 'yoga.aditya@example.com', 'foto_guru' => 'foto9.jpg', 'nomor_wa_guru' => '081234567898', 'username' => 'yoga_aditya', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 9', 'role_guru' => 'guru'],
            ['nip' => '1985123465', 'nama_guru' => 'Rahmawati Anisa', 'email' => 'rahmawati.anisa@example.com', 'foto_guru' => 'foto10.jpg', 'nomor_wa_guru' => '081234567899', 'username' => 'rahmawati_anisa', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 10', 'role_guru' => 'guru'],
            ['nip' => '1985123466', 'nama_guru' => 'Andi Prakoso', 'email' => 'andi.prakoso@example.com', 'foto_guru' => 'foto11.jpg', 'nomor_wa_guru' => '081234567900', 'username' => 'andi_prakoso', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 11', 'role_guru' => 'guru'],
            ['nip' => '1985123467', 'nama_guru' => 'Lina Kusuma', 'email' => 'lina.kusuma@example.com', 'foto_guru' => 'foto12.jpg', 'nomor_wa_guru' => '081234567901', 'username' => 'lina_kusuma', 'password' => bcrypt('password123'), 'alamat_guru' => 'Alamat 12', 'role_guru' => 'guru']
        ];

        foreach ($gurus as $guru) {
            Guru::create($guru);
        }
    }
}
