<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $nomorWa = ["+6289531419612",  "+6285936191911", "+6287864365113", "+6285172427944"];


        Siswa::create([
            "nisn" => "03129592757722",
            "nama_siswa" => "Abdul Rahem Faqih",
            "nomor_wa_siswa" => $nomorWa[0],
            "username" => "faqih",
            "password" => bcrypt('password'),
            "role_siswa" => "pengurus"
        ]);
        Siswa::create([
            "nisn" => "03129592757723",
            "nama_siswa" => "Abdul Rahem Faqih 2",
            "nomor_wa_siswa" => $nomorWa[1],
            "username" => "faqih2",
            "password" => bcrypt('password'),
            "role_siswa" => "pengurus"
        ]);
        Siswa::create([
            "nisn" => "03129592757724",
            "nama_siswa" => "Sabil Ahmad",
            "nomor_wa_siswa" => $nomorWa[2],
            "username" => "sabil",
            "password" => bcrypt('password'),
            "role_siswa" => "pengurus"
        ]);
        Siswa::create([
            "nisn" => "03129592757725",
            "nama_siswa" => "Ronggo Widjoyo",
            "nomor_wa_siswa" => $nomorWa[3],
            "username" => "ronggo",
            "password" => bcrypt('password'),
            "role_siswa" => "pengurus"
        ]);
    }
}
