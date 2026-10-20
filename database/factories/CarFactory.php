<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Gambar mobil dari Unsplash yang sudah dipastikan aktif (HTTP 200)
        $unsplashImages = [
            'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1508974239320-0a029497e820?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1555353540-64580b51c258?auto=format&fit=crop&w=800&q=80',
        ];

        return [
            'name' => fake()->randomElement([
                'Toyota Avanza Veloz',
                'Toyota HiAce Commuter',
                'Daihatsu Xenia',
                'Mitsubishi Xpander',
                'Honda Brio RS',
                'Toyota Innova Zenix',
                'Suzuki Ertiga Hybrid',
                'Daihatsu Sigra',
            ]),
            'image_path' => fake()->randomElement($unsplashImages),
            'license_plate' => 'B ' . fake()->unique()->numberBetween(1, 9999) . ' ' . strtoupper(fake()->bothify('???')),
            'transmission' => fake()->randomElement(['manual', 'automatic']),
            'seat_capacity' => fake()->randomElement([5, 6, 7, 15, 16]),
            'price_per_day' => fake()->randomElement([250000, 350000, 450000, 600000, 850000, 1200000, 1500000]),
            'status' => 'active',
        ];
    }

    /**
     * Indicate that the car is under maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'maintenance',
        ]);
    }
}
