<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RentalBankAccount>
 */
class RentalBankAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bank_name' => fake()->randomElement(['Bank BCA', 'Bank Mandiri', 'Bank BRI', 'Bank BNI']),
            'account_number' => fake()->numerify('##########'),
            'account_holder_name' => fake()->name(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the bank account is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
