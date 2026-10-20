<?php

use App\Http\Controllers\authentications\Login;
use App\Http\Controllers\authentications\Register;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\pages\BookingController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\RentalBankAccountController as AdminBankController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\pages\CarController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
  // Dashboard
  Route::get('/', [AdminHomeController::class, 'index'])->name('home');

  // Data Mobil
  Route::resource('cars', AdminCarController::class)->except(['show']);
  Route::patch('cars/{car}/toggle-featured', [AdminCarController::class, 'toggleFeatured'])->name('cars.toggle-featured');
  Route::patch('cars/{car}/toggle-status', [AdminCarController::class, 'toggleStatus'])->name('cars.toggle-status');

  // Data Pemesanan
  Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
  Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
  Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');

  // Verifikasi Pembayaran
  Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
  Route::get('payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
  Route::patch('payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
  Route::patch('payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

  // Rekening Bank
  Route::resource('bank-accounts', AdminBankController::class)->except(['show']);
  Route::patch('bank-accounts/{bank_account}/toggle-active', [AdminBankController::class, 'toggleActive'])->name('bank-accounts.toggle-active');

  // Data Pelanggan
  Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
  Route::get('customers/{user}', [AdminCustomerController::class, 'show'])->name('customers.show');
});

// Autentikasi (login & registrasi)
Route::middleware('guest')->group(function () {
  Route::get('login', [Login::class, 'index'])->name('login');
  Route::post('login', [Login::class, 'store'])->name('login.store');
  Route::get('register', [Register::class, 'index'])->name('register');
  Route::post('register', [Register::class, 'store'])->name('register.store');
});
Route::post('logout', [Login::class, 'destroy'])->name('logout');

// Halaman user (setelah login dengan role user)
Route::middleware(['auth'])->group(function () {
  Route::get('home', [HomePage::class, 'index'])->name('home');
  Route::get('car/{car}', [CarController::class, 'show'])->name('car.detail')->whereNumber('car');
  Route::get('car/{car}/booking', [BookingController::class, 'create'])->name('booking.create')->whereNumber('car');
  Route::post('car/{car}/booking', [BookingController::class, 'store'])->name('booking.store')->whereNumber('car');

  // Pesanan & riwayat milik pengguna yang login
  Route::get('pesanan-saya', [BookingController::class, 'myOrders'])->name('pesanan-saya.index');
  Route::get('riwayat', [BookingController::class, 'history'])->name('riwayat.index');

  // Halaman tujuan redirect dari payment gateway Xendit
  Route::get('payment-success', [PaymentController::class, 'success'])->name('payment.success');
  Route::get('payment-failed', [PaymentController::class, 'failed'])->name('payment.failed');
});

// Halaman publik (landing) hasil konversi template carbook-master

  Route::get('/', [LandingController::class, 'index'])->name('landing.index');
  Route::get('about', [LandingController::class, 'about'])->name('landing.about');
  Route::get('cars', [LandingController::class, 'cars'])->name('landing.cars');
  Route::get('cars/{car}', [LandingController::class, 'carShow'])->name('landing.cars.show')->whereNumber('car');
  Route::get('contact', [LandingController::class, 'contact'])->name('landing.contact');
