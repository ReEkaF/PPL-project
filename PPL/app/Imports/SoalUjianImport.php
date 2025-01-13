<?php

namespace App\Imports;

use App\Models\soal_ujian;
use Maatwebsite\Excel\Concerns\ToModel;

class SoalUjianImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $ujian_id;

    public function __construct($ujian_id)
    {
        $this->ujian_id = $ujian_id;
        // dd($ujian_id);
    }

    public function model(array $row)
    {
        // dd($row);
        if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[3]) || empty($row[4]) || empty($row[5]) || empty($row[6])) {
            throw new \Exception("Kolom yang diperlukan tidak boleh kosong.");
        }
        return new soal_ujian([
            'ujian_id'     => $this->ujian_id,
            'judul_ujian'  => $row[0],
            'teks_soal'    => $row[1],
            'opsi_a'       => $row[2],
            'opsi_b'       => $row[3],
            'opsi_c'       => $row[4],
            'opsi_d'       => $row[5],
            'kunci_jawaban'=> $row[6],
        ]);
    }
}
