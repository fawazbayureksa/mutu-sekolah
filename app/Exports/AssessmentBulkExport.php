<?php

namespace App\Exports;

use App\Models\Assessment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssessmentBulkExport implements FromCollection, WithColumnWidths, WithHeadings, WithStyles, WithTitle
{
    protected array $assessmentIds;

    public function __construct(array $assessmentIds)
    {
        $this->assessmentIds = $assessmentIds;
    }

    public function title(): string
    {
        return 'Bulk Assessments';
    }

    public function collection()
    {
        return Assessment::with(['school', 'instrument', 'verifier', 'approver'])
            ->whereIn('id', $this->assessmentIds)
            ->orderBy('assessment_date', 'desc')
            ->get()
            ->map(function (Assessment $assessment) {
                return [
                    'assessment_code' => $assessment->assessment_code,
                    'school_name' => $assessment->school?->school_name ?? '-',
                    'npsn' => $assessment->school?->npsn ?? '-',
                    'instrument' => $assessment->instrument?->name ?? '-',
                    'assessment_date' => $assessment->assessment_date?->format('d/m/Y') ?? '-',
                    'assessment_period' => ucfirst($assessment->assessment_period ?? '-'),
                    'status' => ucfirst($assessment->status),
                    'respondent_name' => $assessment->respondent_name ?? '-',
                    'respondent_position' => $assessment->respondent_position ?? '-',
                    'total_score' => $assessment->total_score !== null ? number_format((float) $assessment->total_score, 2) : '-',
                    'percentage' => $assessment->percentage !== null ? number_format((float) $assessment->percentage, 1).'%' : '-',
                    'completion' => $assessment->completion_percentage !== null ? number_format((float) $assessment->completion_percentage, 0).'%' : '-',
                    'verified_by' => $assessment->verifier?->name ?? '-',
                    'verified_at' => $assessment->verified_at?->format('d/m/Y') ?? '-',
                    'approved_by' => $assessment->approver?->name ?? '-',
                    'approved_at' => $assessment->approved_at?->format('d/m/Y') ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Asesmen',
            'Nama Sekolah',
            'NPSN',
            'Instrumen',
            'Tanggal Asesmen',
            'Periode',
            'Status',
            'Nama Responden',
            'Jabatan Responden',
            'Total Skor',
            'Persentase',
            'Kelengkapan (%)',
            'Diverifikasi Oleh',
            'Tanggal Verifikasi',
            'Disetujui Oleh',
            'Tanggal Persetujuan',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF1A3C5E'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 40,
            'C' => 14,
            'D' => 30,
            'E' => 16,
            'F' => 14,
            'G' => 14,
            'H' => 28,
            'I' => 24,
            'J' => 12,
            'K' => 12,
            'L' => 16,
            'M' => 24,
            'N' => 18,
            'O' => 24,
            'P' => 18,
        ];
    }
}
