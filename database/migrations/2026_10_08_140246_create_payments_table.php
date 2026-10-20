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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();

            // Metode pembayaran sederhana untuk skala UMKM: tunai atau transfer bank.
            $table->enum('method', ['cash', 'transfer'])->default('transfer');

            // Rekening tujuan transfer (tidak dipakai saat metode cash).
            $table->foreignId('rental_bank_account_id')->nullable()->constrained('rental_bank_accounts')->nullOnDelete();

            $table->string('number', 40)->unique(); // kode pembayaran internal (PAY-xxxx)
            $table->decimal('amount', 12, 2);
            $table->enum('status', [
                'pending',          // record dibuat, menunggu pembayaran
                'submitted',        // bukti transfer diupload, menunggu verifikasi admin
                'completed',        // lunas (uang cash diterima / transfer divalidasi admin)
                'rejected',         // bukti transfer ditolak admin
                'expired',          // lewat batas waktu
            ])->default('pending');

            // Bukti transfer dari penyewa (kosong untuk metode cash).
            $table->string('proof_image_path')->nullable();
            $table->text('customer_notes')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('paid_at')->nullable();

            // Verifikasi manual oleh admin (cash & transfer).
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->dateTime('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index(['booking_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
