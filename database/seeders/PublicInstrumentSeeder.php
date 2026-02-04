<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicInstrumentSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $instrumentId = DB::table('instruments')->insertGetId([
                'code' => 'KPTK-2024',
                'name' => 'Instrumen Penjaminan Mutu SMK Bidang KPTK',
                'description' => 'Instrumen pemetaan mutu SMK bidang Kelautan, Perikanan, dan TIK berdasarkan standar nasional pendidikan vokasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $items = [
                [
                    'instrument_id' => $instrumentId,
                    'section' => 'Peserta Didik',
                    'indicator_code' => 'PD-1',
                    'indicator_text' => 'Jumlah peserta didik aktif pada program keahlian KPTK',
                    'answer_type' => 'number',
                ],
                [
                    'instrument_id' => $instrumentId,
                    'section' => 'Peserta Didik',
                    'indicator_code' => 'PD-2',
                    'indicator_text' => 'Persentase lulusan yang terserap dunia kerja',
                    'answer_type' => 'number',
                ],
                [
                    'instrument_id' => $instrumentId,
                    'section' => 'Peserta Didik',
                    'indicator_code' => 'PD-3',
                    'indicator_text' => 'Kesesuaian kompetensi lulusan dengan kebutuhan industri',
                    'answer_type' => 'option',
                ],
                [
                    'instrument_id' => $instrumentId,
                    'section' => 'Sarana Prasarana',
                    'indicator_code' => 'SP-1',
                    'indicator_text' => 'Ketersediaan ruang praktik sesuai standar industri',
                    'answer_type' => 'boolean',
                ],
                [
                    'instrument_id' => $instrumentId,
                    'section' => 'Sarana Prasarana',
                    'indicator_code' => 'SP-2',
                    'indicator_text' => 'Kondisi peralatan praktik utama',
                    'answer_type' => 'option',
                ],
                [
                    'instrument_id' => $instrumentId,
                    'section' => 'Sarana Prasarana',
                    'indicator_code' => 'SP-3',
                    'indicator_text' => 'Relevansi fasilitas dengan perkembangan teknologi industri',
                    'answer_type' => 'option',
                ],
                [
                    'instrument_id' => $instrumentId,
                    'section' => 'Tata Kelola',
                    'indicator_code' => 'TK-1',
                    'indicator_text' => 'Kerjasama aktif dengan dunia usaha dan industri (DUDI)',
                    'answer_type' => 'boolean',
                ],
                [
                    'instrument_id' => $instrumentId,
                    'section' => 'Tata Kelola',
                    'indicator_code' => 'TK-2',
                    'indicator_text' => 'Pelaksanaan Teaching Factory (TEFA)',
                    'answer_type' => 'option',
                ],
                [
                    'instrument_id' => $instrumentId,
                    'section' => 'Tata Kelola',
                    'indicator_code' => 'TK-3',
                    'indicator_text' => 'Pelatihan dan sertifikasi guru produktif',
                    'answer_type' => 'number',
                ],
            ];

            foreach ($items as $item) {
                DB::table('instrument_items')->insert(array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }

            $this->command->info('Public Instrument data seeded successfully!');
        });
    }
}
