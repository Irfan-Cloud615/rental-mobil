<?php

namespace Database\Seeders;

use App\Models\RentalBankAccount;
use Illuminate\Database\Seeder;

class RentalBankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Rekening aktif milik perusahaan
        RentalBankAccount::factory()->create([
            'bank_name' => 'Bank BCA',
            'account_number' => '1234567890',
            'account_holder_name' => 'PT Rental Mobil Sukses',
        ]);

        RentalBankAccount::factory()->create([
            'bank_name' => 'Bank Mandiri',
            'account_number' => '0987654321',
            'account_holder_name' => 'PT Rental Mobil Sukses',
        ]);

        RentalBankAccount::factory()->create([
            'bank_name' => 'Bank BRI',
            'account_number' => '1122334455',
            'account_holder_name' => 'PT Rental Mobil Sukses',
        ]);

        // Rekening nonaktif (contoh data lama)
        RentalBankAccount::factory()->inactive()->create([
            'bank_name' => 'Bank BNI',
            'account_number' => '5566778899',
            'account_holder_name' => 'PT Rental Mobil Sukses',
        ]);
    }
}
