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
        // Urutan pemanggilan memperhatikan dependensi relasi antar tabel
        $this->call([
            UserSeeder::class,
            CustomerIdentitySeeder::class,
            CarSeeder::class,
            RentalBankAccountSeeder::class,
            BookingSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
