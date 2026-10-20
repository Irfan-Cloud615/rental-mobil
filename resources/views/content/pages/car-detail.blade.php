@php
$pageConfigs = ['myLayout' => 'horizontal'];
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Detail ' . $car->name)

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mobil /</span> Detail</h4>

<div class="row">
  <!-- Gambar mobil -->
  <div class="col-lg-7 col-md-6 mb-4">
    <div class="card h-100">
      <img class="card-img-top" src="{{ $car->image_url }}" alt="{{ $car->name }}" style="height: 100%; min-height: 320px; object-fit: cover;" />
    </div>
  </div>
  <!-- /Gambar mobil -->

  <!-- Informasi & aksi -->
  <div class="col-lg-5 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title mb-1">{{ $car->name }}</h5>
        <h6 class="card-subtitle text-muted mb-3">{{ $car->brand }}</h6>

        <p class="card-text mb-3">
          <span class="fw-bold fs-4">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
          <span class="text-muted">/hari</span>
        </p>

        <p class="card-text">
          <span class="badge {{ $isBooked ? 'bg-label-danger' : 'bg-label-success' }}">
            {{ $isBooked ? 'Sedang diboooking' : 'Tersedia' }}
          </span>
        </p>

        <div class="row g-2 my-3">
          <div class="col-6">
            <span class="text-muted d-block">Transmisi</span>
            <span class="fw-semibold">{{ ucfirst($car->transmission) }}</span>
          </div>
          <div class="col-6">
            <span class="text-muted d-block">Kursi</span>
            <span class="fw-semibold">{{ $car->seat_capacity }} kursi</span>
          </div>
          <div class="col-6">
            <span class="text-muted d-block">Bahan Bakar</span>
            <span class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $car->fuel_type)) }}</span>
          </div>
          <div class="col-6">
            <span class="text-muted d-block">Bagasi</span>
            <span class="fw-semibold">{{ $car->luggage_capacity }} koper</span>
          </div>
          <div class="col-6">
            <span class="text-muted d-block">Plat Nomor</span>
            <span class="fw-semibold">{{ $car->license_plate }}</span>
          </div>
          <div class="col-6">
            <span class="text-muted d-block">Odometer</span>
            <span class="fw-semibold">{{ number_format($car->mileage_km, 0, ',', '.') }} km</span>
          </div>
        </div>

        <div class="d-flex gap-2 mt-auto">
          <a href="{{ route('home') }}" class="btn btn-label-secondary flex-fill">Kembali</a>
          @unless ($isBooked)
          <a href="{{ route('booking.create', $car) }}" class="btn btn-primary flex-fill">Pesan Sekarang</a>
          @endunless
        </div>
      </div>
    </div>
  </div>
  <!-- /Informasi & aksi -->

  <!-- Deskripsi -->
  <div class="col-12 mb-4">
    <div class="card">
      <h5 class="card-header">Deskripsi</h5>
      <div class="card-body">
        <p class="card-text mb-0">{{ $car->description ?: 'Tidak ada deskripsi untuk mobil ini.' }}</p>
      </div>
    </div>
  </div>
  <!-- /Deskripsi -->

  <!-- Fitur -->
  @if (!empty($car->features))
  <div class="col-12">
    <div class="card">
      <h5 class="card-header">Fitur</h5>
      <div class="card-body">
        <ul class="mb-0">
          @foreach ($car->features as $key => $value)
          <li>{{ is_string($key) ? ucfirst(str_replace('_', ' ', $key)) : $value }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  @endif
  <!-- /Fitur -->
</div>
@endsection
