<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Daftar seluruh transaksi pemesanan dengan filter status & pencarian.
     */
    public function index(Request $request)
    {
        $bookings = Booking::with(['user', 'car'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%' . $request->input('q') . '%';
                $q->where(function ($qq) use ($term) {
                    $qq->where('booking_code', 'like', $term)
                        ->orWhereHas('user', fn($u) => $u->where('name', 'like', $term)->orWhere('email', 'like', $term));
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('content.admin.bookings.index', compact('bookings'));
    }

    /**
     * Detail satu pemesanan beserta pembayaran terkait.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user.identity', 'car', 'payments.rentalBankAccount', 'payments.verifiedBy']);

        return view('content.admin.bookings.show', compact('booking'));
    }

    /**
     * Ubah status pesanan (mis. menjadi completed / cancelled / confirmed).
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending_payment', 'waiting_verification', 'confirmed', 'completed', 'cancelled'])],
        ], [
            'status.required' => 'Status pesanan wajib dipilih.',
            'status.in' => 'Status pesanan tidak valid.',
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pesanan ' . $booking->booking_code . ' diubah menjadi ' . $booking->status . '.');
    }
}
