<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $days = fake()->numberBetween(1, 5);
        $startTime = now()->addDays(fake()->numberBetween(1, 14))->setTime(9, 0);
        $pricePerDay = fake()->randomElement([250000, 350000, 450000, 600000, 850000, 1200000, 1500000]);

        return [
            'booking_code' => 'BK-' . strtoupper(Str::random(10)),
            'user_id' => User::factory(),
            'car_id' => Car::factory(),
            'start_time' => $startTime,
            'end_time' => $startTime->copy()->addDays($days),
            'status' => 'pending_payment',
            'total_price' => $pricePerDay * $days,
            'expires_at' => $startTime->copy()->subHours(12),
        ];
    }

    /**
     * Indicate that the booking is waiting for payment verification.
     */
    public function waitingVerification(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'waiting_verification',
        ]);
    }

    /**
     * Indicate that the booking is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate that the booking is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'start_time' => now()->subDays(fake()->numberBetween(10, 30))->setTime(9, 0),
        ]);
    }

    /**
     * Indicate that the booking is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
