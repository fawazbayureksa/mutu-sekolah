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
 *   No | Nama Sekolah | NPSN | Status Sekolah | Kategori Sekolah | Akreditasi |
 *   Durasi Program | Alamat | Provinsi | Kab/Kota | Bidang Keahlian |
 *   Program Keahlian | Konsentrasi Keahlian | Kurikulum | Status Kelayakan |
 *   Nama Responden | Jabatan Responden | Kontak Responden | Status |
 *   Kelengkapan (%) | Tgl Pengisian | Tgl Verifikasi | Verifikator |
 *   Catatan Verifikasi | Tgl Validasi | Validator | Catatan Validasi
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
            'Status Sekolah',
            'Kategori Sekolah',
            'Akreditasi',
            'Durasi Program',
            'Alamat',
            'Provinsi',
            'Kabupaten/Kota',
            'Bidang Keahlian',
            'Program Keahlian',
            'Konsentrasi Keahlian',
            'Kurikulum',
            'Status Kelayakan',
            'Nama Responden',
            'Jabatan Responden',
            'Kontak Responden',
            'Status',
            'Kelengkapan (%)',
            'Tanggal Pengisian',
            'Tanggal Verifikasi',
            'Diverifikasi Oleh',
            'Catatan Verifikasi',
            'Tanggal Validasi',
            'Divalidasi Oleh',
            'Catatan Validasi',
        ];

        // Data rows
        foreach ($this->submissions as $i => $s) {
            $school = $s->school;

            $rows[] = [
                $i + 1,
                $this->resolveValue($school?->school_name, $s->school_name),
                $this->resolveValue($s->npsn, $school?->npsn),
                $this->resolveValue($school?->school_status),
                $this->resolveValue($school?->school_category),
                $this->resolveValue($school?->school_accreditation),
                $this->resolveValue($school?->program_duration),
                $this->resolveValue($s->address, $school?->address),
                $this->resolveValue($s->province?->name, $school?->province?->name),
                $this->resolveValue($s->regency?->name, $school?->regency?->name),
                $this->resolveValue($s->expertise, $school?->expertise),
                $this->resolveValue($s->expertise_program, $school?->expertise_program),
                $this->resolveValue($s->expertise_concentration, $school?->expertise_concentration),
                $this->resolveValue($s->curriculum, $school?->curriculum),
                $this->resolveValue($s->approval_status, $school?->approval_status),
                $this->resolveValue($s->respondent_name),
                $this->resolveValue($s->respondent_position),
                $this->resolveValue($s->respondent_contact),
                $this->statusLabel($s->status),
                $s->completion_percentage !== null ? number_format((float) $s->completion_percentage, 0) . '%' : '-',
                $s->filled_at?->format('d/m/Y') ?? '-',
                $s->verified_at?->format('d/m/Y H:i') ?? ($s->verified_at?->format('d/m/Y') ?? '-'),
                $this->resolveValue($s->verifier?->name),
                $this->resolveValue($s->verification_notes),
                $s->validated_at?->format('d/m/Y H:i') ?? ($s->validated_at?->format('d/m/Y') ?? '-'),
                $this->resolveValue($s->validator?->name),
                $this->resolveValue($s->validation_notes),
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
            'A'  => 6,   // No
            'B'  => 38,  // Nama Sekolah
            'C'  => 14,  // NPSN
            'D'  => 16,  // Status Sekolah
            'E'  => 24,  // Kategori Sekolah
            'F'  => 14,  // Akreditasi
            'G'  => 16,  // Durasi Program
            'H'  => 35,  // Alamat
            'I'  => 22,  // Provinsi
            'J'  => 24,  // Kab/Kota
            'K'  => 28,  // Bidang Keahlian
            'L'  => 28,  // Program Keahlian
            'M'  => 28,  // Konsentrasi Keahlian
            'N'  => 18,  // Kurikulum
            'O'  => 18,  // Status Kelayakan
            'P'  => 25,  // Responden
            'Q'  => 22,  // Jabatan
            'R'  => 20,  // Kontak Responden
            'S'  => 14,  // Status
            'T'  => 16,  // Kelengkapan (%)
            'U'  => 18,  // Tgl Pengisian
            'V'  => 18,  // Tgl Verifikasi
            'W'  => 22,  // Verifikator
            'X'  => 40,  // Catatan Verifikasi
            'Y'  => 18,  // Tgl Validasi
            'Z'  => 22,  // Validator
            'AA' => 40,  // Catatan Validasi
        ];
    }

    // -------------------------------------------------------------------------

    private function resolveValue(mixed ...$values): string
    {
        foreach ($values as $val) {
            if (is_array($val)) {
                $filtered = array_filter($val, fn($v) => !is_null($v) && $v !== '');
                if (!empty($filtered)) {
                    return implode(', ', $filtered);
                }
            } elseif (!is_null($val) && $val !== '') {
                return (string) $val;
            }
        }

        return '-';
    }

    private function statusLabel(?string $status): string
    {
        return match ($status) {
            'draft'     => 'Draft',
            'submitted' => 'Diajukan',
            'verified'  => 'Diverifikasi',
            'validated' => 'Divalidasi',
            'rejected'  => 'Ditolak',
            default     => $status ? ucfirst($status) : '-',
        };
    }
}
