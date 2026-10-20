<?php

namespace Database\Seeders;

use App\Models\CustomerIdentity;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerIdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('role', 'user')->get()->each(function (User $user) {
                CustomerIdentity::factory()->create([
                    'user_id' => $user->id,
                ]);
        });
    }
}
