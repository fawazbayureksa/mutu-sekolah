<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionTemplateExport implements FromArray, WithColumnWidths, WithHeadings, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Template Import Pertanyaan';
    }

    public function array(): array
    {
        return [
            [
                'Q001',
                'IND001',
                'Apakah sekolah memiliki laboratorium komputer yang berfungsi?',
                'boolean',
                '1',
                '1',
                'true',
                '0',
                '1',
                'Jawab Ya jika laboratorium komputer berfungsi dan tersedia untuk siswa.',
                '',
            ],
            [
                'Q002',
                'IND001',
                'Berapa jumlah unit komputer yang berfungsi di laboratorium?',
                'number',
                '2',
                '2',
                'true',
                '0',
                '50',
                'Masukkan jumlah komputer yang berfungsi dengan baik.',
                '',
            ],
            [
                'Q003',
                'IND002',
                'Bagaimana kualitas jaringan internet di sekolah?',
                'scale',
                '3',
                '3',
                'true',
                '1',
                '5',
                'Nilai 1 = Sangat Buruk, 5 = Sangat Baik.',
                '',
            ],
            [
                'Q004',
                'IND002',
                'Jenis kurikulum yang digunakan:',
                'choice',
                '1',
                '4',
                'true',
                '',
                '',
                'Pilih salah satu kurikulum yang diterapkan.',
                'K13,Kurikulum Merdeka,Lainnya',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'question_code',
            'indicator_code',
            'question_text',
            'answer_type',
            'weight',
            'order',
            'is_required',
            'min_score',
            'max_score',
            'help_text',
            'answer_options',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getRowDimension(1)->setRowHeight(24);

        $styles = [
            1 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2E7D32'],
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
        ];

        // Highlight example rows
        foreach (range(2, 5) as $row) {
            $styles[$row] = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFF1F8E9'],
                ],
            ];
        }

        return $styles;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18,
            'B' => 18,
            'C' => 55,
            'D' => 18,
            'E' => 10,
            'F' => 10,
            'G' => 14,
            'H' => 12,
            'I' => 12,
            'J' => 45,
            'K' => 40,
        ];
    }
}
