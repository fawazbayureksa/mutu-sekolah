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
                'columns' => [
                    ['key' => 'year', 'label' => 'Tahun', 'type' => 'number', 'width' => '15%'],
                    ['key' => 'total_participants', 'label' => 'Jumlah Peserta', 'type' => 'number', 'width' => '20%'],
                    ['key' => 'total_passed', 'label' => 'Jumlah Lulus', 'type' => 'number', 'width' => '20%'],
                    ['key' => 'pass_rate', 'label' => 'Tingkat Kelulusan (%)', 'type' => 'percentage', 'read_only' => true, 'calculate' => '(row.total_passed / row.total_participants) * 100'],
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

            // Indicator A.2: Kondisi peserta didik (Existing)
            $indicatorA2 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectA->id, 'code' => 'A.2'],
                ['description' => 'Kondisi peserta didik', 'order' => 2]
            );

            // Questions for A.2 (Existing questions moved here)
            $questionsA2 = [
                [
                    'code' => 'A.2.1',
                    'text' => 'Jumlah peserta didik aktif pada program keahlian KPTK',
                    'help' => 'Pilih kategori yang sesuai dengan jumlah peserta didik aktif di sekolah Anda',
                    'type' => 'scale',
                    'scale_id' => $qualityScale->id,
                ],
                [
                    'code' => 'A.2.2',
                    'text' => 'Persentase lulusan yang terserap dunia kerja sesuai bidang keahlian',
                    'help' => 'Berdasarkan data tracer study 1 tahun terakhir',
                    'type' => 'scale',
                    'scale_id' => $qualityScale->id,
                ],
                [
                    'code' => 'A.2.3',
                    'text' => 'Kesesuaian kompetensi lulusan dengan kebutuhan industri',
                    'help' => 'Dinilai berdasarkan feedback dari industri mitra',
                    'type' => 'scale',
                    'scale_id' => $conformityScale->id,
                ],
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
            // ASPECT B: Standar Sarana Prasarana
            // =========================
            $aspectB = AssessmentAspect::updateOrCreate(
                ['code' => 'B'],
                ['name' => 'Standar Sarana Prasarana', 'order' => 2]
            );

            // Indicator B.1
            $indicatorB1 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectB->id, 'code' => 'B.1'],
                ['description' => 'Ketersediaan dan kondisi sarana prasarana', 'order' => 1]
            );

            $questionsB1 = [
                [
                    'code' => 'B.1.1',
                    'text' => 'Ketersediaan ruang praktik sesuai standar industri',
                    'help' => 'Apakah sekolah memiliki ruang praktik yang memenuhi standar industri?',
                    'type' => 'boolean',
                    'scale_id' => $yesNoScale->id,
                ],
                [
                    'code' => 'B.1.2',
                    'text' => 'Kondisi peralatan praktik utama',
                    'help' => 'Penilaian kondisi peralatan praktik yang digunakan siswa',
                    'type' => 'scale',
                    'scale_id' => $conditionScale ? $conditionScale->id : $qualityScale->id,
                ],
                [
                    'code' => 'B.1.3',
                    'text' => 'Relevansi fasilitas dengan perkembangan teknologi industri',
                    'help' => 'Sejauh mana fasilitas sekolah mengikuti perkembangan teknologi terkini',
                    'type' => 'scale',
                    'scale_id' => $conformityScale->id,
                ],
                [
                    'code' => 'B.1.4',
                    'text' => 'Ketersediaan akses internet untuk pembelajaran',
                    'help' => 'Apakah tersedia akses internet yang memadai untuk kegiatan pembelajaran?',
                    'type' => 'boolean',
                    'scale_id' => $yesNoScale->id,
                ],
            ];

            foreach ($questionsB1 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorB1->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'B. Standar Sarana Prasarana',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }

            // =========================
            // ASPECT C: Standar Tata Kelola
            // =========================
            $aspectC = AssessmentAspect::updateOrCreate(
                ['code' => 'C'],
                ['name' => 'Standar Tata Kelola', 'order' => 3]
            );

            // Indicator C.1
            $indicatorC1 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectC->id, 'code' => 'C.1'],
                ['description' => 'Kerjasama dengan industri', 'order' => 1]
            );

            $questionsC1 = [
                [
                    'code' => 'C.1.1',
                    'text' => 'Kerjasama aktif dengan dunia usaha dan industri (DUDI)',
                    'help' => 'Apakah sekolah memiliki MoU aktif dengan DUDI?',
                    'type' => 'boolean',
                    'scale_id' => $yesNoScale->id,
                ],
                [
                    'code' => 'C.1.2',
                    'text' => 'Jumlah industri mitra yang aktif',
                    'help' => 'Berapa banyak industri mitra yang secara aktif bekerja sama dengan sekolah?',
                    'type' => 'scale',
                    'scale_id' => $qualityScale->id,
                ],
            ];

            foreach ($questionsC1 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorC1->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'C. Standar Tata Kelola',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }

            // Indicator C.2
            $indicatorC2 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectC->id, 'code' => 'C.2'],
                ['description' => 'Teaching Factory (TEFA)', 'order' => 2]
            );

            $questionsC2 = [
                [
                    'code' => 'C.2.1',
                    'text' => 'Pelaksanaan Teaching Factory (TEFA)',
                    'help' => 'Bagaimana kualitas pelaksanaan program Teaching Factory di sekolah?',
                    'type' => 'scale',
                    'scale_id' => $qualityScale->id,
                ],
                [
                    'code' => 'C.2.2',
                    'text' => 'Produk/jasa TEFA yang dihasilkan memenuhi standar industri',
                    'help' => 'Apakah produk atau jasa yang dihasilkan TEFA sudah memenuhi standar industri?',
                    'type' => 'scale',
                    'scale_id' => $conformityScale->id,
                ],
            ];

            foreach ($questionsC2 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorC2->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'C. Standar Tata Kelola',
                        'indicator_code' => $q['code'],
                        'indicator_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'uses_master_question' => true,
                        'order' => $order,
                    ]
                );
            }

            // Indicator C.3
            $indicatorC3 = AssessmentIndicator::updateOrCreate(
                ['aspect_id' => $aspectC->id, 'code' => 'C.3'],
                ['description' => 'Pelatihan dan sertifikasi guru', 'order' => 3]
            );

            $questionsC3 = [
                [
                    'code' => 'C.3.1',
                    'text' => 'Frekuensi pelatihan guru produktif per tahun',
                    'help' => 'Seberapa sering guru produktif mengikuti pelatihan?',
                    'type' => 'scale',
                    'scale_id' => $frequencyScale ? $frequencyScale->id : $qualityScale->id,
                ],
                [
                    'code' => 'C.3.2',
                    'text' => 'Persentase guru produktif yang memiliki sertifikat kompetensi',
                    'help' => 'Berapa persen guru produktif yang sudah tersertifikasi?',
                    'type' => 'scale',
                    'scale_id' => $qualityScale->id,
                ],
            ];

            foreach ($questionsC3 as $q) {
                $question = AssessmentQuestion::updateOrCreate(
                    ['indicator_id' => $indicatorC3->id, 'question_code' => $q['code']],
                    [
                        'question_text' => $q['text'],
                        'answer_type' => $q['type'],
                        'help_text' => $q['help'],
                        'scale_template_id' => $q['scale_id'],
                        'weight' => 1.00,
                        'is_required' => true,
                        'is_active' => true,
                        'order' => ++$order,
                    ]
                );

                InstrumentItem::updateOrCreate(
                    ['instrument_id' => $instrument->id, 'assessment_question_id' => $question->id],
                    [
                        'section' => 'C. Standar Tata Kelola',
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
