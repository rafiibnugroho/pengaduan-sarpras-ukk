<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
    // Admin
    \App\Models\User::firstOrCreate(
        ['email' => 'adminsegar@example.com'],
        [
            'name' => 'Admin Segar',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]
    );

    // Petugas
    \App\Models\User::firstOrCreate(
        ['email' => 'petugas1@example.com'],
        [
            'name' => 'Petugas 1',
            'password' => bcrypt('petugas123'),
            'role' => 'petugas',
        ]
    );
}
}
