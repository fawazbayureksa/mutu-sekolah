<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@bppmpv.com'],
            [
                'name' => 'Administrator BPPMPV',
                'email' => 'admin@bppmpv.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@bppmpv.com');
        $this->command->info('Password: password123');
    }
}
