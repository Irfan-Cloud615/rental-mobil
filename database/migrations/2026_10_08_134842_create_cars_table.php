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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Contoh: Toyota HiAce Commuter / Avanza Veloz
            $table->string('slug', 140)->unique(); // keperluan SEO/canonical URL
            $table->string('brand', 60)->nullable(); // Toyota, Daihatsu, Mitsubishi
            $table->string('image_path')->nullable();
            $table->string('license_plate', 20)->unique();
            $table->enum('transmission', ['manual', 'automatic']);
            $table->enum('fuel_type', ['pertalite', 'pertamax', 'pertamax_turbo', 'diesel', 'hybrid'])->default('pertalite');
            $table->unsignedTinyInteger('seat_capacity')->default(5); // Pembeda mobil biasa (5-7) vs mini bus (14-16)
            $table->unsignedTinyInteger('luggage_capacity')->default(2); // jumlah bagasi/koper
            $table->unsignedInteger('mileage_km')->nullable(); // odometer, ditampilkan di halaman detail
            $table->decimal('price_per_day', 12, 2);
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // {"Air Conditioner": true, "GPS": false, ...}
            $table->boolean('is_featured')->default(false); // muncul di carousel "Featured Vehicles"
            $table->enum('status', ['active', 'maintenance'])->default('active');
            $table->timestamps();

            $table->index(['status', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
