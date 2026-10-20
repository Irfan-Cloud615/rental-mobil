<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    /** Sama seperti Car::ACTIVE_BOOKING_STATUSES, dipakai untuk cek benturan jadwal. */
    public const ACTIVE_STATUSES = ['pending_payment', 'waiting_verification', 'confirmed'];

    protected $fillable = [
        'user_id',
        'car_id',
        'booking_code',
        'pickup_location',
        'dropoff_location',
        'start_time',
        'end_time',
        'status',
        'total_price',
        'customer_note',
        'expires_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'expires_at' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Booking dianggap lunas jika sudah ada pembayaran berstatus completed.
     */
    public function isPaid(): bool
    {
        return $this->payments()->whereIn('status', Payment::PAID_STATUSES)->exists();
    }
}
