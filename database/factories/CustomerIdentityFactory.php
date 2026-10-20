<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerIdentity>
 */
class CustomerIdentityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address()
        ];
    }

    /**
     * Indicate that the identity has been verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'verified',
            'verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the identity has been rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'rejected',
            'verified_at' => now(),
            'rejection_reason' => fake()->sentence(8),
        ]);
    }
}
