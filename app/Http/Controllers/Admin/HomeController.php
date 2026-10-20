<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Dashboard ringkasan: memantau status pesanan & angka kunci operasional.
     */
    public function index()
    {
        // Hitung pesanan per status pada tabel bookings.
        $statusCounts = Booking::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'pending_payment' => (int) ($statusCounts['pending_payment'] ?? 0),
            'waiting_verification' => (int) ($statusCounts['waiting_verification'] ?? 0),
            'confirmed' => (int) ($statusCounts['confirmed'] ?? 0),
            'completed' => (int) ($statusCounts['completed'] ?? 0),
            'cancelled' => (int) ($statusCounts['cancelled'] ?? 0),
            'total_bookings' => Booking::count(),
            'cars_active' => Car::where('status', 'active')->count(),
            'cars_total' => Car::count(),
            'customers' => User::where('role', 'user')->count(),
            'payments_pending' => Payment::whereIn('status', Payment::PENDING_STATUSES)
                ->whereNotNull('proof_image_path')
                ->count(),
        ];

        // Butuh perhatian: pesanan baru (pending) & menunggu verifikasi.
        $needAttention = Booking::with(['user', 'car'])
            ->whereIn('status', ['pending_payment', 'waiting_verification'])
            ->latest()
            ->take(8)
            ->get();

        $recentBookings = Booking::with(['user', 'car'])
            ->latest()
            ->take(8)
            ->get();

        return view('content.admin.home', compact('stats', 'needAttention', 'recentBookings'));
    }
}
