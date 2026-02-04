<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use App\Models\AssessmentIndicator;
use App\Models\AssessmentQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstrumentSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // =========================
            // DATA STRUCTURE
            // =========================
            // Based on Sheet 1: Mapping instrument data to database schema
            // Hierarchy: Aspect → Indicator → Question

            $aspectsData = [
                [
                    'code' => 'A',
                    'name' => 'Standar Peserta Didik',
                    'order' => 1,
                    'indicators' => [
                        [
                            'code' => 'A.1',
                            'description' => 'Kondisi peserta didik',
                            'order' => 1,
                            'questions' => [
                                [
                                    'text' => 'Jumlah peserta didik aktif pada program keahlian KPTK',
                                    'answer_type' => 'scale',
                                    'weight' => 1.00,
                                    'order' => 1,
                                ],
                                [
                                    'text' => 'Persentase lulusan yang terserap dunia kerja',
                                    'answer_type' => 'scale',
                                    'weight' => 1.00,
                                    'order' => 2,
                                ],
                                [
                                    'text' => 'Kesesuaian kompetensi lulusan dengan kebutuhan industri',
                                    'answer_type' => 'scale',
                                    'weight' => 1.00,
                                    'order' => 3,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'code' => 'B',
                    'name' => 'Standar Sarana Prasarana',
                    'order' => 2,
                    'indicators' => [
                        [
                            'code' => 'B.1',
                            'description' => 'Ketersediaan dan kondisi sarana prasarana',
                            'order' => 1,
                            'questions' => [
                                [
                                    'text' => 'Ketersediaan ruang praktik sesuai standar industri',
                                    'answer_type' => 'boolean',
                                    'weight' => 1.00,
                                    'order' => 1,
                                ],
                                [
                                    'text' => 'Kondisi peralatan praktik utama',
                                    'answer_type' => 'scale',
                                    'weight' => 1.00,
                                    'order' => 2,
                                ],
                                [
                                    'text' => 'Relevansi fasilitas dengan perkembangan teknologi industri',
                                    'answer_type' => 'scale',
                                    'weight' => 1.00,
                                    'order' => 3,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'code' => 'C',
                    'name' => 'Standar Tata Kelola',
                    'order' => 3,
                    'indicators' => [
                        [
                            'code' => 'C.1',
                            'description' => 'Kerjasama dengan industri',
                            'order' => 1,
                            'questions' => [
                                [
                                    'text' => 'Kerjasama aktif dengan dunia usaha dan industri (DUDI)',
                                    'answer_type' => 'boolean',
                                    'weight' => 1.00,
                                    'order' => 1,
                                ],
                            ],
                        ],
                        [
                            'code' => 'C.2',
                            'description' => 'Teaching Factory (TEFA)',
                            'order' => 2,
                            'questions' => [
                                [
                                    'text' => 'Pelaksanaan Teaching Factory (TEFA)',
                                    'answer_type' => 'scale',
                                    'weight' => 1.00,
                                    'order' => 1,
                                ],
                            ],
                        ],
                        [
                            'code' => 'C.3',
                            'description' => 'Pelatihan dan sertifikasi guru',
                            'order' => 3,
                            'questions' => [
                                [
                                    'text' => 'Pelatihan dan sertifikasi guru produktif',
                                    'answer_type' => 'scale',
                                    'weight' => 1.00,
                                    'order' => 1,
                                ],
                            ],
                        ],
                    ],
                ],
            ];

            // =========================
            // SEED ASPECTS
            // =========================
            foreach ($aspectsData as $aspectData) {
                $aspect = AssessmentAspect::updateOrCreate(
                    ['code' => $aspectData['code']],
                    [
                        'name' => $aspectData['name'],
                        'order' => $aspectData['order'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                $aspectId = $aspect->id;

                // =========================
                // SEED INDICATORS
                // =========================
                foreach ($aspectData['indicators'] as $indicatorData) {
                    $indicator = AssessmentIndicator::updateOrCreate(
                        [
                            'aspect_id' => $aspectId,
                            'code' => $indicatorData['code'],
                        ],
                        [
                            'description' => $indicatorData['description'],
                            'order' => $indicatorData['order'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );

                    $indicatorId = $indicator->id;

                    // =========================
                    // SEED QUESTIONS
                    // =========================
                    foreach ($indicatorData['questions'] as $questionData) {
                        AssessmentQuestion::updateOrCreate(
                            [
                                'indicator_id' => $indicatorId,
                                'question_text' => $questionData['text'],
                            ],
                            [
                                'answer_type' => $questionData['answer_type'],
                                'weight' => $questionData['weight'],
                                'order' => $questionData['order'],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]
                        );
                    }
                }
            }

            $this->command->info('Instrument data seeded successfully!');
        });
    }
}
