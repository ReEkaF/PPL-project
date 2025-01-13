<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\kelas;
use App\Models\mata_pelajaran;
use App\Models\tahun_ajaran;
use App\Models\guru_mata_pelajaran;
use App\Models\hari;
use App\Models\kelas_mata_pelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KelasMapelGuruJadwalAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // START GURU SEEDER
        $guruid1 = Str::uuid();
        $guruid3 = Str::uuid();
        $guruid2 = Str::uuid();
        $guruid4 = Str::uuid();
        $guruid5 = Str::uuid();
        $guruid6 = Str::uuid();
        $guruid7 = Str::uuid();
        $guruid8 = Str::uuid();
        $guruid9 = Str::uuid();


        // Guru Pembina
        session(['guruid2' => $guruid2, 'guruid7' => $guruid7, 'guruid8' => $guruid8, 'guruid9' => $guruid9]);

        Guru::create([
            'id_guru' => $guruid2,
            'nip' => 'nip 2',
            'nama_guru' => 'Guru 2',
            'username' => 'pembina',
            'password' => bcrypt('pembina'),
            'role_guru' => 'pembina',
        ]);
        Guru::create([
            'id_guru' => $guruid7,
            'nip' => 'nip 7',
            'nama_guru' => 'Guru 7',
            'username' => 'pembina7',
            'password' => bcrypt('pembina7'),
            'role_guru' => 'pembina',
        ]);
        Guru::create([
            'id_guru' => $guruid8,
            'nip' => 'nip 8',
            'nama_guru' => 'Guru 8',
            'username' => 'pembina8',
            'password' => bcrypt('pembina8'),
            'role_guru' => 'pembina',
        ]);
        // End Guru Pembina

        Guru::create([
            'id_guru' => $guruid1,
            'nip' => 'nip 1',
            'nama_guru' => 'Guru 1',
            'username' => 'guru',
            'password' => bcrypt('guru'),
            'role_guru' => 'guru',
        ]);
        Guru::create([
            'id_guru' => $guruid9,
            'nip' => 'nip 9',
            'nama_guru' => 'Guru 9',
            'username' => 'pembina9',
            'password' => bcrypt('pembina9'),
            'role_guru' => 'pembina',
        ]);
        Guru::create([
            'id_guru' => $guruid3,
            'nip' => 'nip 3',
            'nama_guru' => 'Guru 3',
            'username' => 'guru3',
            'password' => bcrypt('guru'),
        ]);
        Guru::create([
            'id_guru' => $guruid4,
            'nip' => 'nip 4',
            'nama_guru' => 'Guru 4',
            'username' => 'guru4',
            'password' => bcrypt('guru'),
        ]);
        Guru::create([
            'id_guru' => $guruid5,
            'nip' => 'nip 5',
            'nama_guru' => 'Guru 5',
            'username' => 'guru5',
            'password' => bcrypt('guru'),
        ]);
        Guru::create([
            'id_guru' => $guruid6,
            'nip' => 'nip 6',
            'nama_guru' => 'Guru 6',
            'username' => 'guru6',
            'password' => bcrypt('guru'),
        ]);
        // END GURU SEEDER


        // START KELAS SEEDER
        $kelasid1 = Str::uuid();
        $kelasid2 = Str::uuid();
        kelas::create([
            "id_kelas" => $kelasid1,
            "nama_kelas" => "7A"
        ]);
        kelas::create([
            "id_kelas" => $kelasid2,
            "nama_kelas" => "7B"
        ]);
        // END KELAS SEEDER


        // START MATPEL SEEDER
        $mapelid1 = Str::uuid();
        $mapelid2 = Str::uuid();
        $mapelid3 = Str::uuid();
        $mapelid4 = Str::uuid();
        $mapelid5 = Str::uuid();
        $mapelid6 = Str::uuid();

        session(key: ['mapelid1' => $mapelid1, 'mapelid2' => $mapelid2, 'mapelid4' => $mapelid4, 'mapelid5' => $mapelid5, 'mapelid6' => $mapelid6]);

        mata_pelajaran::create(attributes: [
            'id_matpel' => $mapelid1,
            'nama_matpel' => 'IPA',
        ]);
        mata_pelajaran::create([
            'id_matpel' => $mapelid2,
            'nama_matpel' => 'IPS',
        ]);
        mata_pelajaran::create([
            'id_matpel' => $mapelid3,
            'nama_matpel' => 'Matematika',
        ]);
        mata_pelajaran::create([
            'id_matpel' => $mapelid4,
            'nama_matpel' => 'Indo',
        ]);
        mata_pelajaran::create([
            'id_matpel' => $mapelid5,
            'nama_matpel' => 'Inggris',
        ]);
        mata_pelajaran::create([
            'id_matpel' => $mapelid6,
            'nama_matpel' => 'Daerah',
        ]);
        // END MATPEL SEEDER

        // START TAHUN AJARAN SEEDER
        $tahunajaranid1 = Str::uuid();
        $tahunajaranid2 = Str::uuid();

        tahun_ajaran::create([
            'id_tahun_ajaran' => $tahunajaranid1,
            'tahun_mulai' => '2023',
            'tahun_selesai' => '2024',
            'semester' => 2,
            'aktif' => 1,
        ]);
        tahun_ajaran::create([
            'id_tahun_ajaran' => $tahunajaranid2,
            'tahun_mulai' => '2023',
            'tahun_selesai' => '2024',
            'semester' => 1,
            'aktif' => 0,
        ]);
        // END TAHUN AJARAN SEEDER


        // START GURU MAPEL SEEDER
        $gurumapelid1 = Str::uuid();
        $gurumapelid2 = Str::uuid();
        $gurumapelid3 = Str::uuid();
        $gurumapelid4 = Str::uuid();
        $gurumapelid5 = Str::uuid();
        $gurumapelid6 = Str::uuid();
        $gurumapelid7 = Str::uuid();
        $gurumapelid8 = Str::uuid();
        $gurumapelid9 = Str::uuid();
        $gurumapelid10 = Str::uuid();
        $gurumapelid11 = Str::uuid();
        $gurumapelid12 = Str::uuid();


        // guru ipa
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid1,
            'guru_id' => $guruid1,
            'matpel_id' => $mapelid1,
        ]);
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid2,
            'guru_id' => $guruid2,
            'matpel_id' => $mapelid1,
        ]);

        // guru ips
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid3,
            'guru_id' => $guruid3,
            'matpel_id' => $mapelid2,
        ]);
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid4,
            'guru_id' => $guruid4,
            'matpel_id' => $mapelid2,
        ]);

        // guru matematika
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid5,
            'guru_id' => $guruid5,
            'matpel_id' => $mapelid3,
        ]);
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid6,
            'guru_id' => $guruid6,
            'matpel_id' => $mapelid3,
        ]);

        // guru indo
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid7,
            'guru_id' => $guruid1,
            'matpel_id' => $mapelid4,
        ]);
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid8,
            'guru_id' => $guruid2,
            'matpel_id' => $mapelid4,
        ]);

        // guru inggris
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid9,
            'guru_id' => $guruid3,
            'matpel_id' => $mapelid5,
        ]);
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid10,
            'guru_id' => $guruid4,
            'matpel_id' => $mapelid5,
        ]);

        // guru daerah
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid11,
            'guru_id' => $guruid5,
            'matpel_id' => $mapelid6,
        ]);
        guru_mata_pelajaran::create([
            'id_guru_mata_pelajaran' => $gurumapelid12,
            'guru_id' => $guruid6,
            'matpel_id' => $mapelid6,
        ]);
        // END GURU MAPEL SEEDER

        // START HARI SEEDER
        $hariid1 = Str::uuid();
        $hariid2 = Str::uuid();
        $hariid3 = Str::uuid();
        $hariid4 = Str::uuid();
        $hariid5 = Str::uuid();
        $hariid6 = Str::uuid();

        hari::create([
            'id_hari' => $hariid1,
            'nama_hari' => 'Senin',
        ]);
        hari::create([
            'id_hari' => $hariid2,
            'nama_hari' => 'Selasa',
        ]);
        hari::create([
            'id_hari' => $hariid3,
            'nama_hari' => 'Rabu',
        ]);
        hari::create([
            'id_hari' => $hariid4,
            'nama_hari' => 'Kamis',
        ]);
        hari::create([
            'id_hari' => $hariid5,
            'nama_hari' => 'Jumat',
        ]);
        hari::create([
            'id_hari' => $hariid6,
            'nama_hari' => 'Sabtu',
        ]);
        // END HARI SEEDER

        // START KELAS MATA PELAJARAN (JADWAL) SEEDER
        $kelasmapelid1 = Str::uuid();
        $kelasmapelid2 = Str::uuid();
        $kelasmapelid3 = Str::uuid();
        $kelasmapelid4 = Str::uuid();
        $kelasmapelid5 = Str::uuid();
        $kelasmapelid6 = Str::uuid();
        $kelasmapelid7 = Str::uuid();
        $kelasmapelid8 = Str::uuid();
        $kelasmapelid9 = Str::uuid();
        $kelasmapelid10 = Str::uuid();
        $kelasmapelid11 = Str::uuid();
        $kelasmapelid12 = Str::uuid();

        session(key: ['kelasmapelid1' => $kelasmapelid1, 'kelasmapelid2' => $kelasmapelid2, 'kelasmapelid3' => $kelasmapelid3, 'guruid4' => $guruid4, 'kelasmapelid4' => $kelasmapelid4, 'kelasmapelid5' => $kelasmapelid5, 'kelasmapelid6' => $kelasmapelid6, 'kelasmapelid7' => $kelasmapelid7, 'kelasmapelid8' => $kelasmapelid8, 'kelasmapelid9' => $kelasmapelid9, 'kelasmapelid10' => $kelasmapelid10, 'kelasmapelid11' => $kelasmapelid11, 'kelasmapelid12' => $kelasmapelid12]);


        // kelas 7A, senin
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid1,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid1,
            'guru_id' => $guruid1,
            'hari_id' => $hariid1,
            'waktu_mulai' => '07:00',
            'waktu_selesai' => '09:00',
            'tahun_ajaran_id' => $tahunajaranid1,
        ]);
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid2,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid6,
            'guru_id' => $guruid5,
            'hari_id' => $hariid1,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
            'tahun_ajaran_id' => $tahunajaranid1,
        ]);

        // kelas 7A, selasa
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid3,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid2,
            'guru_id' => $guruid3,
            'hari_id' => $hariid2,
            'waktu_mulai' => '07:00',
            'waktu_selesai' => '09:00',
            'tahun_ajaran_id' => $tahunajaranid1,
        ]);
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid4,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid5,
            'guru_id' => $guruid3,
            'hari_id' => $hariid2,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
            'tahun_ajaran_id' => $tahunajaranid1,
        ]);

        // kelas 7A, rabu
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid5,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid3,
            'guru_id' => $guruid5,
            'hari_id' => $hariid3,
            'waktu_mulai' => '07:00',
            'waktu_selesai' => '09:00',
            'tahun_ajaran_id' => $tahunajaranid1,
        ]);
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid6,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid4,
            'guru_id' => $guruid1,
            'hari_id' => $hariid3,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
            'tahun_ajaran_id' => $tahunajaranid1,
        ]);

        // kelas 7A, senin
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid7,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid1,
            'guru_id' => $guruid1,
            'hari_id' => $hariid1,
            'waktu_mulai' => '07:00',
            'waktu_selesai' => '09:00',
            'tahun_ajaran_id' => $tahunajaranid2,
        ]);
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid8,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid6,
            'guru_id' => $guruid5,
            'hari_id' => $hariid1,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
            'tahun_ajaran_id' => $tahunajaranid2,
        ]);

        // kelas 7A, selasa
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid9,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid2,
            'guru_id' => $guruid3,
            'hari_id' => $hariid2,
            'waktu_mulai' => '07:00',
            'waktu_selesai' => '09:00',
            'tahun_ajaran_id' => $tahunajaranid2,
        ]);
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid10,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid5,
            'guru_id' => $guruid3,
            'hari_id' => $hariid2,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
            'tahun_ajaran_id' => $tahunajaranid2,
        ]);

        // kelas 7A, rabu
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid11,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid3,
            'guru_id' => $guruid5,
            'hari_id' => $hariid3,
            'waktu_mulai' => '07:00',
            'waktu_selesai' => '09:00',
            'tahun_ajaran_id' => $tahunajaranid2,
        ]);
        kelas_mata_pelajaran::create([
            'id_kelas_mata_pelajaran' => $kelasmapelid12,
            'kelas_id' => $kelasid1,
            'mata_pelajaran_id' => $mapelid4,
            'guru_id' => $guruid1,
            'hari_id' => $hariid3,
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '12:00',
            'tahun_ajaran_id' => $tahunajaranid2,
        ]);
        // END KELAS MATA PELAJARAN (JADWAL) SEEDER
    }
}
