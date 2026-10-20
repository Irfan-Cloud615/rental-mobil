<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Armada kecil skala UMKM: 4 mobil aktif (gambar memakai URL Unsplash sementara)
        Car::factory(4)->create();

        // 1 mobil sedang maintenance
        Car::factory(1)->maintenance()->create();
    }
}
