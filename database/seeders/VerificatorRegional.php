<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VerificatorRegional extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $provinces = Province::get();
        foreach ($provinces as $province) {
            $province_name = str_replace(' ', '', $province->name);
            $email = 'verifier.' . strtolower($province_name) . '@bppmpv.com';
            $password = ucfirst(strtolower($province_name)) . '2026!';
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Verifikator Instrumen ' . $province->name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'verifier',
                    'is_active' => true,
                    'province_id' => (int) $province->code,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
