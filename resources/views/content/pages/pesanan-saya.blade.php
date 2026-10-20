@php
 $pageConfigs = ['myLayout' => 'horizontal'];
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pesanan Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Akun /</span> Pesanan Saya</h4>
  <a href="{{ route('home') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i> Pesan Mobil</a>
</div>

@if ($bookings->isEmpty())
<div class="card">
  <div class="card-body text-center py-5">
    <p class="text-muted mb-3">Anda belum memiliki pesanan yang sedang berjalan.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Cari Mobil Sekarang</a>
  </div>
</div>
@else
<div class="row g-4">
  @foreach ($bookings as $booking)
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
          <h5 class="mb-0">{{ $booking->booking_code }}</h5>
          <small class="text-muted">Dibuat {{ $booking->created_at->format('d M Y H:i') }}</small>
        </div>
        @include('content.pages._partials.booking-status', ['status' => $booking->status])
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-sm-3">
            @if ($booking->car)
            <img src="{{ $booking->car->image_url }}" alt="{{ $booking->car->name }}" class="img-fluid rounded" style="height:96px;width:100%;object-fit:cover" />
            @endif
          </div>
          <div class="col-sm-9">
            <div class="row g-2">
              <div class="col-md-6">
                <span class="text-muted d-block">Mobil</span>
                <span class="fw-semibold">{{ $booking->car->name ?? '-' }}</span>
              </div>
              <div class="col-md-6">
                <span class="text-muted d-block">Plat Nomor</span>
                <span class="fw-semibold">{{ $booking->car->license_plate ?? '-' }}</span>
              </div>
              <div class="col-md-6">
                <span class="text-muted d-block">Ambil</span>
                <span class="fw-semibold">{{ $booking->start_time->format('d M Y H:i') }}</span>
              </div>
              <div class="col-md-6">
                <span class="text-muted d-block">Kembali</span>
                <span class="fw-semibold">{{ $booking->end_time->format('d M Y H:i') }}</span>
              </div>
              <div class="col-md-6">
                <span class="text-muted d-block">Penjemputan</span>
                <span class="fw-semibold">{{ $booking->pickup_location ?: '-' }}</span>
              </div>
              <div class="col-md-6">
                <span class="text-muted d-block">Total</span>
                <span class="fw-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex gap-2 flex-wrap">
        @if ($booking->car)
        <a href="{{ route('car.detail', $booking->car) }}" class="btn btn-label-secondary">Detail Mobil</a>
        @endif
        @if ($booking->status === 'pending_payment' && $booking->car)
        <a href="{{ route('booking.create', $booking->car) }}" class="btn btn-primary">Bayar Sekarang</a>
        @endif
      </div>
    </div>
  </div>
  @endforeach
</div>
@endif
@endsection
