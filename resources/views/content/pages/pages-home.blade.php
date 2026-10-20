@php
 $pageConfigs = ['myLayout' => 'horizontal'];
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
<h4 class="fw-bold py-3 mb-4">Daftar Mobil</h4>

@if ($cars->count())
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
  @foreach ($cars as $car)
  <div class="col">
    <div class="card h-100">
      <img class="card-img-top" src="{{ $car->image_url }}" alt="{{ $car->name }}" style="height: 200px; object-fit: cover;" />
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $car->name }}</h5>
        <h6 class="card-subtitle text-muted">{{ $car->brand }}</h6>
        <p class="card-text">
          <span class="fw-bold">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
          <span class="text-muted">/hari</span>
        </p>
        <p class="card-text">
          <span class="text-muted">{{ $car->seat_capacity }} kursi</span>
          <span class="text-muted">&middot;</span>
          <span class="text-muted">{{ ucfirst($car->transmission) }}</span>
        </p>
        <p class="card-text">
          <small class="{{ $car->is_booked ? 'text-danger' : 'text-success' }}">
            {{ $car->is_booked ? 'Sedang diboooking' : 'Tersedia' }}
          </small>
        </p>
        <div class="d-flex gap-2 mt-auto">
          <a href="{{ route('car.detail', $car) }}" class="btn btn-outline-primary flex-fill">Detail</a>
          <a href="{{ route('booking.create', $car) }}" class="btn btn-primary flex-fill">Pesan Sekarang</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
@else
<p class="text-muted">Belum ada mobil yang tersedia.</p>
@endif
@endsection
