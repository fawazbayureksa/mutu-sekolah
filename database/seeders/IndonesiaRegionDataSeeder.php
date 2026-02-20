<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndonesiaRegionDataSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('IndonesiaRegionData.csv');

        if (! file_exists($csvFile)) {
            $this->command->error('IndonesiaRegionData.csv file not found!');

            return;
        }

        $handle = fopen($csvFile, 'r');
        if ($handle === false) {
            $this->command->error('Failed to open IndonesiaRegionData.csv file!');

            return;
        }

        $header = fgetcsv($handle, 0, ',');
        if ($header === false) {
            fclose($handle);
            $this->command->error('Failed to read CSV header!');

            return;
        }

        $provinces = [];
        $regencies = [];

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if (count($row) < 8) {
                continue;
            }

            $provinceCode = trim($row[6]);
            $provinceName = trim($row[7]);
            $regencyCode = trim($row[4]);
            $regencyName = trim($row[5]);

            if (! empty($provinceCode) && ! empty($provinceName)) {
                if (! isset($provinces[$provinceCode])) {
                    $provinces[$provinceCode] = [
                        'code' => $provinceCode,
                        'name' => $provinceName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (! empty($regencyCode) && ! empty($regencyName) && ! empty($provinceCode)) {
                $regencyKey = $regencyCode;
                if (! isset($regencies[$regencyKey])) {
                    $regencies[$regencyKey] = [
                        'code' => $regencyCode,
                        'province_code' => $provinceCode,
                        'name' => $regencyName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        fclose($handle);

        foreach (array_values($provinces) as $province) {
            DB::table('provinces')->updateOrInsert(
                ['code' => $province['code']],
                $province
            );
        }
        $this->command->info(count($provinces).' provinces seeded from IndonesiaRegionData.csv.');

        foreach (array_values($regencies) as $regency) {
            DB::table('regencies')->updateOrInsert(
                ['code' => $regency['code']],
                $regency
            );
        }
        $this->command->info(count($regencies).' regencies seeded from IndonesiaRegionData.csv.');

        $this->command->info('Indonesia region data seeded successfully!');
    }
}
