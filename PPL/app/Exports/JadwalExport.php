<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JadwalExport implements FromCollection, WithHeadings
{
    protected $kelas_id;

    public function __construct($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }

    public function collection()
    {
        $query = DB::table('kelas_mata_pelajaran')
            ->join('kelas', 'kelas_mata_pelajaran.kelas_id', '=', 'kelas.id_kelas')
            ->join('mata_pelajaran', 'kelas_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id_matpel')
            ->join('guru', 'kelas_mata_pelajaran.guru_id', '=', 'guru.id_guru')
            ->join('hari', 'kelas_mata_pelajaran.hari_id', '=', 'hari.id_hari')
            ->join('tahun_ajaran', 'kelas_mata_pelajaran.tahun_ajaran_id', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select(
                'kelas.nama_kelas',
                'hari.nama_hari',
                'kelas_mata_pelajaran.waktu_mulai',
                'kelas_mata_pelajaran.waktu_selesai',
                'mata_pelajaran.nama_matpel',
                'guru.nama_guru'
            )
            ->where('tahun_ajaran.aktif', 1)
            ->orderByRaw('LENGTH(kelas.nama_kelas)')
            ->orderBy('kelas.nama_kelas')
            ->orderByRaw("FIELD(hari.nama_hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('kelas_mata_pelajaran.waktu_mulai');

        if ($this->kelas_id) {
            $query->where('kelas_mata_pelajaran.kelas_id', $this->kelas_id);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Kelas',
            'Hari',
            'Waktu Mulai',
            'Waktu Selesai',
            'Mata Pelajaran',
            'Guru'
        ];
    }
}