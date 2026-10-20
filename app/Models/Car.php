<?php

namespace App\Models;

use App\Models\Concerns\ResolvesMediaUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Car extends Model
{
    use HasFactory, ResolvesMediaUrl;

    /**
     * Status booking yang berarti mobil sedang diboooking.
     * Selain dua ini (completed, cancelled) berarti mobil tidak ada yang booking.
     */
    public const ACTIVE_BOOKING_STATUSES = ['pending_payment', 'waiting_verification', 'confirmed'];

    protected $fillable = [
        'name',
        'slug',
        'brand',
        'image_path',
        'license_plate',
        'transmission',
        'fuel_type',
        'seat_capacity',
        'luggage_capacity',
        'mileage_km',
        'price_per_day',
        'description',
        'features',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'seat_capacity' => 'integer',
        'luggage_capacity' => 'integer',
        'mileage_km' => 'integer',
        'price_per_day' => 'decimal:2',
        'features' => 'array',
        'is_featured' => 'boolean',
    ];

    /**
     * Slug otomatis dari nama mobil supaya factory/admin tidak perlu mengisi manual.
     */
    protected static function booted(): void
    {
        static::creating(function (Car $car) {
            if (blank($car->slug)) {
                $car->slug = Str::slug($car->name ?? 'mobil') . '-' . Str::random(6);
            }
        });
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Booking yang masih aktif (tidak termasuk completed/cancelled), terbaru lebih dulu.
     */
    public function activeBookings(): HasMany
    {
        return $this->bookings()
            ->whereIn('status', self::ACTIVE_BOOKING_STATUSES)
            ->orderByDesc('start_time');
    }

    /**
     * URL gambar lengkap: URL eksternal dipakai apa adanya, path lokal diambil dari disk public.
     */
    protected function imageUrl(): Attribute
    {
        return $this->mediaUrl($this->image_path, 'landing/images/car-1.jpg');
    }
}
