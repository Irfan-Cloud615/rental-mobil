<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\RentalBankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'method' => 'transfer',
            'rental_bank_account_id' => RentalBankAccount::factory(),
            'amount' => fake()->randomElement([250000, 350000, 450000, 600000, 850000, 1200000, 1500000]),
            'proof_image_path' => 'payment-proofs/transfer-' . fake()->uuid() . '.jpg',
            'customer_notes' => fake()->optional(0.4)->sentence(6),
            'status' => 'submitted',
            'verified_by' => null,
            'verified_at' => null,
            'rejection_reason' => null,
        ];
    }

    /**
     * Indicate that the payment has been verified / lunas.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'paid_at' => now(),
            'verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the payment was made in cash (no proof needed).
     */
    public function cash(): static
    {
        return $this->state(fn (array $attributes) => [
            'method' => 'cash',
            'rental_bank_account_id' => null,
            'proof_image_path' => null,
        ]);
    }

    /**
     * Indicate that the payment has been rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'verified_at' => now(),
            'rejection_reason' => fake()->sentence(8),
        ]);
    }
}
