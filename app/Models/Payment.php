<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    /** Status yang berarti uang belum diterima. */
    public const PENDING_STATUSES = ['pending', 'submitted'];

    /** Status yang berarti pembayaran dianggap lunas. */
    public const PAID_STATUSES = ['completed'];

    protected $fillable = [
        'booking_id',
        'method',
        'rental_bank_account_id',
        'provider_invoice_id',
        'number',
        'amount',
        'status',
        'proof_image_path',
        'customer_notes',
        'expires_at',
        'paid_at',
        'verified_by',
        'verified_at',
        'rejection_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Kode pembayaran otomatis supaya caller tidak perlu mengisi manual.
     */
    protected static function booted(): void
    {
        static::creating(function (Payment $payment) {
            if (blank($payment->number)) {
                $payment->number = 'PAY-' . strtoupper(Str::random(8));
            }
        });
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function rentalBankAccount(): BelongsTo
    {
        return $this->belongsTo(RentalBankAccount::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isPaid(): bool
    {
        return in_array($this->status, self::PAID_STATUSES, true);
    }

    public function isPending(): bool
    {
        return in_array($this->status, self::PENDING_STATUSES, true);
    }

    /**
     * Metode cash tidak meminta bukti transfer.
     */
    public function needsProof(): bool
    {
        return $this->method !== 'cash' && blank($this->proof_image_path);
    }

    /**
     * Tandai lunas: dipakai admin saat uang cash diterima atau transfer diverifikasi.
     */
    public function markAsPaid(?User $verifier = null): static
    {
        $this->status = 'completed';
        $this->paid_at = $this->paid_at ?? now();
        $this->verified_at = now();
        $this->verified_by = $verifier?->id ?? $this->verified_by;
        $this->save();

        return $this;
    }
}
