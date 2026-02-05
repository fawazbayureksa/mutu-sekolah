<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScaleTemplateSeeder extends Seeder
{
    /**
     * Seed predefined scale templates
     * These are reusable across multiple assessment questions
     */
    public function run(): void
    {
        DB::transaction(function () {
            $templates = [
                // 5-Point Likert Scale (Agreement)
                [
                    'code' => 'LIKERT_5_AGREEMENT',
                    'name' => 'Skala Likert 5 Poin (Persetujuan)',
                    'description' => 'Skala persetujuan standar 5 poin dari Sangat Tidak Setuju hingga Sangat Setuju',
                    'scale_type' => 'likert',
                    'scale_options' => json_encode([
                        ['value' => '1', 'label' => 'Sangat Tidak Setuju', 'score' => 20.00, 'color' => 'red'],
                        ['value' => '2', 'label' => 'Tidak Setuju', 'score' => 40.00, 'color' => 'orange'],
                        ['value' => '3', 'label' => 'Netral', 'score' => 60.00, 'color' => 'yellow'],
                        ['value' => '4', 'label' => 'Setuju', 'score' => 80.00, 'color' => 'light-green'],
                        ['value' => '5', 'label' => 'Sangat Setuju', 'score' => 100.00, 'color' => 'green'],
                    ]),
                    'min_score' => 20.00,
                    'max_score' => 100.00,
                    'is_default' => true,
                    'is_active' => true,
                ],

                // 5-Point Quality Scale
                [
                    'code' => 'QUALITY_5',
                    'name' => 'Skala Kualitas 5 Poin',
                    'description' => 'Skala penilaian kualitas dari Sangat Buruk hingga Sangat Baik',
                    'scale_type' => 'quality',
                    'scale_options' => json_encode([
                        ['value' => '1', 'label' => 'Sangat Buruk', 'score' => 20.00, 'color' => 'red'],
                        ['value' => '2', 'label' => 'Buruk', 'score' => 40.00, 'color' => 'orange'],
                        ['value' => '3', 'label' => 'Cukup', 'score' => 60.00, 'color' => 'yellow'],
                        ['value' => '4', 'label' => 'Baik', 'score' => 80.00, 'color' => 'light-green'],
                        ['value' => '5', 'label' => 'Sangat Baik', 'score' => 100.00, 'color' => 'green'],
                    ]),
                    'min_score' => 20.00,
                    'max_score' => 100.00,
                    'is_default' => true,
                    'is_active' => true,
                ],

                // 5-Point Conformity Scale
                [
                    'code' => 'CONFORMITY_5',
                    'name' => 'Skala Kesesuaian 5 Poin',
                    'description' => 'Skala kesesuaian dari Sangat Tidak Sesuai hingga Sangat Sesuai',
                    'scale_type' => 'custom',
                    'scale_options' => json_encode([
                        ['value' => '1', 'label' => 'Sangat Tidak Sesuai', 'score' => 20.00, 'color' => 'red'],
                        ['value' => '2', 'label' => 'Tidak Sesuai', 'score' => 40.00, 'color' => 'orange'],
                        ['value' => '3', 'label' => 'Cukup Sesuai', 'score' => 60.00, 'color' => 'yellow'],
                        ['value' => '4', 'label' => 'Sesuai', 'score' => 80.00, 'color' => 'light-green'],
                        ['value' => '5', 'label' => 'Sangat Sesuai', 'score' => 100.00, 'color' => 'green'],
                    ]),
                    'min_score' => 20.00,
                    'max_score' => 100.00,
                    'is_default' => true,
                    'is_active' => true,
                ],

                // Yes/No Boolean
                [
                    'code' => 'YES_NO',
                    'name' => 'Ya/Tidak',
                    'description' => 'Pilihan boolean sederhana Ya atau Tidak',
                    'scale_type' => 'boolean',
                    'scale_options' => json_encode([
                        ['value' => 'no', 'label' => 'Tidak', 'score' => 0.00, 'color' => 'red'],
                        ['value' => 'yes', 'label' => 'Ya', 'score' => 100.00, 'color' => 'green'],
                    ]),
                    'min_score' => 0.00,
                    'max_score' => 100.00,
                    'is_default' => true,
                    'is_active' => true,
                ],

                // Available/Not Available
                [
                    'code' => 'ADA_TIDAK_ADA',
                    'name' => 'Ada/Tidak Ada',
                    'description' => 'Ketersediaan item atau fasilitas',
                    'scale_type' => 'boolean',
                    'scale_options' => json_encode([
                        ['value' => 'tidak_ada', 'label' => 'Tidak Ada', 'score' => 0.00, 'color' => 'red'],
                        ['value' => 'ada', 'label' => 'Ada', 'score' => 100.00, 'color' => 'green'],
                    ]),
                    'min_score' => 0.00,
                    'max_score' => 100.00,
                    'is_default' => true,
                    'is_active' => true,
                ],

                // Condition Scale
                [
                    'code' => 'CONDITION_4',
                    'name' => 'Skala Kondisi 4 Poin',
                    'description' => 'Penilaian kondisi dari Rusak Berat hingga Baik Sekali',
                    'scale_type' => 'quality',
                    'scale_options' => json_encode([
                        ['value' => '1', 'label' => 'Rusak Berat', 'score' => 25.00, 'color' => 'red'],
                        ['value' => '2', 'label' => 'Rusak Ringan', 'score' => 50.00, 'color' => 'orange'],
                        ['value' => '3', 'label' => 'Baik', 'score' => 75.00, 'color' => 'light-green'],
                        ['value' => '4', 'label' => 'Baik Sekali', 'score' => 100.00, 'color' => 'green'],
                    ]),
                    'min_score' => 25.00,
                    'max_score' => 100.00,
                    'is_default' => true,
                    'is_active' => true,
                ],

                // Frequency Scale
                [
                    'code' => 'FREQUENCY_5',
                    'name' => 'Skala Frekuensi 5 Poin',
                    'description' => 'Skala frekuensi dari Tidak Pernah hingga Selalu',
                    'scale_type' => 'frequency',
                    'scale_options' => json_encode([
                        ['value' => '1', 'label' => 'Tidak Pernah', 'score' => 20.00, 'color' => 'red'],
                        ['value' => '2', 'label' => 'Jarang', 'score' => 40.00, 'color' => 'orange'],
                        ['value' => '3', 'label' => 'Kadang-kadang', 'score' => 60.00, 'color' => 'yellow'],
                        ['value' => '4', 'label' => 'Sering', 'score' => 80.00, 'color' => 'light-green'],
                        ['value' => '5', 'label' => 'Selalu', 'score' => 100.00, 'color' => 'green'],
                    ]),
                    'min_score' => 20.00,
                    'max_score' => 100.00,
                    'is_default' => true,
                    'is_active' => true,
                ],

                // 1-10 Rating Scale
                [
                    'code' => 'RATING_1_10',
                    'name' => 'Skala Rating 1-10',
                    'description' => 'Skala rating numerik 1 hingga 10',
                    'scale_type' => 'rating',
                    'scale_options' => json_encode([
                        ['value' => '1', 'label' => '1 - Sangat Buruk', 'score' => 10.00],
                        ['value' => '2', 'label' => '2', 'score' => 20.00],
                        ['value' => '3', 'label' => '3', 'score' => 30.00],
                        ['value' => '4', 'label' => '4', 'score' => 40.00],
                        ['value' => '5', 'label' => '5 - Cukup', 'score' => 50.00],
                        ['value' => '6', 'label' => '6', 'score' => 60.00],
                        ['value' => '7', 'label' => '7', 'score' => 70.00],
                        ['value' => '8', 'label' => '8', 'score' => 80.00],
                        ['value' => '9', 'label' => '9', 'score' => 90.00],
                        ['value' => '10', 'label' => '10 - Sangat Baik', 'score' => 100.00],
                    ]),
                    'min_score' => 10.00,
                    'max_score' => 100.00,
                    'is_default' => true,
                    'is_active' => true,
                ],
            ];

            foreach ($templates as $template) {
                DB::table('scale_templates')->insert(array_merge($template, [
                    'usage_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }

            $this->command->info('Scale templates seeded successfully!');
        });
    }
}
