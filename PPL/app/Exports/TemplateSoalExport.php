<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateSoalExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * Headings untuk template excel soal ujian
     */
    public function headings(): array
    {
        return [
            'No',
            'Teks Soal',
            'Pilihan A',
            'Pilihan B',
            'Pilihan C',
            'Pilihan D',
            'Kunci Jawaban',
        ];
    }

    /**
     * Baris contoh data untuk panduan guru
     */
    public function array(): array
    {
        return [
            [
                '1',
                'Hasil dari perhitungan 125 + 75 : 5 adalah...',
                '40',
                '140',
                '150',
                '160',
                'B',
            ],
            [
                '2',
                'Perhatikan kalimat berikut: "Ibu memasak nasi di dapur." Pola kalimat tersebut adalah...',
                'S - P - O - K',
                'S - P - Pel - K',
                'K - S - P - O',
                'S - P - K',
                'A',
            ],
            [
                '3',
                'Organ tubuh manusia yang berfungsi memompa darah ke seluruh tubuh adalah...',
                'Paru-paru',
                'Ginjal',
                'Jantung',
                'Hati',
                'C',
            ],
            [
                '4',
                'Planet terbesar di tata surya kita adalah...',
                'Mars',
                'Bumi',
                'Saturnus',
                'Jupiter',
                'D',
            ],
            [
                '5',
                'Semboyan bangsa Indonesia "Bhinneka Tunggal Ika" memiliki arti...',
                'Berbeda-beda tetapi tetap satu jua',
                'Bersatu kita teguh bercerai kita runtuh',
                'Maju terus pantang mundur',
                'Gotong royong membangun bangsa',
                'A',
            ],
        ];
    }

    /**
     * Styling header dan tabel
     */
    public function styles(Worksheet $sheet)
    {
        // Styling baris 1 (Header)
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1E3A8A'], // Navy/Blue
            ],
        ]);

        // Alignment kolom No dan Kunci Jawaban di tengah
        $sheet->getStyle('A2:A100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2:G100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Border tipis untuk data
        $sheet->getStyle('A1:G6')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFCBD5E1'],
                ],
            ],
        ]);

        // Tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(28);

        return [];
    }
}
