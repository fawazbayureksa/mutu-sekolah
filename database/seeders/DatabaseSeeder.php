<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IndonesiaRegionDataSeeder::class,
            AdminUserSeeder::class,
            ScaleTemplateSeeder::class,
            AdvancedInstrumentSeeder::class,
            VerifierUserSeeder::class,
        ]);
    }
}
