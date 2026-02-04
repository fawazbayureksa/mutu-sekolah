<?php

namespace Database\Seeders;

use App\Models\AssessmentAspect;
use App\Models\AssessmentIndicator;
use App\Models\AssessmentQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SertifikasiKompetensiSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /*
             |--------------------------------------------------------------------------
             | ASPECT: Sertifikasi dan Uji Kompetensi
             | Mapping from Sheet 1 (Table: Nama Ujian / Sertifikasi)
             |--------------------------------------------------------------------------
             */
            $aspect = AssessmentAspect::updateOrCreate(
                ['code' => 'D'],
                [
                    'name' => 'Sertifikasi dan Uji Kompetensi',
                    'order' => 4,
                ]
            );

            /*
             |--------------------------------------------------------------------------
             | INDICATOR: Data pelaksanaan ujian dan sertifikasi
             |--------------------------------------------------------------------------
             */
            $indicator = AssessmentIndicator::updateOrCreate(
                [
                    'aspect_id' => $aspect->id,
                    'code' => 'D.1',
                ],
                [
                    'description' => 'Data pelaksanaan ujian dan sertifikasi peserta didik',
                    'order' => 1,
                ]
            );

            /*
             |--------------------------------------------------------------------------
             | QUESTIONS
             | Each column in Sheet 1 table is treated as one assessment question
             |--------------------------------------------------------------------------
             */
            $questions = [
                [
                    'code' => 'D.1.1',
                    'text' => 'Nama Ujian / Sertifikasi',
                    'type' => 'text',
                    'order' => 1,
                ],
                [
                    'code' => 'D.1.2',
                    'text' => 'Tahun Pelaksanaan',
                    'type' => 'scale',
                    'order' => 2,
                ],
                [
                    'code' => 'D.1.3',
                    'text' => 'Jumlah Peserta',
                    'type' => 'scale',
                    'order' => 3,
                ],
                [
                    'code' => 'D.1.4',
                    'text' => 'Jumlah Lulus',
                    'type' => 'scale',
                    'order' => 4,
                ],
                [
                    'code' => 'D.1.5',
                    'text' => 'Tingkat Kelulusan (%)',
                    'type' => 'scale',
                    'order' => 5,
                ],
                [
                    'code' => 'D.1.6',
                    'text' => 'Lembaga Sertifikasi / Penyelenggara',
                    'type' => 'text',
                    'order' => 6,
                ],
            ];

            foreach ($questions as $question) {
                AssessmentQuestion::updateOrCreate(
                    [
                        'indicator_id' => $indicator->id,
                        'question_text' => $question['text'],
                    ],
                    [
                        'answer_type' => $question['type'],
                        'weight' => 1,
                        'order' => $question['order'],
                    ]
                );
            }

            $this->command->info('Sertifikasi dan Uji Kompetensi data seeded successfully!');
        });
    }
}
