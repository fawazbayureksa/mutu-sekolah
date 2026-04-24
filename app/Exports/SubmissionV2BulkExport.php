<?php

namespace App\Exports;

use App\Models\InstrumentSubmissionV2;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubmissionV2BulkExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    public function title(): string
    {
        return 'Semua Pengajuan';
    }

    public function collection()
    {
        return InstrumentSubmissionV2::with(['school', 'province', 'regency', 'verifier', 'validator'])
            ->latest('filled_at')
            ->get()
            ->map(function (InstrumentSubmissionV2 $s) {
                $statusLabel = match ($s->status) {
                    'draft'     => 'Draft',
                    'submitted' => 'Diajukan',
                    'verified'  => 'Diverifikasi',
                    'validated' => 'Divalidasi',
                    'rejected'  => 'Ditolak',
                    default     => ucfirst($s->status),
                };

                $school = $s->school;

                return [
                    'id'                  => $s->id,
                    'school_name'         => $school?->school_name ?? $s->school_name ?? '-',
                    'npsn'                => $s->npsn ?? $school?->npsn ?? '-',
                    'province'            => $s->province?->name ?? '-',
                    'regency'             => $s->regency?->name ?? '-',
                    'curriculum'          => $school?->curriculum ?? '-',
                    'expertise'           => $school?->expertise ?? '-',
                    'expertise_program'   => $school?->expertise_program ?? '-',
                    'respondent_name'     => $s->respondent_name ?? '-',
                    'respondent_position' => $s->respondent_position ?? '-',
                    'status'              => $statusLabel,
                    'completion'          => $s->completion_percentage ? number_format($s->completion_percentage, 0) . '%' : '-',
                    'filled_at'           => $s->filled_at?->format('d/m/Y') ?? '-',
                    'verified_at'         => $s->verified_at?->format('d/m/Y') ?? '-',
                    'verified_by'         => $s->verifier?->name ?? '-',
                    'validated_at'        => $s->validated_at?->format('d/m/Y') ?? '-',
                    'validated_by'        => $s->validator?->name ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Sekolah',
            'NPSN',
            'Provinsi',
            'Kabupaten/Kota',
            'Kurikulum',
            'Bidang Keahlian',
            'Program Keahlian',
            'Nama Responden',
            'Jabatan Responden',
            'Status',
            'Kelengkapan (%)',
            'Tanggal Pengisian',
            'Tanggal Verifikasi',
            'Diverifikasi Oleh',
            'Tanggal Validasi',
            'Divalidasi Oleh',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF3D5A80'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 40,
            'C' => 14,
            'D' => 22,
            'E' => 24,
            'F' => 20,
            'G' => 30,
            'H' => 30,
            'I' => 25,
            'J' => 22,
            'K' => 14,
            'L' => 14,
            'M' => 16,
            'N' => 16,
            'O' => 22,
            'P' => 16,
            'Q' => 22,
        ];
    }
}
