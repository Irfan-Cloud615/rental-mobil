<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class BookingController extends Controller
{
    /**
     * Tampilkan form pemesanan untuk satu mobil.
     */
    public function create(Car $car)
    {
        $car->load('activeBookings');
        $isBooked = $car->activeBookings->isNotEmpty();

        return view('content.pages.booking', compact('car', 'isBooked'));
    }

    /**
     * Booking belum disimpan ke tabel. Yang dibuat hanya invoice Xendit;
     * detail sewa dititipkan di metadata invoice dan baru ditulis ke tabel
     * bookings pada callback payment-success (lihat PaymentController).
     */
    public function store(Request $request, Car $car)
    {
        $validated = $request->validate([
            'pickup_location' => ['nullable', 'string', 'max:150'],
            'dropoff_location' => ['nullable', 'string', 'max:150'],
            'start_time' => ['required', 'date', 'after:now'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'customer_note' => ['nullable', 'string', 'max:2000'],
        ], [
            'start_time.required' => 'Waktu mulai sewa wajib diisi.',
            'start_time.date' => 'Format waktu mulai sewa tidak valid.',
            'start_time.after' => 'Waktu mulai sewa tidak boleh sebelum sekarang.',
            'end_time.required' => 'Waktu selesai sewa wajib diisi.',
            'end_time.date' => 'Format waktu selesai sewa tidak valid.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        $start = Carbon::parse($validated['start_time']);
        $end = Carbon::parse($validated['end_time']);

        // Tolak jika mobil sudah diboooking pada rentang waktu yang tumpang tindih.
        $clash = Booking::where('car_id', $car->id)
            ->whereIn('status', Car::ACTIVE_BOOKING_STATUSES)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            ->exists();

        if ($clash) {
            return back()
                ->withInput()
                ->withErrors(['start_time' => 'Mobil sudah diboooking pada periode tersebut, silakan pilih jadwal lain.']);
        }

        // Estimasi durasi sewa (hari, dibulatkan ke atas) & total biaya.
        $days = max(1, (int) ceil($start->diffInMinutes($end) / (60 * 24)));
        $total = $days * $car->price_per_day;

        // Token sementara (bukan booking_code) sebagai external_id invoice.
        $externalId = 'PEND-' . strtoupper(Str::random(10));

        Configuration::setXenditKey((string) config('services.xendit.secret'));

        try {
            $api = new InvoiceApi();
            $invoice = $api->createInvoice(new CreateInvoiceRequest([
                'external_id' => $externalId,
                'amount' => (float) $total,
                'currency' => 'IDR',
                'description' => 'Sewa ' . $car->name . ' (' . $start->format('d M Y H:i') . ' - ' . $end->format('d M Y H:i') . ')',
                'success_redirect_url' => config('services.xendit.success_url'),
                'failure_redirect_url' => config('services.xendit.failure_url'),
                'invoice_duration' => 86400,
                'metadata' => [
                    'user_id' => (string) $request->user()->id,
                    'car_id' => (string) $car->id,
                    'pickup_location' => (string) ($validated['pickup_location'] ?? ''),
                    'dropoff_location' => (string) ($validated['dropoff_location'] ?? ''),
                    'start_time' => $start->toIso8601String(),
                    'end_time' => $end->toIso8601String(),
                    'total_price' => (string) $total,
                    'customer_note' => (string) ($validated['customer_note'] ?? ''),
                ],
            ]));

            // Belum ada baris bookings yang ditulis di sini.
            return redirect()->away($invoice->getInvoiceUrl());
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors(['start_time' => 'Gerbang pembayaran tidak dapat dihubungi. Silakan coba lagi.']);
        }
    }

    /**
     * Pesanan Saya: booking aktif milik pengguna yang sedang login
     * (menunggu pembayaran, verifikasi, atau sudah dikonfirmasi).
     */
    public function myOrders(Request $request)
    {
        $bookings = Booking::with(['car', 'payments'])
            ->where('user_id', $request->user()->id)
            ->whereIn('status', Booking::ACTIVE_STATUSES)
            ->orderBy('start_time')
            ->get();

        return view('content.pages.pesanan-saya', compact('bookings'));
    }

    /**
     * Riwayat Pesanan: booking yang telah selesai atau dibatalkan.
     */
    public function history(Request $request)
    {
        $bookings = Booking::with(['car'])
            ->where('user_id', $request->user()->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderByDesc('end_time')
            ->get();

        return view('content.pages.riwayat', compact('bookings'));
    }
}
