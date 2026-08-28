<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Sheet 1 – Ringkasan (one row per submission)
 *
 * Columns:
 *   No | Nama Sekolah | NPSN | Provinsi | Kab/Kota | Bidang Keahlian |
 *   Program Keahlian | Kurikulum | Responden | Jabatan | Status |
 *   Kelengkapan (%) | Tgl Pengisian | Tgl Verifikasi | Verifikator |
 *   Tgl Validasi | Validator | Catatan Verifikasi | Catatan Validasi
 */
class BulkSummarySheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    // Row-number buckets for styling
    private int $titleRow     = 1;
    private int $headingRow   = 2;

    public function __construct(protected Collection $submissions) {}

    public function title(): string
    {
        return 'Ringkasan';
    }

    // -------------------------------------------------------------------------

    public function array(): array
    {
        $rows = [];

        // Row 1 – sheet title
        $rows[] = ['RINGKASAN DATA PENGAJUAN INSTRUMEN PENJAMINAN MUTU SMK'];

        // Row 2 – column headings
        $rows[] = [
            'No',
            'Nama Sekolah',
            'NPSN',
            'Provinsi',
            'Kabupaten/Kota',
            'Bidang Keahlian',
            'Program Keahlian',
            'Kurikulum',
            'Nama Responden',
            'Jabatan Responden',
            'Status',
            'Kelengkapan (%)',
            'Tanggal Pengisian',
            'Tanggal Verifikasi',
            'Diverifikasi Oleh',
            'Tanggal Validasi',
            'Divalidasi Oleh',
            'Catatan Verifikasi',
            'Catatan Validasi',
        ];

        // Data rows
        foreach ($this->submissions as $i => $s) {
            $school = $s->school;

            $rows[] = [
                $i + 1,
                $school?->school_name ?? $s->school_name ?? '-',
                $s->npsn ?? $school?->npsn ?? '-',
                $s->province?->name ?? '-',
                $s->regency?->name ?? '-',
                $s->expertise ?? $school?->expertise ?? '-',
                $s->expertise_program ?? $school?->expertise_program ?? '-',
                $s->curriculum ?? $school?->curriculum ?? '-',
                $s->respondent_name ?? '-',
                $s->respondent_position ?? '-',
                $this->statusLabel($s->status),
                $s->completion_percentage ? number_format($s->completion_percentage, 0) . '%' : '-',
                $s->filled_at?->format('d/m/Y') ?? '-',
                $s->verified_at?->format('d/m/Y') ?? '-',
                $s->verifier?->name ?? '-',
                $s->validated_at?->format('d/m/Y') ?? '-',
                $s->validator?->name ?? '-',
                $s->verification_notes ?? '-',
                $s->validation_notes ?? '-',
            ];
        }

        // Footer
        $rows[] = [];
        $rows[] = ['Diekspor pada: ' . now()->format('d/m/Y H:i')];

        return $rows;
    }

    // -------------------------------------------------------------------------

    public function styles(Worksheet $sheet): array
    {
        $blue  = 'FF3D5A80';
        $light = 'FFD9E1F2';

        return [
            $this->titleRow => [
                'font' => ['bold' => true, 'size' => 13, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $blue]],
            ],
            $this->headingRow => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $light]],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' =>  6,   // No
            'B' => 38,   // Nama Sekolah
            'C' => 14,   // NPSN
            'D' => 22,   // Provinsi
            'E' => 24,   // Kab/Kota
            'F' => 28,   // Bidang Keahlian
            'G' => 28,   // Program Keahlian
            'H' => 20,   // Kurikulum
            'I' => 25,   // Responden
            'J' => 22,   // Jabatan
            'K' => 14,   // Status
            'L' => 14,   // Kelengkapan
            'M' => 16,   // Tgl Pengisian
            'N' => 16,   // Tgl Verifikasi
            'O' => 22,   // Verifikator
            'P' => 16,   // Tgl Validasi
            'Q' => 22,   // Validator
            'R' => 40,   // Catatan Verifikasi
            'S' => 40,   // Catatan Validasi
        ];
    }

    // -------------------------------------------------------------------------

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'draft'     => 'Draft',
            'submitted' => 'Diajukan',
            'verified'  => 'Diverifikasi',
            'validated' => 'Divalidasi',
            'rejected'  => 'Ditolak',
            default     => ucfirst($status),
        };
    }
}
