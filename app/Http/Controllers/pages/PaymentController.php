<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;

class PaymentController extends Controller
{
    /**
     * Tujuan redirect Xendit saat pembayaran BERHASIL.
     * Tabel bookings baru diisi di sini (setelah status invoice terverifikasi lunas).
     */
    public function success(Request $request)
    {
        $invoiceId = $request->query('invoice_id') ?? $request->query('id');

        // Idempoten: invoice ini sudah pernah diproses?
        if ($invoiceId) {
            $existing = Payment::where('provider_invoice_id', $invoiceId)->with('booking.car')->first();
            if ($existing && $existing->booking) {
                return $this->renderResult($existing->booking, true, 'Lunas');
            }
        }

        if (!$invoiceId) {
            return $this->renderResult(null, false, 'Invoice tidak dikenali');
        }

        Configuration::setXenditKey((string) config('services.xendit.secret'));

        try {
            $invoice = (new InvoiceApi())->getInvoiceById($invoiceId);
        } catch (\Throwable $e) {
            report($e);

            return $this->renderResult(null, false, 'Menunggu verifikasi pembayaran');
        }

        $status = $invoice->getStatus();
        $status = is_object($status) && method_exists($status, 'getValue') ? $status->getValue() : (string) $status;

        if (in_array($status, ['PAID', 'SETTLED'], true)) {
            $booking = $this->createBookingFromInvoice($invoice, $invoiceId);

            return $booking
                ? $this->renderResult($booking, true, 'Lunas')
                : $this->renderResult(null, false, 'Data pemesanan tidak valid');
        }

        if ($status === 'EXPIRED') {
            return $this->renderResult(null, false, 'Kedaluwarsa');
        }

        // Status masih PENDING dsb: belum lunas, booking tidak dibuat.
        return $this->renderResult(null, false, 'Sedang diproses');
    }

    /**
     * Tujuan redirect Xendit saat pembayaran GAGAL/DIBATALKAN.
     * Tidak menulis apa pun ke tabel bookings.
     */
    public function failed(Request $request)
    {
        return $this->renderResult(null, false, 'Pembayaran gagal atau dibatalkan');
    }

    /**
     * Rekonstruksi booking dari metadata invoice (data yang dikirim saat "Booking Sekarang").
     */
    private function createBookingFromInvoice($invoice, string $invoiceId): ?Booking
    {
        $metadata = (array) ($invoice->getMetadata() ?? []);

        $car = Car::find($metadata['car_id'] ?? null);
        $user = User::find($metadata['user_id'] ?? null);

        if (!$car || !$user || empty($metadata['start_time']) || empty($metadata['end_time'])) {
            return null;
        }

        $start = Carbon::parse($metadata['start_time']);
        $end = Carbon::parse($metadata['end_time']);
        $total = isset($metadata['total_price']) ? (float) $metadata['total_price'] : (float) $invoice->getAmount();

        return DB::transaction(function () use ($car, $user, $metadata, $start, $end, $total, $invoiceId) {
            $booking = $car->bookings()->create([
                'user_id' => $user->id,
                'booking_code' => 'BK-' . strtoupper(Str::random(10)),
                'pickup_location' => $metadata['pickup_location'] ?: null,
                'dropoff_location' => $metadata['dropoff_location'] ?: null,
                'start_time' => $start,
                'end_time' => $end,
                'status' => 'confirmed',
                'total_price' => $total,
                'customer_note' => $metadata['customer_note'] ?: null,
                'expires_at' => $end,
            ]);

            $booking->payments()->create([
                'method' => 'transfer',
                'provider_invoice_id' => $invoiceId,
                'amount' => $total,
                'status' => 'completed',
                'expires_at' => $end,
                'paid_at' => now(),
            ]);

            return $booking;
        });
    }

    private function renderResult(?Booking $booking, bool $paid, string $statusLabel)
    {
        if ($booking) {
            $booking->load('car');
        }

        return view('content.pages.payment-result', [
            'booking' => $booking,
            'paid' => $paid,
            'statusLabel' => $statusLabel,
        ]);
    }
}
