<?php

namespace Database\Seeders;

use App\Models\mata_pelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mataPelajaran = [
            ['nama_matpel' => "Matematika", "deskripsi_matpel" => "Pelajaran Matematika"],
            ['nama_matpel' => "Bahasa Indonesia", "deskripsi_matpel" => "Pelajaran Bahasa Indonesia"],
            ['nama_matpel' => "Bahasa Inggris", "deskripsi_matpel" => "Pelajaran Bahasa Inggris"],
            ['nama_matpel' => "IPA", "deskripsi_matpel" => "Pelajaran IPA"],
            ['nama_matpel' => "IPS", "deskripsi_matpel" => "Pelajaran IPS"],
            ['nama_matpel' => "PKN", "deskripsi_matpel" => "Pelajaran PKN"],
            ['nama_matpel' => "Seni Budaya", "deskripsi_matpel" => "Pelajaran Seni Budaya"],
            ['nama_matpel' => "Pendidikan Agama", "deskripsi_matpel" => "Pelajaran Pendidikan Agama"],
            ['nama_matpel' => "Pendidikan Jasmani", "deskripsi_matpel" => "Pelajaran Pendidikan Jasmani"],
            ['nama_matpel' => "Bahasa Daerah", "deskripsi_matpel" => "Pelajaran Bahasa Madura"],
        ];

        foreach ($mataPelajaran as $matpel) {
            mata_pelajaran::create($matpel);
        }
    }
}
