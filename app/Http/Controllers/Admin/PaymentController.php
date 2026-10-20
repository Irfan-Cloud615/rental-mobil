<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Antrean verifikasi pembayaran. Default menampilkan yang menunggu tinjauan.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'submitted');

        $query = Payment::with(['booking.user', 'booking.car', 'rentalBankAccount', 'verifiedBy'])
            ->when($status !== 'all', fn($q) => $q->where('status', $status));

        if ($request->filled('q')) {
            $term = '%' . $request->input('q') . '%';
            $query->where(function ($qq) use ($term) {
                $qq->where('number', 'like', $term)
                    ->orWhereHas('booking', fn($b) => $b->where('booking_code', 'like', $term));
            });
        }

        $payments = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        // Hitung jumlah per status untuk tab navigasi.
        $counts = Payment::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('content.admin.payments.index', compact('payments', 'status', 'counts'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.user.identity', 'booking.car', 'rentalBankAccount', 'verifiedBy']);

        return view('content.admin.payments.show', compact('payment'));
    }

    /**
     * Validasi bukti transfer: catat verified_by & verified_at, tandai lunas.
     */
    public function verify(Request $request, Payment $payment)
    {
        $payment->markAsPaid($request->user());

        // Pesanan terkait menjadi dikonfirmasi begitu pembayaran disetujui.
        if ($payment->booking) {
            $payment->booking->update(['status' => 'confirmed']);
        }

        return back()->with('success', 'Pembayaran ' . $payment->number . ' telah divalidasi.');
    }

    /**
     * Tolak bukti transfer dengan alasan, catat penolak sebagai audit.
     */
    public function reject(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $payment->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);

        // Kembalikan pesanan ke antrean verifikasi agar penyewa mengulang upload.
        if ($payment->booking) {
            $payment->booking->update(['status' => 'waiting_verification']);
        }

        return back()->with('success', 'Pembayaran ' . $payment->number . ' ditolak.');
    }
}
