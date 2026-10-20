@php
$pageConfigs = ['myLayout' => 'horizontal'];
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Hasil Pembayaran')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Booking /</span> Hasil Pembayaran</h4>

<div class="row">
  <div class="col-lg-8 mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="text-center mb-4">
          <span class="badge {{ $paid ? 'bg-label-success' : 'bg-label-warning' }} p-2">
            {{ $statusLabel }}
          </span>
        </div>

        @if ($booking)
        <h5 class="card-title">Booking {{ $booking->booking_code }}</h5>
        <p class="card-text">
          <span class="fw-semibold">{{ $booking->car->name ?? 'Mobil' }}</span>
        </p>

        <p class="card-text d-flex justify-content-between">
          <span class="text-muted">Periode sewa</span>
          <span class="fw-semibold">{{ \Illuminate\Support\Carbon::parse($booking->start_time)->format('d M Y H:i') }} &ndash; {{ \Illuminate\Support\Carbon::parse($booking->end_time)->format('d M Y H:i') }}</span>
        </p>
        <p class="card-text d-flex justify-content-between">
          <span class="text-muted">Total</span>
          <span class="fw-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
        </p>
        <p class="card-text d-flex justify-content-between">
          <span class="text-muted">Status booking</span>
          <span class="fw-semibold">{{ $booking->status }}</span>
        </p>

        @if ($paid)
        <div class="alert alert-success mt-3 mb-0">
          Pembayaran terverifikasi. Booking Anda berstatus <b>confirmed</b>.
        </div>
        @else
        <div class="alert alert-warning mt-3 mb-0">
          Pembayaran belum terverifikasi. Jika Anda sudah membayar, status akan diperbarui otomatis setelah konfirmasi dari Xendit.
        </div>
        @endif

        <div class="d-flex gap-2 mt-4">
          <a href="{{ route('home') }}" class="btn btn-primary flex-fill">Kembali ke Beranda</a>
          @if ($booking->car)
          <a href="{{ route('car.detail', $booking->car) }}" class="btn btn-label-secondary flex-fill">Detail Mobil</a>
          @endif
        </div>
        @else
        <p class="text-center text-muted mb-0">
          {{ $statusLabel }}. Data booking belum tersimpan &mdash; pemesanan baru dibuat setelah pembayaran terverifikasi.
        </p>
        <div class="text-center mt-3">
          <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
