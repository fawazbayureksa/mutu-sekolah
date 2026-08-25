<?php

namespace App\Exports\Sheets;

use App\Models\InstrumentSubmissionV2;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Sheet 2 – Data Instrumen (all submissions, grouped)
 *
 * Reuses the same section/column-header/sub-title helpers as
 * SubmissionV2DataSheet so every submission's instrument data is rendered
 * identically, separated by a school-banner row.
 */
class BulkDataSheet implements FromArray, WithTitle, WithStyles
{
    // Row-number buckets for styling
    private array $schoolBannerRows = [];
    private array $sectionTitleRows = [];
    private array $columnHeaderRows = [];
    private array $subTitleRows     = [];

    public function __construct(protected Collection $submissions) {}

    public function title(): string
    {
        return 'Data';
    }

    // =========================================================================
    // Main
    // =========================================================================

    public function array(): array
    {
        $rows = [];

        // Sheet title
        $rows[] = ['DATA INSTRUMEN PENJAMINAN MUTU SMK – SEMUA PENGAJUAN'];
        $this->schoolBannerRows[] = count($rows);   // reuse banner style for sheet title

        foreach ($this->submissions as $submission) {
            $rows[] = [];   // blank separator

            // ── School banner ─────────────────────────────────────────────
            $school = $submission->school;
            $rows[] = [
                ($school?->school_name ?? $submission->school_name ?? '–')
                . '  |  NPSN: ' . ($submission->npsn ?? $school?->npsn ?? '–')
                . '  |  ' . ($submission->expertise ?? $school?->expertise ?? '–'),
            ];
            $this->schoolBannerRows[] = count($rows);

            $rows[] = [
                'Status: ' . $this->statusLabel($submission->status)
                . '   Kelengkapan: ' . number_format($submission->completion_percentage ?? 0, 0) . '%'
                . '   Responden: ' . ($submission->respondent_name ?? '-')
                . ' (' . ($submission->respondent_position ?? '-') . ')',
            ];
            $this->subTitleRows[] = count($rows);

            // ── Instrument data sections ──────────────────────────────────
            $this->buildSections($rows, $submission);
        }

        if ($this->submissions->isEmpty()) {
            $rows[] = [];
            $rows[] = ['Tidak ada data pengajuan yang sesuai filter.'];
        }

        return $rows;
    }

    // =========================================================================
    // Sections (identical logic to SubmissionV2DataSheet)
    // =========================================================================

    private function buildSections(array &$rows, InstrumentSubmissionV2 $submission): void
    {
        $answers = $submission->answers ?? [];

        // -----------------------------------------------------------------
        // A.1.1 – Data Kelulusan Uji Kompetensi dan Sertifikasi
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'A.1.1', 'Data Kelulusan Uji Kompetensi dan Sertifikasi');
        $this->colHeaders($rows, [
            'No', 'Tahun Ajaran', 'Jenis Ujian/Sertifikasi',
            'Jumlah Peserta', 'Jumlah Lulus', 'Tingkat Kelulusan (%)',
            'Lembaga Penyelenggara', 'Keterangan',
        ]);
        $data = $this->parseSection($answers['A.1.1'] ?? null);
        foreach ($data['rows'] as $i => $r) {
            $rows[] = [
                $i + 1,
                $r['year'] ?? '-',
                $r['label'] ?? '-',
                $r['total_participants'] ?? '-',
                $r['total_passed'] ?? '-',
                $r['pass_rate'] ?? '-',
                $r['organizer'] ?? '-',
                $r['description'] ?? '-',
            ];
        }
        if (empty($data['rows'])) {
            $rows[] = ['', 'Tidak ada data'];
        }

