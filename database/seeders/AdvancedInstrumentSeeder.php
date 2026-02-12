<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use App\Models\AssessmentIndicator;
use App\Models\AssessmentQuestion;
use App\Models\Instrument;
use App\Models\InstrumentItem;
use App\Models\ScaleTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdvancedInstrumentSeeder extends Seeder
{
    /**
     * Seed the advanced instrument with hierarchical structure
     * Aspects → Indicators → Questions with scale templates
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Get scale templates
            $qualityScale = ScaleTemplate::where('code', 'QUALITY_5')->first();
            $conformityScale = ScaleTemplate::where('code', 'CONFORMITY_5')->first();
            $yesNoScale = ScaleTemplate::where('code', 'YES_NO')->first();
            $conditionScale = ScaleTemplate::where('code', 'CONDITION_4')->first();
            $frequencyScale = ScaleTemplate::where('code', 'FREQUENCY_5')->first();

            if (!$qualityScale || !$conformityScale || !$yesNoScale) {
                $this->command->error('Scale templates not found. Run ScaleTemplateSeeder first.');
                return;
            }

            // Create the instrument
            $instrument = Instrument::updateOrCreate(
                ['code' => 'KPTK-ADV-2024'],
                [
                    'name' => 'Instrumen Penjaminan Mutu SMK Bidang KPTK (Advanced)',
                    'description' => 'Instrumen pemetaan mutu SMK bidang Kelautan, Perikanan, Teknologi Informasi dan Komunikasi berdasarkan standar nasional pendidikan vokasi.',
                    'category' => 'penjaminan_mutu',
                    'version' => '2.0',
                    'is_active' => true,
                    'is_published' => true,
                    'published_at' => now(),
                    'instructions' => 'Silakan isi instrumen berikut dengan jujur dan sesuai kondisi sekolah Anda. Setiap pertanyaan memiliki pilihan jawaban yang berbeda sesuai jenis indikator.',
                    'estimated_duration' => 30,
                    'scoring_method' => 'weighted_sum',
                ]
            );

            $order = 0;

            // =========================
            // ASPECT A: Standar Peserta Didik
            // =========================
            $aspectA = AssessmentAspect::updateOrCreate(
                ['code' => 'A'],
                ['name' => 'Standar Peserta Didik (Kompetensi & Kesiapan Kerja)', 'order' => 1]
            );

            // Indicator A.1: Data Kompetensi (UKK & Sertifikasi)
            $indicatorA1 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectA->id, 'code' => 'A.1'],
                ['description' => 'Data Kompetensi (UKK & Sertifikasi)', 'order' => 1]
            );

            // Question A.1.1: Table input
            $tableConfigA1 = [
                'type' => 'table',
                'show_row_number' => true,
                'row_label_header' => 'Nama Ujian/Sertifikasi',
                'columns' => [
                    ['key' => 'year', 'label' => 'Tahun', 'type' => 'number', 'width' => '10%'],
                    ['key' => 'total_participants', 'label' => 'Jumlah Peserta', 'type' => 'number', 'width' => '15%'],
                    ['key' => 'total_passed', 'label' => 'Jumlah Lulus', 'type' => 'number', 'width' => '15%'],
                    ['key' => 'pass_rate', 'label' => 'Tingkat Kelulusan (%)', 'type' => 'percentage', 'width' => '15%', 'read_only' => true, 'calculate' => '(row.total_passed / row.total_participants) * 100'],
                    ['key' => 'organizer', 'label' => 'Lembaga Sertifikasi/Penyelenggara', 'type' => 'text', 'width' => '25%'],
                ],
                'rows' => [
                    ['label' => 'Uji Kompetensi Keahlian (UKK) Mandiri'],
                    ['label' => 'Uji Kompetensi Keahlian (UKK) LSP'],
                    ['label' => 'Sertifikasi Profesi (Contoh: BNSP, TOEIC, dll)']
                ]
            ];

            $questionsA1 = [
                [
                    'code' => 'A.1.1',
                    'text' => 'Data Kelulusan Uji Kompetensi dan Sertifikasi',
                    'help' => 'Isi data kelulusan UKK dan sertifikasi profesi untuk tahun terakhir',
                    'type' => 'structure',
                    'scale_id' => null,
                    'options' => json_encode($tableConfigA1)
                ]
            ];

            // Indicator A.2: Penelusuran Alumni (Tracer Study)
            $indicatorA2 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectA->id, 'code' => 'A.2'],
                ['description' => 'Penelusuran Alumni (Tracer Study)', 'order' => 2]
            );

            // Table config for A.2.1: Tracer Study
            $tableConfigA2 = [
                'type' => 'table',
                'show_row_number' => true,
                'row_label_header' => 'Pertanyaan',
                'header_input' => [
                    'key' => 'graduation_class',
                    'label' => 'Kelas Lulusan',
                    'type' => 'text',
                    'placeholder' => 'Contoh: 2024/2025'
                ],
                'columns' => [
                    ['key' => 'quantitative', 'label' => 'Jawaban (Kuantitatif)', 'type' => 'text', 'width' => '25%'],
                    ['key' => 'qualitative', 'label' => 'Kualitatif (Jika Ada)', 'type' => 'text', 'width' => '35%']
                ],
                'rows' => [
                    [
                        'key' => 'total_graduates',
                        'label' => 'Jumlah total lulusan',
                        'question' => 'Jumlah total lulusan',
                        'quantitative_type' => 'number',
                        'quantitative_unit' => null,
                        'quantitative_placeholder' => 'Masukkan jumlah',
                        'has_qualitative' => false,
                        'qualitative_placeholder' => null
                    ],
                    [
                        'key' => 'employment_rate',
                        'label' => 'Persentase bekerja (karyawan)',
                        'question' => 'Persentase bekerja (karyawan)',
                        'quantitative_type' => 'percentage',
                        'quantitative_unit' => '%',
                        'quantitative_placeholder' => '%',
                        'has_qualitative' => true,
                        'qualitative_label' => 'Sebutkan sektor industri utama:',
                        'qualitative_placeholder' => 'Sebutkan sektor industri utama:'
                    ],
                    [
                        'key' => 'waiting_time',
                        'label' => 'Rata-rata waktu tunggu mendapatkan pekerjaan pertama',
                        'question' => 'Rata-rata waktu tunggu mendapatkan pekerjaan pertama',
                        'quantitative_type' => 'number',
                        'quantitative_unit' => 'bulan',
                        'quantitative_placeholder' => 'bulan',
                        'has_qualitative' => false,
                        'qualitative_placeholder' => null
                    ],
                    [
                        'key' => 'job_relevance',
                        'label' => 'Kesesuaian bidang kerja dengan kompetensi keahlian',
                        'question' => 'Kesesuaian bidang kerja dengan kompetensi keahlian',
                        'quantitative_type' => 'percentage',
                        'quantitative_unit' => '%',
                        'quantitative_placeholder' => '%',
                        'has_qualitative' => false,
                        'qualitative_placeholder' => null
                    ],
                    [
                        'key' => 'user_satisfaction',
                        'label' => 'Tingkat kepuasan pengguna (dalam skala 1-5)',
                        'question' => 'Tingkat kepuasan pengguna (dalam skala 1-5)',
                        'quantitative_type' => 'scale',
                        'quantitative_min' => 1,
                        'quantitative_max' => 5,
                        'quantitative_placeholder' => '1-5',
                        'has_qualitative' => true,
                        'qualitative_label' => 'Testimoni/ulasan dari alumni/industri:',
                        'qualitative_placeholder' => 'Testimoni/ulasan dari alumni/industri:'
                    ],
                    [
                        'key' => 'entrepreneurship_rate',
                        'label' => 'Persentase berwirausaha/membuka usaha',
                        'question' => 'Persentase berwirausaha/membuka usaha',
                        'quantitative_type' => 'percentage',
                        'quantitative_unit' => '%',
                        'quantitative_placeholder' => '%',
                        'has_qualitative' => true,
                        'qualitative_label' => 'Jenis usaha yang dikembangkan:',
                        'qualitative_placeholder' => 'Jenis usaha yang dikembangkan:'
                    ],
                    [
                        'key' => 'entrepreneurship_relevance',
                        'label' => 'Dari yang berwirausaha, persentase yang usahanya terkait dengan kompetensi keahlian SMK',
                        'question' => 'Dari yang berwirausaha, persentase yang usahanya terkait dengan kompetensi keahlian SMK',
                        'quantitative_type' => 'percentage',
                        'quantitative_unit' => '%',
                        'quantitative_placeholder' => '%',
                        'has_qualitative' => false,
                        'qualitative_placeholder' => null
                    ],
                    [
                        'key' => 'continuing_education',
                        'label' => 'Persentase yang melanjutkan kuliah',
                        'question' => 'Persentase yang melanjutkan kuliah',
                        'quantitative_type' => 'percentage',
                        'quantitative_unit' => '%',
                        'quantitative_placeholder' => '%',
                        'has_qualitative' => false,
                        'qualitative_placeholder' => null
                    ]
                ]
            ];

            // Questions for A.2
            $questionsA2 = [
                [
                    'code' => 'A.2.1',
                    'text' => 'Penelusuran Alumni (Tracer Study)',
                    'help' => 'Isi data penelusuran alumni berdasarkan tracer study untuk kelas lulusan tertentu',
                    'type' => 'structure',
                    'scale_id' => null,
                    'options' => json_encode($tableConfigA2)
                ]
            ];

            foreach ($questionsA1 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorA1->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'answer_options' => $q['options'] ?? null,
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'A. Standar Peserta Didik',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }

            foreach ($questionsA2 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorA2->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'answer_options' => $q['options'] ?? null,
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'A. Standar Peserta Didik',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }



            // =========================
            // ASPECT B: DATA SARANA PRASARANA (Sapras)
            // =========================
            $aspectB = AssessmentAspect::updateOrCreate(
                ['code' => 'B'],
                ['name' => 'Data Sarana Prasarana (Sapras)', 'order' => 2]
            );

            // Indicator B.1: Inventarisasi dan Kesesuaian dengan Standar Industri
            $indicatorB1 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectB->id, 'code' => 'B.1'],
                ['description' => 'Inventarisasi dan Kesesuaian dengan Standar Industri', 'order' => 1]
            );

            // Table config for B.1.1: Inventarisasi Perangkat
            $tableConfigB1 = [
                'type' => 'table',
                'show_row_number' => true,
                'row_label_header' => 'Item/Perangkat',
                'header_inputs' => [
                    [
                        'key' => 'workshop_name',
                        'label' => 'Nama Bengkel/Lab',
                        'type' => 'text',
                        'placeholder' => 'Masukkan nama bengkel/lab'
                    ],
                    [
                        'key' => 'expertise_field',
                        'label' => 'Bidang Keahlian',
                        'type' => 'text',
                        'placeholder' => 'Masukkan bidang keahlian'
                    ]
                ],
                'columns' => [
                    ['key' => 'specification', 'label' => 'Spesifikasi', 'type' => 'text', 'width' => '15%'],
                    ['key' => 'quantity', 'label' => 'Jumlah Unit', 'type' => 'number', 'width' => '10%'],
                    ['key' => 'condition', 'label' => 'Kondisi (Baik/Rusak)', 'type' => 'select', 'width' => '12%', 'options' => ['Baik', 'Rusak']],
                    ['key' => 'industry_standard', 'label' => 'Kesesuaian dengan Standar Industri Terkini (Ya/Tidak)', 'type' => 'select', 'width' => '18%', 'options' => ['Ya', 'Tidak']],
                    ['key' => 'remarks', 'label' => 'Keterangan (Merek, Tahun, dll)', 'type' => 'text', 'width' => '20%']
                ],
                'rows' => [
                    ['label' => 'Contoh: Mesin CNC'],
                    ['label' => 'Contoh: Software AutoCAD Versi'],
                    ['label' => '...']
                ],
                'dynamic_rows' => true,
                'min_rows' => 3,
                'add_row_label' => 'Tambah Item',
                'note' => 'Catatan untuk Pengisi: Bandingkan spesifikasi alat dengan standar yang digunakan di Dunia Usaha/Dunia Industri (DUDI) mitra atau standar kompetensi nasional.'
            ];

            $questionsB1 = [
                [
                    'code' => 'B.1.1',
                    'text' => 'Inventarisasi dan Kesesuaian dengan Standar Industri',
                    'help' => 'Isi data inventaris perangkat bengkel/lab dan bandingkan dengan standar industri',
                    'type' => 'structure',
                    'scale_id' => null,
                    'options' => json_encode($tableConfigB1)
                ]
            ];

            foreach ($questionsB1 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorB1->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'answer_options' => $q['options'] ?? null,
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'B. Data Sarana Prasarana',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }

            // Indicator B.2: Penilaian Kesiapan Fasilitas (Checklist)
            $indicatorB2 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectB->id, 'code' => 'B.2'],
                ['description' => 'Penilaian Kesiapan Fasilitas (Checklist)', 'order' => 2]
            );

            // Table config for B.2.1: Checklist Kesiapan Fasilitas
            $tableConfigB2 = [
                'type' => 'checklist_table',
                'show_row_number' => false,
                'row_label_header' => 'Aspek',
                'columns' => [
                    ['key' => 'yes', 'label' => 'Ya', 'type' => 'radio', 'width' => '15%'],
                    ['key' => 'no', 'label' => 'Tidak', 'type' => 'radio', 'width' => '15%'],
                    ['key' => 'notes', 'label' => 'Catatan', 'type' => 'text', 'width' => '30%']
                ],
                'rows' => [
                    [
                        'key' => 'layout_industry',
                        'label' => 'Apakah tata letak bengkel/lab meniru lingkungan kerja industri?'
                    ],
                    [
                        'key' => 'calibration',
                        'label' => 'Apakah peralatan telah melalui kalibrasi/pemeliharaan berkala?'
                    ],
                    [
                        'key' => 'sop_available',
                        'label' => 'Apakah tersedia prosedur operasi standar (SOP) untuk setiap alat utama?'
                    ],
                    [
                        'key' => 'k3_implementation',
                        'label' => 'Apakah K3 (Keselamatan dan Kesehatan Kerja) diterapkan dengan baik?'
                    ]
                ]
            ];

            $questionsB2 = [
                [
                    'code' => 'B.2.1',
                    'text' => 'Penilaian Kesiapan Fasilitas (Checklist)',
                    'help' => 'Isi checklist penilaian kesiapan fasilitas bengkel/lab',
                    'type' => 'structure',
                    'scale_id' => null,
                    'options' => json_encode($tableConfigB2)
                ]
            ];

            foreach ($questionsB2 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorB2->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'answer_options' => $q['options'] ?? null,
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'B. Data Sarana Prasarana',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }

            // =========================
            // ASPECT C: DATA TATA KELOLA
            // =========================
            $aspectC = AssessmentAspect::updateOrCreate(
                ['code' => 'C'],
                ['name' => 'Data Tata Kelola', 'order' => 3]
            );

            // Indicator C.1: Kerjasama Industri
            $indicatorC1 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectC->id, 'code' => 'C.1'],
                ['description' => 'Kerjasama Industri', 'order' => 1]
            );

            // Table config for C.1.1: Kerjasama Industri
            $tableConfigC1 = [
                'type' => 'table',
                'show_row_number' => true,
                'row_label_header' => 'Nama Industri Mitra',
                'columns' => [
                    ['key' => 'cooperation_type', 'label' => 'Bentuk Kerjasama (Magang, Rekrutmen, Donasi Alat, dll)', 'type' => 'text', 'width' => '20%'],
                    ['key' => 'duration', 'label' => 'Durasi Kerjasama', 'type' => 'text', 'width' => '15%'],
                    ['key' => 'output', 'label' => 'Output/Kontribusi Nyata (Contoh: jumlah siswa magang, nilai bantuan)', 'type' => 'text', 'width' => '25%'],
                    ['key' => 'mou_status', 'label' => 'Status MoU/MoA (Aktif/Tidak)', 'type' => 'select', 'width' => '15%', 'options' => ['Aktif', 'Tidak']]
                ],
                'rows' => [
                    ['label' => ''],
                    ['label' => '']
                ],
                'dynamic_rows' => true,
                'min_rows' => 2,
                'add_row_label' => 'Tambah Mitra Industri'
            ];

            $questionsC1 = [
                [
                    'code' => 'C.1.1',
                    'text' => 'Kerjasama Industri',
                    'help' => 'Isi data kerjasama dengan industri mitra',
                    'type' => 'structure',
                    'scale_id' => null,
                    'options' => json_encode($tableConfigC1)
                ]
            ];

            foreach ($questionsC1 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorC1->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'answer_options' => $q['options'] ?? null,
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'C. Data Tata Kelola',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }

            // Indicator C.2: Teaching Factory (TEFA) / Unit Produksi Sekolah
            $indicatorC2 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectC->id, 'code' => 'C.2'],
                ['description' => 'Teaching Factory (TEFA) / Unit Produksi Sekolah', 'order' => 2]
            );

            // Table config for C.2.1: TEFA
            $tableConfigC2 = [
                'type' => 'table',
                'show_row_number' => true,
                'row_label_header' => 'Nama Program TEFA/Produk',
                'columns' => [
                    ['key' => 'industry_partner', 'label' => 'Mitra Industri (Jika ada)', 'type' => 'text', 'width' => '15%'],
                    ['key' => 'operation_scale', 'label' => 'Skala Operasi (Siswa/Guru/Tim Khusus)', 'type' => 'text', 'width' => '15%'],
                    ['key' => 'achievement', 'label' => 'Pencapaian & Manfaat (Output, penjualan, pengalaman)', 'type' => 'text', 'width' => '25%'],
                    ['key' => 'constraints', 'label' => 'Kendala', 'type' => 'text', 'width' => '20%']
                ],
                'rows' => [
                    ['label' => ''],
                    ['label' => '']
                ],
                'dynamic_rows' => true,
                'min_rows' => 2,
                'add_row_label' => 'Tambah Program TEFA'
            ];

            $questionsC2 = [
                [
                    'code' => 'C.2.1',
                    'text' => 'Teaching Factory (TEFA) / Unit Produksi Sekolah',
                    'help' => 'Isi data program Teaching Factory atau Unit Produksi Sekolah',
                    'type' => 'structure',
                    'scale_id' => null,
                    'options' => json_encode($tableConfigC2)
                ]
            ];

            foreach ($questionsC2 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorC2->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'answer_options' => $q['options'] ?? null,
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'C. Data Tata Kelola',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }

            // Indicator C.3: Data Pelatihan dan Sertifikasi Guru/Guru Produktif
            $indicatorC3 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectC->id, 'code' => 'C.3'],
                ['description' => 'Data Pelatihan dan Sertifikasi Guru/Guru Produktif', 'order' => 3]
            );

            // Table config for C.3.1: Data Pelatihan dan Sertifikasi Guru yang Telah Diikuti
            $tableConfigC31 = [
                'type' => 'table',
                'show_row_number' => true,
                'row_label_header' => 'Nama Guru',
                'columns' => [
                    ['key' => 'subject', 'label' => 'Mata Pelajaran/Keahlian', 'type' => 'text', 'width' => '15%'],
                    ['key' => 'training_type', 'label' => 'Jenis Pelatihan/Sertifikasi', 'type' => 'text', 'width' => '20%', 'placeholder' => 'Contoh: Pelatihan CNC, Sertifikat Asesor BNSP'],
                    ['key' => 'year', 'label' => 'Tahun', 'type' => 'number', 'width' => '10%'],
                    ['key' => 'provider', 'label' => 'Penyedia (Industri/Lembaga)', 'type' => 'text', 'width' => '15%'],
                    ['key' => 'evidence', 'label' => 'Bukti/Dokumen', 'type' => 'file', 'width' => '20%']
                ],
                'rows' => [
                    ['label' => ''],
                    ['label' => '']
                ],
                'dynamic_rows' => true,
                'min_rows' => 2,
                'add_row_label' => 'Tambah Data Guru'
            ];

            // Form config for C.3.2: Analisis Kebutuhan Pelatihan Guru ke Depan
            $formConfigC32 = [
                'type' => 'form',
                'title' => 'Analisis Kebutuhan Pelatihan Guru ke Depan',
                'subtitle' => 'Diisi oleh Guru/Koordinator Program',
                'sections' => [
                    [
                        'key' => 'competency_gap',
                        'number' => 1,
                        'title' => 'Kesenjangan Kompetensi untuk Siswa',
                        'description' => 'Dari seluruh kompetensi teknis dalam kurikulum, satu keterampilan atau teknologi baru apa yang paling penting dikuasai siswa, tetapi Bapak/Ibu merasa butuh pembaruan/pengetahuan lebih untuk mengajarkannya?',
                        'fields' => [
                            [
                                'key' => 'answer',
                                'label' => 'Jawaban:',
                                'type' => 'textarea',
                                'placeholder' => ''
                            ],
                            [
                                'key' => 'reason',
                                'label' => 'Alasan/Akibat jika tidak dikuasai:',
                                'type' => 'textarea',
                                'placeholder' => ''
                            ]
                        ]
                    ],
                    [
                        'key' => 'industry_alignment',
                        'number' => 2,
                        'title' => 'Kesesuaian dengan Kebutuhan Industri',
                        'description' => 'Menurut penilaian atau masukan dari mitra industri, peningkatan keterampilan teknis apa pada guru yang paling berdampak langsung pada kesiapan kerja dan produktivitas lulusan?',
                        'fields' => [
                            [
                                'key' => 'answer',
                                'label' => 'Jawaban:',
                                'type' => 'textarea',
                                'placeholder' => ''
                            ],
                            [
                                'key' => 'source',
                                'label' => 'Sumber masukan (jika ada):',
                                'type' => 'textarea',
                                'placeholder' => ''
                            ]
                        ]
                    ],
                    [
                        'key' => 'training_priority',
                        'number' => 3,
                        'title' => 'Prioritas Pelatihan',
                        'description' => 'Berdasarkan analisis di atas, pelatihan apa yang paling mendesak untuk diikuti oleh guru produktif di sekolah ini?',
                        'fields' => [
                            [
                                'key' => 'answer',
                                'label' => 'Jawaban:',
                                'type' => 'textarea',
                                'placeholder' => ''
                            ]
                        ]
                    ]
                ]
            ];

            $questionsC3 = [
                [
                    'code' => 'C.3.1',
                    'text' => 'Data Pelatihan dan Sertifikasi Guru yang Telah Diikuti',
                    'help' => 'Isi data pelatihan dan sertifikasi yang telah diikuti oleh guru',
                    'type' => 'structure',
                    'scale_id' => null,
                    'options' => json_encode($tableConfigC31)
                ],
                [
                    'code' => 'C.3.2',
                    'text' => 'Analisis Kebutuhan Pelatihan Guru ke Depan',
                    'help' => 'Diisi oleh Guru/Koordinator Program untuk menganalisis kebutuhan pelatihan',
                    'type' => 'structure',
                    'scale_id' => null,
                    'options' => json_encode($formConfigC32)
                ]
            ];

            foreach ($questionsC3 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorC3->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'answer_options' => $q['options'] ?? null,
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'C. Data Tata Kelola',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }

            // Link instrument to aspects via pivot table
            DB::table('instrument_aspects')->where('instrument_id', $instrument->id)->delete();

            $instrument->aspects()->attach([
                $aspectA->id => ['order' => 1, 'weight' => 1.00],
                $aspectB->id => ['order' => 2, 'weight' => 1.00],
                $aspectC->id => ['order' => 3, 'weight' => 1.00],
            ]);

            $this->command->info('Advanced Instrument seeded successfully with ' . $order . ' questions!');
        });
    }
}
