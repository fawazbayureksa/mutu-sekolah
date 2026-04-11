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
    public function __construct(protected InstrumentSubmissionV2 $submission) {}

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function array(): array
    {
        $s = $this->submission;

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
            ['RINGKASAN PENGAJUAN INSTRUMEN PENJAMINAN MUTU SMK', ''],
            [''],
            ['INFORMASI SEKOLAH', ''],
            ['Nama Sekolah',          $school?->school_name ?? $s->school_name ?? '-'],
            ['NPSN',                  $s->npsn ?? $school?->npsn ?? '-'],
            ['Alamat',                $s->address ?? $school?->address ?? '-'],
            ['Provinsi',              $s->province?->name ?? '-'],
            ['Kabupaten/Kota',        $s->regency?->name ?? '-'],
            ['Kurikulum',             $school?->curriculum ?? '-'],
            ['Bidang Keahlian',       $school?->expertise ?? '-'],
            ['Program Keahlian',      $school?->expertise_program ?? '-'],
            ['Konsentrasi Keahlian',  is_array($school?->expertise_concentration)
                ? implode(', ', $school->expertise_concentration)
                : ($school?->expertise_concentration ?? '-')],
            [''],
            ['INFORMASI RESPONDEN', ''],
            ['Nama Responden',        $s->respondent_name ?? '-'],
            ['Jabatan',               $s->respondent_position ?? '-'],
            [''],
            ['STATUS PENGAJUAN', ''],
            ['Status',                $statusLabel],
            ['Tanggal Pengisian',     $s->filled_at?->format('d/m/Y') ?? '-'],
            ['Tanggal Pengajuan',     $s->filled_at?->format('d/m/Y') ?? '-'],
            ['Diverifikasi Oleh',     $s->verifier?->name ?? '-'],
            ['Tanggal Verifikasi',    $s->verified_at?->format('d/m/Y H:i') ?? '-'],
            ['Catatan Verifikasi',    $s->verification_notes ?? '-'],
            ['Divalidasi Oleh',       $s->validator?->name ?? '-'],
            ['Tanggal Validasi',      $s->validated_at?->format('d/m/Y H:i') ?? '-'],
            ['Catatan Validasi',      $s->validation_notes ?? '-'],
            [''],
            ['Diekspor pada',         now()->format('d/m/Y H:i')],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Title row
            1 => [
                'font' => ['bold' => true, 'size' => 14],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF3D5A80'],
                ],
                'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
            ],
            // Section header rows
            3  => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9E1F2']]],
            14 => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9E1F2']]],
            18 => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9E1F2']]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 55,
        ];
    }
}