        // -----------------------------------------------------------------
        // A.1.2 – Analisis Skema Sertifikasi dan Kesesuaian KKNI
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'A.1.2', 'Analisis Skema Sertifikasi dan Kesesuaian KKNI');
        $this->colHeaders($rows, [
            'No', 'Skema Sertifikasi', 'Jenis Kemasan', 'Jenjang KKNI',
            'Jumlah Unit Kompetensi', 'Kesesuaian', 'Keterangan',
        ]);
        $data = $this->parseSection($answers['A.1.2'] ?? null);
        foreach ($data['rows'] as $i => $r) {
            $rows[] = [
                $i + 1,
                $r['label'] ?? '-',
                $r['scheme_type'] ?? '-',
                $r['kkni_level'] ?? '-',
                $r['competency_units'] ?? '-',
                $r['compliance'] ?? '-',
                $r['remarks'] ?? '-',
            ];
        }
        if (empty($data['rows'])) {
            $rows[] = ['', 'Tidak ada data'];
        }

        // -----------------------------------------------------------------
        // A.2.1 – Penelusuran Alumni (Tracer Study)
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'A.2.1', 'Penelusuran Alumni (Tracer Study)');
        $this->colHeaders($rows, ['No', 'Pertanyaan', 'Standar Minimal SMK PK', 'Jawaban', 'Keterangan']);
        $data = $this->parseSection($answers['A.2.1'] ?? null);
        $tracerDefs = [
            ['key' => 'total_graduates',            'label' => 'Jumlah total lulusan',                                         'has_qualitative' => false],
            ['key' => 'employment_rate',            'label' => 'Persentase bekerja (karyawan)',                                'has_qualitative' => true,  'qlabel' => 'Sektor industri utama'],
            ['key' => 'waiting_time',               'label' => 'Rata-rata waktu tunggu mendapatkan pekerjaan pertama (bulan)', 'has_qualitative' => false],
            ['key' => 'job_relevance',              'label' => 'Kesesuaian bidang kerja dengan kompetensi keahlian (%)',        'has_qualitative' => false],
            ['key' => 'user_satisfaction',          'label' => 'Tingkat kepuasan pengguna (skala 1-5)',                        'has_qualitative' => true,  'qlabel' => 'Testimoni'],
            ['key' => 'entrepreneurship_rate',      'label' => 'Persentase berwirausaha/membuka usaha (%)',                   'has_qualitative' => true,  'qlabel' => 'Jenis usaha'],
            ['key' => 'entrepreneurship_relevance', 'label' => 'Persentase usaha terkait kompetensi keahlian (%)',             'has_qualitative' => false],
            ['key' => 'continuing_education',       'label' => 'Persentase yang melanjutkan kuliah (%)',                      'has_qualitative' => false],
        ];
        $rowsMap = [];
        foreach (($data['rows'] ?? []) as $row) {
            foreach ($row as $key => $val) {
                $rowsMap[$key] = $val;
            }
        }
        foreach ($tracerDefs as $i => $tr) {
            $quantitative = $rowsMap[$tr['key'] . '_quantitative'] ?? '-';
            $qualitative  = $tr['has_qualitative'] ? ($rowsMap[$tr['key'] . '_qualitative'] ?? '-') : '-';
            $stdMinimal   = $data['rows'][$i]['standard_minimal'] ?? '-';
            $rows[] = [$i + 1, $tr['label'], $stdMinimal, $quantitative, $qualitative];
        }

        // -----------------------------------------------------------------
        // A.3 – Data Putus Sekolah dan Ketidaknaikan Kelas
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'A.3', 'Data Putus Sekolah dan Ketidaknaikan Kelas');
        $this->colHeaders($rows, [
            'No', 'Tahun Ajaran', 'Jumlah Murid Awal', 'Jumlah Murid Akhir',
            'Jumlah Putus Sekolah', 'Jumlah Tidak Naik Kelas',
            '% Putus Sekolah', 'Faktor Utama Penyebab', 'Faktor Lainnya (Keterangan)',
        ]);
        $data = $this->parseSection($answers['A.3'] ?? null);
        foreach ($data['rows'] as $i => $r) {
            $rows[] = [
                $i + 1,
                $r['year'] ?? '-',
                $r['initial_students'] ?? '-',
                $r['final_students'] ?? '-',
                $r['dropouts'] ?? '-',
                $r['failed_students'] ?? '-',
                $r['dropout_percentage'] ?? '-',
                $r['main_factor'] ?? '-',
                $r['main_factor_other'] ?? '-',
            ];
        }
        if (empty($data['rows'])) {
            $rows[] = ['', 'Tidak ada data'];
        }

        // -----------------------------------------------------------------
        // A.4 – Data Skor Rata-rata TKA Tahun 2025
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'A.4', 'Data Skor Rata-rata TKA Tahun 2025');
        $this->colHeaders($rows, [
            'No', 'Mata Pelajaran', 'Rata-rata Nasional 2025', 'Rata-rata Sekolah 2025', 'Selisih (+/-)',
        ]);
        $a4Data     = $this->parseSection($answers['A.4'] ?? null);
        $a4Rows     = $a4Data['rows'] ?? [];
        $subjects   = [
            ['type' => 'header',  'label' => 'Wajib'],
            ['type' => 'subject', 'key' => 'bahasa_indonesia_wajib', 'label' => 'Bahasa Indonesia',               'national_avg' => 55.38],
            ['type' => 'subject', 'key' => 'matematika_wajib',       'label' => 'Matematika',                     'national_avg' => 36.1],
            ['type' => 'subject', 'key' => 'bahasa_inggris_wajib',   'label' => 'Bahasa Inggris',                 'national_avg' => 24.93],
            ['type' => 'header',  'label' => 'Pilihan:'],
            ['type' => 'subject', 'key' => 'ppkn',                   'label' => 'PPKN',                           'national_avg' => 60.91],
            ['type' => 'subject', 'key' => 'antropologi',            'label' => 'Antropologi',                    'national_avg' => 70.43],
            ['type' => 'subject', 'key' => 'projek_kreatif',         'label' => 'Projek Kreatif & Kewirausahaan', 'national_avg' => 56.34],
            ['type' => 'subject', 'key' => 'bahasa_indonesia_lanjut','label' => 'Bahasa Indonesia Lanjut',        'national_avg' => 68.02],
            ['type' => 'subject', 'key' => 'matematika_lanjut',      'label' => 'Matematika Lanjut',              'national_avg' => 39.32],
            ['type' => 'subject', 'key' => 'bahasa_inggris_lanjut',  'label' => 'Bahasa Inggris Lanjut',          'national_avg' => 45.23],
            ['type' => 'subject', 'key' => 'biologi',                'label' => 'Biologi',                        'national_avg' => 54.4],
            ['type' => 'subject', 'key' => 'sosiologi',              'label' => 'Sosiologi',                      'national_avg' => 60.07],
            ['type' => 'subject', 'key' => 'ekonomi',                'label' => 'Ekonomi',                        'national_avg' => 31.68],
            ['type' => 'subject', 'key' => 'kimia',                  'label' => 'Kimia',                          'national_avg' => 34.92],
            ['type' => 'subject', 'key' => 'sejarah',                'label' => 'Sejarah',                        'national_avg' => 62.72],
            ['type' => 'subject', 'key' => 'fisika',                 'label' => 'Fisika',                         'national_avg' => 37.65],
            ['type' => 'subject', 'key' => 'geografi',               'label' => 'Geografi',                       'national_avg' => 70.36],
            ['type' => 'subject', 'key' => 'bahasa_arab',            'label' => 'Bahasa Arab',                    'national_avg' => 64.97],
            ['type' => 'subject', 'key' => 'bahasa_jepang',          'label' => 'Bahasa Jepang',                  'national_avg' => 55.21],
            ['type' => 'subject', 'key' => 'bahasa_mandarin',        'label' => 'Bahasa Mandarin',                'national_avg' => 57.66],
            ['type' => 'subject', 'key' => 'bahasa_jerman',          'label' => 'Bahasa Jerman',                  'national_avg' => 36.59],
            ['type' => 'subject', 'key' => 'bahasa_korea',           'label' => 'Bahasa Korea',                   'national_avg' => 28.55],
            ['type' => 'subject', 'key' => 'bahasa_prancis',         'label' => 'Bahasa Prancis',                 'national_avg' => 45.05],
        ];
        $rowIndex  = 0;
        $rowNumber = 0;
        foreach ($subjects as $subject) {
            if ($subject['type'] === 'header') {
                $rows[] = ['', $subject['label']];
                $this->subTitleRows[] = count($rows);
                continue;
            }
            $rowData     = $a4Rows[$rowIndex] ?? [];
            $nationalAvg = $rowData[$subject['key'] . '_national_avg'] ?? number_format($subject['national_avg'], 2, '.', '');
            $schoolAvg   = $rowData[$subject['key'] . '_school_avg'] ?? '-';
            $diff        = $rowData[$subject['key'] . '_diff'] ?? ((is_numeric($schoolAvg) && is_numeric($nationalAvg))
                ? number_format($schoolAvg - $nationalAvg, 2, '.', '')
                : '-');
            $rowNumber++;
            $rows[] = [$rowNumber, $subject['label'], $nationalAvg, $schoolAvg, $diff];
            $rowIndex++;
        }

        // -----------------------------------------------------------------
        // B.sapras – Inventarisasi Sarana Prasarana
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'B.sapras', 'Inventarisasi Sarana Prasarana per Konsentrasi Keahlian');
        $saprasData = $answers['B.sapras'] ?? null;
        if (is_string($saprasData)) {
            $saprasData = json_decode($saprasData, true);
        }
        $saprasSections = $saprasData['sections'] ?? [];
        $labelMap = [
            'qty_available'     => 'Jumlah Tersedia',
            'condition'         => 'Kondisi',
            'industry_standard' => 'Kesesuaian Standar Industri',
            'document'          => 'Dokumen Pendukung',
            'remarks'           => 'Keterangan',
            'actual_area'       => 'Luas Tersedia (m²)',
            'available'         => 'Ada/Tidak',
            'compliance'        => 'Kesesuaian',
            'status'            => 'Status',
            'age'               => 'Usia',
            'source'            => 'Sumber',
            'spec'              => 'Spesifikasi',
        ];
        if (empty($saprasSections)) {
            $rows[] = ['', 'Tidak ada data sarana prasarana yang diisi.'];
        } else {
            foreach ($saprasSections as $si => $section) {
                $sectionLabel = 'B.' . ($si + 1) . ' - ' . ($section['title'] ?? 'Bagian ' . ($si + 1));
                $this->subTitle($rows, $sectionLabel);
                $sectionRows = $section['rows'] ?? [];
                if (empty($sectionRows)) {
                    $rows[] = ['', 'Tidak ada baris data.'];
                    continue;
                }
                $firstRow  = $sectionRows[0];
                $fieldKeys = array_keys(array_diff_key($firstRow, ['name' => '']));
                $headers   = ['#', 'Nama Item'];
                foreach ($fieldKeys as $fk) {
                    $headers[] = $labelMap[$fk] ?? ucwords(str_replace('_', ' ', $fk));
                }
                $this->colHeaders($rows, $headers);
                foreach ($sectionRows as $ri => $sRow) {
                    $dataRow = [$ri + 1, $sRow['name'] ?? '-'];
                    foreach ($fieldKeys as $fk) {
                        $dataRow[] = $sRow[$fk] ?? '-';
                    }
                    $rows[] = $dataRow;
                }
            }
        }

        // -----------------------------------------------------------------
        // C.1.1 – Kerjasama Industri
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'C.1.1', 'Kerjasama Industri');
        $this->colHeaders($rows, [
            'No', 'Nama Industri Mitra', 'Status MoU/MoA', 'Durasi (Tahun)',
            '1. Penyelarasan Kurikulum', '2. Guru Tamu', '3. Magang/PKL Siswa',
            '4. Sertifikasi (BNSP/LSP)', '5. Pelatihan Guru', '6. Penyerapan Lulusan',
            '7. Teaching Factory', '8. Kelas Industri', '9. CSR/Alat/Bahan/Beasiswa',
            '10. Lainnya', 'Kontribusi Kuantitatif', 'Kontribusi Kualitatif',
        ]);
        $data = $this->parseSection($answers['C.1.1'] ?? null);
        foreach ($data['rows'] as $i => $r) {
            $rows[] = [
                $i + 1,
                $r['partner_name'] ?? '-',
                $r['mou_status'] ?? '-',
                $r['duration'] ?? '-',
                $this->bool($r['program_kurikulum'] ?? null),
                $this->bool($r['program_guru'] ?? null),
                $this->bool($r['program_magang'] ?? null),
                $this->bool($r['program_sertifikasi'] ?? null),
                $this->bool($r['program_pelatihan'] ?? null),
                $this->bool($r['program_rekrutmen'] ?? null),
                $this->bool($r['program_tefa'] ?? null),
                $this->bool($r['program_kelas'] ?? null),
                $this->bool($r['program_csr'] ?? null),
                $r['program_lainnya_text'] ?? '-',
                $r['contribution_quantitative'] ?? '-',
                $r['contribution_qualitative'] ?? '-',
            ];
        }
        if (empty($data['rows'])) {
            $rows[] = ['', 'Tidak ada data'];
        }

        // -----------------------------------------------------------------
        // C.2.1 – Teaching Factory (TEFA) / Unit Produksi Sekolah
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'C.2.1', 'Teaching Factory (TEFA) / Unit Produksi Sekolah');
        $this->colHeaders($rows, [
            'No', 'Kategori TEFA', 'Nama Produk (Barang/Jasa)', 'Deskripsi Produk', 'Mitra Industri',
            '1. Identifikasi Produk', '2. Analisis Kompetensi', '3. Perencanaan Produksi',
            '4. Analisis Sumber Daya', '5. Pengerjaan Produk', '6. Penyerahan Produk',
            '7. Layanan Purna Jual', 'Sertifikasi Kompetensi', 'Sinkronisasi Kurikulum',
            'Branding/HAKI', 'Evaluasi Mutu Produk', 'Omzet (Rp/Bulan/Tahun)',
            'Keterlibatan Alumni/Industri', 'Kendala',
        ]);
        $data = $this->parseSection($answers['C.2.1'] ?? null);
        foreach ($data['rows'] as $i => $r) {
            $rows[] = [
                $i + 1,
                $r['kategori_tefa'] ?? '-',
                $r['product_name'] ?? '-',
                $r['product_description'] ?? '-',
                $r['industry_partner'] ?? '-',
                $this->bool($r['tefa_identifikasi'] ?? null),
                $this->bool($r['tefa_analisis_komp'] ?? null),
                $this->bool($r['tefa_perencanaan'] ?? null),
                $this->bool($r['tefa_analisis_sda'] ?? null),
                $this->bool($r['tefa_pengerjaan'] ?? null),
                $this->bool($r['tefa_penyerahan'] ?? null),
                $this->bool($r['tefa_purna_jual'] ?? null),
                $r['certification'] ?? '-',
                $r['curriculum_sync'] ?? '-',
                $r['branding_haki'] ?? '-',
                $r['quality_evaluation'] ?? '-',
                $r['revenue_activity'] ?? '-',
                $r['industry_contribution'] ?? '-',
                $r['constraints'] ?? '-',
            ];
        }
        if (empty($data['rows'])) {
            $rows[] = ['', 'Tidak ada data'];
        }

        // -----------------------------------------------------------------
        // C.3.1 – Data Pelatihan dan Sertifikasi Guru
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'C.3.1', 'Data Pelatihan dan Sertifikasi Guru');
        $this->colHeaders($rows, [
            'No', 'Nama Guru', 'Mata Pelajaran', 'Jenis Pelatihan/Sertifikasi',
            'Judul Pelatihan', 'Tahun', 'Penyedia', 'Durasi', 'Bukti', 'Keterangan',
        ]);
        $data = $this->parseSection($answers['C.3.1'] ?? null);
        foreach ($data['rows'] as $i => $r) {
            $rows[] = [
                $i + 1,
                $r['teacher_name'] ?? '-',
                $r['subject'] ?? '-',
                $r['competency_type'] ?? '-',
                $r['training_title'] ?? '-',
                $r['year'] ?? '-',
                $r['provider'] ?? '-',
                $r['duration'] ?? '-',
                $r['evidence'] ?? '-',
                $r['remarks'] ?? '-',
            ];
        }
        if (empty($data['rows'])) {
            $rows[] = ['', 'Tidak ada data'];
        }

        // -----------------------------------------------------------------
        // C.3.2 – Analisis Kebutuhan Pelatihan Guru ke Depan
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'C.3.2', 'Analisis Kebutuhan Pelatihan Guru ke Depan');
        $this->colHeaders($rows, ['No', 'Aspek', 'Kondisi Saat Ini', 'Kesenjangan']);
        $data = $this->parseSection($answers['C.3.2'] ?? null);
        $c32StaticRows = [
            'Persentase guru produktif bersertifikat kompetensi (BNSP/Industri)',
            'Rata-rata jam pelatihan per guru per tahun',
            'Keterlibatan dalam magang industri',
            'Frekuensi update teknologi/kompetensi',
            'Ketersediaan guru dengan sertifikat asesor BNSP',
        ];
        foreach ($c32StaticRows as $i => $label) {
            $r = $data['rows'][$i] ?? [];
            $rows[] = [$i + 1, $label, $r['current_condition'] ?? '-', $r['gap'] ?? '-'];
        }

        // -----------------------------------------------------------------
        // C.3.3 – Data Ketenagaan dan Beban Mengajar (Rasio Guru-Murid)
        // -----------------------------------------------------------------
        $this->sectionTitle($rows, 'C.3.3', 'Data Ketenagaan dan Beban Mengajar (Rasio Guru-Murid)');
        $this->colHeaders($rows, [
            'No', 'Konsentrasi Keahlian', 'Jumlah Guru (PNA)', 'Jumlah Total Murid',
            'Rasio Ideal (Guru PNA : Murid)', 'Rasio Guru:Murid (G:M)',
            'Jml Konsentrasi per Bidang', 'Jml Guru Produktif',
            'Rasio Ideal (Guru Produktif : Konsentrasi)', 'Rasio Guru Produktif : Konsentrasi',
            'Keterangan',
        ]);
        $data = $this->parseSection($answers['C.3.3'] ?? null);
        foreach ($data['rows'] as $i => $r) {
            $rows[] = [
                $i + 1,
                $r['concentration'] ?? '-',
                $r['total_teacher_count'] ?? '-',
                $r['student_count'] ?? '-',
                $r['ideal_ratio'] ?? '-',
                $r['ratio_gm'] ?? '-',
                $r['concentration_count'] ?? '-',
                $r['productive_teacher_count'] ?? '-',
                $r['ideal_productive_ratio'] ?? '-',
                $r['ratio_productive_concentration'] ?? '-',
                $r['remarks'] ?? '-',
            ];
        }
        if (empty($data['rows'])) {
            $rows[] = ['', 'Tidak ada data'];
        }
    }

    // =========================================================================
    // Styles
    // =========================================================================

    public function styles(Worksheet $sheet): void
    {
        $styleSchoolBanner = [
            'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1A3A52']],
        ];
        $styleSection = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF3D5A80']],
        ];
        $styleColHeader = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9E1F2']],
        ];
        $styleSubTitle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFF2CC']],
        ];

        $highestCol = $sheet->getHighestColumn();

        foreach ($this->schoolBannerRows as $rowNum) {
            $sheet->getStyle("A{$rowNum}:{$highestCol}{$rowNum}")->applyFromArray($styleSchoolBanner);
        }
        foreach ($this->sectionTitleRows as $rowNum) {
            $sheet->getStyle("A{$rowNum}:{$highestCol}{$rowNum}")->applyFromArray($styleSection);
        }
        foreach ($this->columnHeaderRows as $rowNum) {
            $sheet->getStyle("A{$rowNum}:{$highestCol}{$rowNum}")->applyFromArray($styleColHeader);
        }
        foreach ($this->subTitleRows as $rowNum) {
            $sheet->getStyle("A{$rowNum}:{$highestCol}{$rowNum}")->applyFromArray($styleSubTitle);
        }

        // Auto-size first few columns, cap column B
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getColumnDimension('B')->setWidth(38);
    }

    // =========================================================================
    // Helpers (mirrors SubmissionV2DataSheet)
    // =========================================================================

    private function bool(mixed $val): string
    {
        return !empty($val) ? 'Ya' : 'Tidak';
    }

    private function sectionTitle(array &$rows, string $code, string $title): void
    {
        $rows[] = [];
        $rows[] = ["{$code} – {$title}"];
        $this->sectionTitleRows[] = count($rows);
    }

    private function colHeaders(array &$rows, array $headers): void
    {
        $rows[] = $headers;
        $this->columnHeaderRows[] = count($rows);
    }

    private function subTitle(array &$rows, string $label): void
    {
        $rows[] = [$label];
        $this->subTitleRows[] = count($rows);
    }

    private function parseSection(mixed $data): array
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        return is_array($data) ? $data : ['header' => [], 'rows' => []];
    }

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
