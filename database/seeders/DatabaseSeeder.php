<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Seed siswa user
        User::updateOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name' => 'Siswa',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'email_verified_at' => now(),
            ]
        );
    }
}