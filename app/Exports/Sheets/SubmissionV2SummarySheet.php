<?php

namespace App\Exports\Sheets;

use App\Models\InstrumentSubmissionV2;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubmissionV2SummarySheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    private array $sectionHeaderRows = [];

    public function __construct(protected InstrumentSubmissionV2 $submission) {}

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function array(): array
    {
        $this->sectionHeaderRows = [];
        $s = $this->submission;

        $statusLabel = match ($s->status) {
            'draft'     => 'Draft',
            'submitted' => 'Diajukan',
            'verified'  => 'Diverifikasi',
            'validated' => 'Divalidasi',
            'rejected'  => 'Ditolak',
            default     => $s->status ? ucfirst($s->status) : '-',
        };

        $school = $s->school;

        $rows = [
            ['RINGKASAN PENGAJUAN INSTRUMEN PENJAMINAN MUTU SMK', ''],
            [''],
        ];

        // ── Informasi Sekolah ──
        $rows[] = ['INFORMASI SEKOLAH', ''];
        $this->sectionHeaderRows[] = count($rows);
        $rows[] = ['Nama Sekolah',          $this->resolveValue($school?->school_name, $s->school_name)];
        $rows[] = ['NPSN',                  $this->resolveValue($s->npsn, $school?->npsn)];
        $rows[] = ['Status Sekolah',        $this->resolveValue($school?->school_status)];
        $rows[] = ['Kategori Sekolah',      $this->resolveValue($school?->school_category)];
        $rows[] = ['Akreditasi',            $this->resolveValue($school?->school_accreditation)];
        $rows[] = ['Durasi Program',        $this->resolveValue($school?->program_duration)];
        $rows[] = ['Alamat',                $this->resolveValue($s->address, $school?->address)];
        $rows[] = ['Provinsi',              $this->resolveValue($s->province?->name, $school?->province?->name)];
        $rows[] = ['Kabupaten/Kota',        $this->resolveValue($s->regency?->name, $school?->regency?->name)];
        $rows[] = ['Bidang Keahlian',       $this->resolveValue($s->expertise, $school?->expertise)];
        $rows[] = ['Program Keahlian',      $this->resolveValue($s->expertise_program, $school?->expertise_program)];
        $rows[] = ['Konsentrasi Keahlian',  $this->resolveValue($s->expertise_concentration, $school?->expertise_concentration)];
        $rows[] = ['Kurikulum',             $this->resolveValue($s->curriculum, $school?->curriculum)];
        $rows[] = ['Status Kelayakan',      $this->resolveValue($s->approval_status, $school?->approval_status)];
        $rows[] = [''];

        // ── Informasi Responden ──
        $rows[] = ['INFORMASI RESPONDEN', ''];
        $this->sectionHeaderRows[] = count($rows);
        $rows[] = ['Nama Responden',        $this->resolveValue($s->respondent_name)];
        $rows[] = ['Jabatan',               $this->resolveValue($s->respondent_position)];
        $rows[] = ['Kontak Responden',      $this->resolveValue($s->respondent_contact)];
        $rows[] = [''];

        // ── Status Pengajuan ──
        $rows[] = ['STATUS PENGAJUAN', ''];
        $this->sectionHeaderRows[] = count($rows);
        $rows[] = ['Status',                $statusLabel];
        $rows[] = ['Kelengkapan (%)',       $s->completion_percentage !== null ? number_format((float) $s->completion_percentage, 0) . '%' : '-'];
        $rows[] = ['Tanggal Pengisian',     $s->filled_at?->format('d/m/Y') ?? '-'];
        $rows[] = ['Diverifikasi Oleh',     $this->resolveValue($s->verifier?->name)];
        $rows[] = ['Tanggal Verifikasi',    $s->verified_at?->format('d/m/Y H:i') ?? '-'];
        $rows[] = ['Catatan Verifikasi',    $this->resolveValue($s->verification_notes)];
        $rows[] = ['Divalidasi Oleh',       $this->resolveValue($s->validator?->name)];
        $rows[] = ['Tanggal Validasi',      $s->validated_at?->format('d/m/Y H:i') ?? '-'];
        $rows[] = ['Catatan Validasi',      $this->resolveValue($s->validation_notes)];
        $rows[] = [''];
        $rows[] = ['Diekspor pada',         now()->format('d/m/Y H:i')];

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        $blue  = 'FF3D5A80';
        $light = 'FFD9E1F2';

        $styles = [
            // Title row
            1 => [
                'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => $blue],
                ],
            ],
        ];

        foreach ($this->sectionHeaderRows as $rowNum) {
            $styles[$rowNum] = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => $light],
                ],
            ];
        }

        return $styles;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 55,
        ];
    }

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
}
