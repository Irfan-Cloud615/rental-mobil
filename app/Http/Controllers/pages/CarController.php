<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function show(Car $car)
    {
        // Muat booking aktif untuk menentukan status ketersediaan mobil.
        $car->load('activeBookings');
        $isBooked = $car->activeBookings->isNotEmpty();

        return view('content.pages.car-detail', compact('car', 'isBooked'));
    }
}
