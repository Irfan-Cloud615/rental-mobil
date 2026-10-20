<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 20)->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('car_id')->constrained('cars');

            // Lokasi sewa (form "Make your trip" di beranda & halaman booking)
            $table->string('pickup_location', 150)->nullable();
            $table->string('dropoff_location', 150)->nullable();

            // Jadwal sewa
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            // Status esensial
            $table->enum('status', [
                'pending_payment',
                'waiting_verification',
                'confirmed',
                'completed',
                'cancelled'
            ])->default('pending_payment');

            // Total biaya sewa
            $table->decimal('total_price', 12, 2);

            $table->text('customer_note')->nullable();

            // Batas waktu transfer
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();

            // Index untuk pengecekan benturan jadwal
            $table->index(['car_id', 'status', 'start_time', 'end_time'], 'idx_booking_availability');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
