<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin utama
        User::factory()->admin()->create([
            'name' => 'Admin Rental',
            'email' => 'admin@example.com',
        ]);

        // Akun test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Penyewa acak
        User::factory(10)->create();
    }
}
