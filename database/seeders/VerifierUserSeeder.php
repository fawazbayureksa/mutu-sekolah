<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VerifierUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'verifier@bppmpv.com'],
            [
                'name' => 'Verifikasi Dokumen',
                'email' => 'verifier@bppmpv.com',
                'password' => Hash::make('password123'),
                'role' => 'verifier',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Verifier user created successfully!');
        $this->command->info('Email: verifier@bppmpv.com');
        $this->command->info('Password: password123');
    }
}
