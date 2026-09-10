<?php

namespace App\Imports;

use App\Models\soal_ujian;
use App\Models\ujian;
use Maatwebsite\Excel\Concerns\ToModel;

class SoalUjianImport implements ToModel
{
    protected $ujian_id;
    protected $judulUjian;

    public function __construct($ujian_id)
    {
        $this->ujian_id = $ujian_id;
        $u = ujian::find($ujian_id);
        $this->judulUjian = $u->judul ?? 'Ujian';
    }

    public function model(array $row)
    {
        // Filter baris yang seluruhnya kosong
        $hasData = false;
        foreach ($row as $val) {
            if (!is_null($val) && trim((string)$val) !== '') {
                $hasData = true;
                break;
            }
        }
        if (!$hasData) {
            return null;
        }

        // Abaikan baris header
        $firstCol = strtolower(trim((string)($row[0] ?? '')));
        $secondCol = strtolower(trim((string)($row[1] ?? '')));
        if (
            in_array($firstCol, ['no', 'no.', 'nomor', 'judul', 'judul_ujian', 'teks_soal', 'soal', 'pertanyaan']) ||
            in_array($secondCol, ['teks soal', 'teks_soal', 'soal', 'pertanyaan', 'isi soal'])
        ) {
            return null;
        }

        // Deteksi format: 7 Kolom vs 6 Kolom
        if (isset($row[6]) && !is_null($row[6])) {
            $teksSoal = trim((string)$row[1]);
            $opsiA = trim((string)$row[2]);
            $opsiB = trim((string)$row[3]);
            $opsiC = trim((string)$row[4]);
            $opsiD = trim((string)$row[5]);
            $rawKunci = trim((string)$row[6]);
        } elseif (isset($row[5]) && !is_null($row[5])) {
            $teksSoal = trim((string)$row[0]);
            $opsiA = trim((string)$row[1]);
            $opsiB = trim((string)$row[2]);
            $opsiC = trim((string)$row[3]);
            $opsiD = trim((string)$row[4]);
            $rawKunci = trim((string)$row[5]);
        } else {
            return null;
        }

        if (empty($teksSoal) || empty($opsiA) || empty($opsiB)) {
            return null;
        }

        // Normalisasi kunci jawaban ke format huruf kapital tunggal (A/B/C/D)
        $kunciJawaban = 'A';
        if (preg_match('/^[A-Da-d]/', $rawKunci, $matches)) {
            $kunciJawaban = strtoupper($matches[0]);
        } elseif (preg_match('/[A-Da-d]/', $rawKunci, $matches)) {
            $kunciJawaban = strtoupper($matches[0]);
        }

        // Bersihkan awalan opsi jika ada (contoh: "A. Pilihan" -> "Pilihan")
        $opsiA = preg_replace('/^[A-Da-d][\.\)]\s*/', '', $opsiA);
        $opsiB = preg_replace('/^[A-Da-d][\.\)]\s*/', '', $opsiB);
        $opsiC = preg_replace('/^[A-Da-d][\.\)]\s*/', '', $opsiC);
        $opsiD = preg_replace('/^[A-Da-d][\.\)]\s*/', '', $opsiD);

        return new soal_ujian([
            'ujian_id' => $this->ujian_id,
            'judul_ujian' => $this->judulUjian,
            'teks_soal' => $teksSoal,
            'opsi_a' => $opsiA,
            'opsi_b' => $opsiB,
            'opsi_c' => $opsiC ?: '-',
            'opsi_d' => $opsiD ?: '-',
            'kunci_jawaban' => $kunciJawaban,
        ]);
    }
}
