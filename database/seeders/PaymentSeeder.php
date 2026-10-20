<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\RentalBankAccount;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $activeAccounts = RentalBankAccount::where('is_active', true)->pluck('id');

        // Booking yang sudah melewati tahap pending payment pasti punya bukti transfer
        Booking::whereIn('status', ['waiting_verification', 'confirmed', 'completed'])
            ->get()
            ->each(function (Booking $booking) use ($admin, $activeAccounts) {
                if (in_array($booking->status, ['confirmed', 'completed'])) {
                    // Pembayaran sudah diverifikasi admin
                    Payment::factory()->verified()->create([
                        'booking_id' => $booking->id,
                        'rental_bank_account_id' => $activeAccounts->random(),
                        'verified_by' => $admin?->id,
                    ]);
                } else {
                    // Menunggu verifikasi
                    Payment::factory()->create([
                        'booking_id' => $booking->id,
                        'rental_bank_account_id' => $activeAccounts->random(),
                    ]);
                }
            });

        // Beberapa booking pending_payment juga sudah upload bukti transfer
        Payment::factory(2)->create([
            'booking_id' => Booking::where('status', 'pending_payment')->inRandomOrder()->value('id'),
            'rental_bank_account_id' => $activeAccounts->random(),
        ]);
    }
}
