<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixC11MouDuration extends Command
{
    protected $signature = 'fix:c11-mou-duration
                            {--dry-run : Preview perubahan tanpa menyimpan ke database}
                            {--base-year= : Tahun dasar untuk menghitung durasi (default: tahun submission dibuat)}
                            {--min-year=2019 : Batas minimum nilai tahun yang dianggap tidak valid (default: 2019)}
                            {--max-year=2035 : Batas maksimum nilai tahun yang dianggap tidak valid (default: 2035)}';

    protected $description = 'Perbaiki data durasi MoU pada C.1.1 yang diisi tahun (2020-2030) bukan jumlah tahun durasi. Konversi: durasi_valid = tahun_diisi - tahun_submission_dibuat (min 1).';

    public function handle(): int
    {
        $isDryRun  = $this->option('dry-run');
        $baseYear  = $this->option('base-year') ? (int) $this->option('base-year') : null;
        $minYear   = (int) $this->option('min-year');
        $maxYear   = (int) $this->option('max-year');

        $this->info('');
        $this->info('======================================================');
        $this->info('  Fix C.1.1 MoU Duration — Tahun → Jumlah Tahun');
        $this->info('======================================================');
        $this->line("  Mode      : " . ($isDryRun ? 'DRY RUN (tidak ada perubahan)' : 'APPLY FIX (akan menyimpan ke DB)'));
        $this->line("  Base Year : " . ($baseYear ? $baseYear : 'otomatis (tahun submission)'));
        $this->line("  Range     : {$minYear} – {$maxYear}");
        $this->info('');

        if (!$isDryRun) {
            if (!$this->confirm('Apakah Anda yakin ingin menyimpan perubahan ke database?', false)) {
                $this->warn('Dibatalkan. Gunakan --dry-run untuk preview terlebih dahulu.');
                return self::FAILURE;
            }
        }

        $invalidDetails = DB::select("
            SELECT DISTINCT d.id AS detail_id, d.submission_id, d.data,
                            s.school_name, s.npsn,
                            YEAR(s.created_at) AS submission_year
            FROM instrument_submission_v2_details AS d
            JOIN instrument_submissions_v2 AS s ON s.id = d.submission_id
            JOIN JSON_TABLE(
                d.data,
                '\$.rows[*]' COLUMNS (
                    partner_name VARCHAR(255) PATH '\$.partner_name',
                    duration     VARCHAR(50)  PATH '\$.duration'
                )
            ) AS jt ON TRUE
            WHERE d.section_code = 'C.1.1'
              AND NULLIF(TRIM(jt.partner_name), '') IS NOT NULL
              AND CAST(NULLIF(TRIM(jt.duration), '') AS DECIMAL(10,2)) BETWEEN ? AND ?
        ", [$minYear, $maxYear]);

        if (empty($invalidDetails)) {
            $this->info('Tidak ada data durasi tidak valid yang ditemukan.');
            return self::SUCCESS;
        }

        $this->info("Ditemukan " . count($invalidDetails) . " record detail yang perlu diperiksa.\n");

        $tableHeader = ['Detail ID', 'Sub ID', 'Sekolah', 'Mitra', 'Durasi Lama', 'Durasi Baru (Tahun)', 'Status'];
        $tableRows   = [];
        $totalFixed  = 0;

        foreach ($invalidDetails as $detail) {
            $raw  = $detail->data;
            $data = is_string($raw) ? (json_decode($raw, true) ?? []) : (array) $raw;
            $rows = $data['rows'] ?? (isset($data[0]) ? $data : []);

            if (empty($rows)) continue;

            $changed      = false;
            $usedBaseYear = $baseYear ?? (int) $detail->submission_year;

            foreach ($rows as &$row) {
                if (!is_array($row)) continue;

                $durStr = trim($row['duration'] ?? '');
                if ($durStr === '') continue;
                if (!preg_match('/^\d+(\.\d+)?$/', $durStr)) continue;

                $durNum = (float) $durStr;
                if ($durNum < $minYear || $durNum > $maxYear) continue;

                // Hitung durasi baru: tahun_diisi - base_year, minimal 1
                $newDuration = max(1, (int) round($durNum) - $usedBaseYear);

                $tableRows[] = [
                    $detail->detail_id,
                    $detail->submission_id,
                    mb_substr($detail->school_name, 0, 28),
                    mb_substr($row['partner_name'] ?? '-', 0, 25),
                    $durStr,
                    $newDuration,
                    $isDryRun ? 'preview' : 'FIXED',
                ];

                $row['duration'] = (string) $newDuration;
                $changed = true;
                $totalFixed++;
            }
            unset($row);

            if ($changed && !$isDryRun) {
                $data['rows'] = $rows;
                DB::table('instrument_submission_v2_details')
                    ->where('id', $detail->detail_id)
                    ->update(['data' => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)]);
            }
        }

        $this->table($tableHeader, $tableRows);

        $this->info('');
        $this->info('======================================================');

        if ($isDryRun) {
            $this->info("DRY RUN SELESAI: {$totalFixed} baris akan diubah.");
            $this->info("Jalankan tanpa --dry-run untuk mengaplikasikan perubahan.");
        } else {
            $this->info("PERBAIKAN SELESAI: {$totalFixed} baris berhasil diperbarui.");
        }

        $this->info("======================================================\n");

        return self::SUCCESS;
    }
}
