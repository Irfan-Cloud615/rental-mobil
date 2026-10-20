<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'user')->pluck('id');
        $cars = Car::where('status', 'active')->pluck('id');

        // Variasi status booking
        Booking::factory()->waitingVerification()->count(3)->create([
            'user_id' => $customers->random(),
            'car_id' => $cars->random(),
        ]);

        Booking::factory()->confirmed()->count(4)->create([
            'user_id' => $customers->random(),
            'car_id' => $cars->random(),
        ]);

        Booking::factory()->completed()->count(4)->create([
            'user_id' => $customers->random(),
            'car_id' => $cars->random(),
        ]);

        Booking::factory()->cancelled()->count(2)->create([
            'user_id' => $customers->random(),
            'car_id' => $cars->random(),
        ]);

        // Sisa booking baru (pending payment)
        Booking::factory(5)->create([
            'user_id' => $customers->random(),
            'car_id' => $cars->random(),
        ]);
    }
}
