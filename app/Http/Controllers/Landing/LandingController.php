<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
  /**
   * Mobil aktif + penanda sedang diboooking, dipakai semua halaman listing.
   */
  protected function availableCarsQuery()
  {
    return Car::query()
      ->where('status', 'active')
      ->withExists([
        'activeBookings as is_booked',
      ]);
  }

  public function index(): View
  {
    $featuredCars = $this->availableCarsQuery()
      ->orderByDesc('price_per_day')
      ->take(8)
      ->get();

    return view('landing.index', [
      'title' => 'Home',
      'activeNav' => 'index',
      'featuredCars' => $featuredCars,
      'stats' => $this->stats(),
    ]);
  }

  public function about(): View
  {
    return view('landing.about', [
      'title' => 'About Us',
      'activeNav' => 'about',
      'stats' => $this->stats(),
    ]);
  }

  public function cars(Request $request): View
  {
    // Pilihan kapasitas kursi diambil dari data mobil aktif supaya filter tidak hardcoded.
    $seatOptions = Car::query()
      ->where('status', 'active')
      ->distinct()
      ->orderBy('seat_capacity')
      ->pluck('seat_capacity');

    $cars = $this->availableCarsQuery()
      ->when($request->filled('transmission'), fn($q) => $q->where('transmission', $request->input('transmission')))
      ->when($request->filled('seat_capacity'), fn($q) => $q->where('seat_capacity', $request->input('seat_capacity')))
      ->orderBy('name')
      ->paginate(9)
      ->withQueryString();

    return view('landing.car', [
      'title' => 'Choose Your Car',
      'activeNav' => 'cars',
      'cars' => $cars,
      'seatOptions' => $seatOptions,
    ]);
  }

  public function carShow(Car $car): View
  {
    $car->load('activeBookings');

    return view('landing.car-single', [
      'title' => $car->name,
      'activeNav' => 'cars',
      'car' => $car,
      'isBooked' => $car->activeBookings->isNotEmpty(),
      'relatedCars' => $this->availableCarsQuery()->whereKeyNot($car->getKey())->take(4)->get(),
    ]);
  }

  public function contact(): View
  {
    return view('landing.contact', [
      'title' => 'Contact Us',
      'activeNav' => 'contact',
    ]);
  }

  /**
   * Angka statistik untuk counter di beranda & about (jumlah mobil & pelanggan unik).
   */
  protected function stats(): array
  {
    return [
      'cars' => Car::count(),
      'customers' => Booking::distinct('user_id')->count('user_id'),
    ];
  }
}
