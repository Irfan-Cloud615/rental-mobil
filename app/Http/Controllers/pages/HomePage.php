<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class HomePage extends Controller
{
  /**
   * Status booking yang berarti mobil sedang diboooking.
   * Selain dua ini (completed, cancelled) berarti mobil tidak ada yang booking.
   */
  public const ACTIVE_BOOKING_STATUSES = ['pending_payment', 'waiting_verification', 'confirmed'];

  public function index(Request $request)
  {
    // Query filter dari dropdown/input di kolom pertama
    $query = Car::withExists([
      'bookings as is_booked' => fn($q) => $q->whereIn('status', self::ACTIVE_BOOKING_STATUSES),
    ]);

    $query->when($request->filled('transmission'), fn($q) => $q->where('transmission', $request->input('transmission')))
      ->when($request->filled('seat_capacity'), fn($q) => $q->where('seat_capacity', $request->input('seat_capacity')))
      ->when($request->filled('status'), fn($q) => $q->where('status', $request->input('status')))
      ->when($request->filled('min_price'), fn($q) => $q->where('price_per_day', '>=', $request->input('min_price')))
      ->when($request->filled('max_price'), fn($q) => $q->where('price_per_day', '<=', $request->input('max_price')));

    $cars = $query->orderBy('name')->get();

    // Opsi seat capacity yang tersedia di database (untuk filter)
    $seatCapacities = Car::distinct()->orderBy('seat_capacity')->pluck('seat_capacity');

    // Mobil yang dipilih untuk ditampilkan di kolom ketiga
    $selectedCar = null;
    $activeBooking = null;
    if ($request->filled('car')) {
      $selectedCar = Car::withExists([
        'bookings as is_booked' => fn($q) => $q->whereIn('status', self::ACTIVE_BOOKING_STATUSES),
      ])->find($request->input('car'));

      if ($selectedCar) {
        $activeBooking = $selectedCar->bookings()
          ->whereIn('status', self::ACTIVE_BOOKING_STATUSES)
          ->latest('start_time')
          ->first();
      }
    }

    return view('content.pages.pages-home', compact('cars', 'seatCapacities', 'selectedCar', 'activeBooking'));
  }
}
