@php
$pageConfigs = ['myLayout' => 'horizontal'];
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Booking ' . $car->name)

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mobil /</span> Booking</h4>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
  <div class="fw-bold mb-1">Periksa kembali isian berikut:</div>
  <ul class="mb-0">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div class="row">
  <!-- Form pemesanan -->
  <div class="col-lg-8 mb-4">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Form Pemesanan</h5>
        <small class="text-muted float-end">{{ $car->name }}</small>
      </div>
      <div class="card-body">
        <form action="{{ route('booking.store', $car) }}" method="POST" novalidate>
          @csrf

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="pickup_location">Lokasi Penjemputan</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('pickup_location') is-invalid @enderror" id="pickup_location" name="pickup_location" value="{{ old('pickup_location') }}" placeholder="Masukkan lokasi penjemputan" maxlength="150" />
              @error('pickup_location')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="dropoff_location">Lokasi Pengembalian</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('dropoff_location') is-invalid @enderror" id="dropoff_location" name="dropoff_location" value="{{ old('dropoff_location') }}" placeholder="Masukkan lokasi pengembalian" maxlength="150" />
              @error('dropoff_location')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="start_time">Mulai Sewa</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" placeholder="YYYY-MM-DD HH:MM" autocomplete="off" />
              @error('start_time')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="end_time">Selesai Sewa</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" placeholder="YYYY-MM-DD HH:MM" autocomplete="off" />
              @error('end_time')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Metode pembayaran -->
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Pembayaran</label>
            <div class="col-sm-9">
              <div class="alert alert-info mb-0 py-2">
                <small>Setelah menekan <b>Booking Sekarang</b>, Anda akan diarahkan ke halaman pembayaran aman <b>Xendit</b> (transfer bank, e-wallet, kartu, dll).</small>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="customer_note">Catatan</label>
            <div class="col-sm-9">
              <textarea class="form-control @error('customer_note') is-invalid @enderror" id="customer_note" name="customer_note" rows="3" placeholder="Permintaan tambahan (opsional)">{{ old('customer_note') }}</textarea>
              @error('customer_note')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row justify-content-end">
            <div class="col-sm-9">
              <button type="submit" class="btn btn-primary me-sm-2 me-1" @if($isBooked) disabled @endif>Booking Sekarang</button>
              <a href="{{ route('car.detail', $car) }}" class="btn btn-label-secondary">Batal</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /Form pemesanan -->

  <!-- Ringkasan mobil -->
  <div class="col-lg-4 mb-4">
    <div class="card">
      <img class="card-img-top" src="{{ $car->image_url }}" alt="{{ $car->name }}" style="height: 180px; object-fit: cover;" />
      <div class="card-body">
        <h5 class="card-title mb-1">{{ $car->name }}</h5>
        <h6 class="card-subtitle text-muted mb-3">{{ $car->brand }}</h6>

        <p class="card-text d-flex justify-content-between">
          <span class="text-muted">Harga</span>
          <span class="fw-semibold">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/hari</span>
        </p>
        <p class="card-text d-flex justify-content-between">
          <span class="text-muted">Transmisi</span>
          <span class="fw-semibold">{{ ucfirst($car->transmission) }}</span>
        </p>
        <p class="card-text d-flex justify-content-between mb-0">
          <span class="text-muted">Kursi</span>
          <span class="fw-semibold">{{ $car->seat_capacity }} kursi</span>
        </p>
      </div>
      <div class="card-footer">
        <small class="{{ $isBooked ? 'text-danger' : 'text-success' }}">
          {{ $isBooked ? 'Mobil sedang diboooking, tidak bisa dipesan saat ini.' : 'Mobil tersedia untuk dipesan.' }}
        </small>
      </div>
    </div>
  </div>
  <!-- /Ringkasan mobil -->
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const startEl = document.querySelector('#start_time');
  const endEl = document.querySelector('#end_time');

  // Flatpickr datetime (mengikuti template forms-pickers)
  let endPicker;
  const startPicker = flatpickr(startEl, {
    enableTime: true,
    dateFormat: 'Y-m-d H:i',
    minDate: 'today',
    onChange: function (selectedDates) {
      if (selectedDates[0] && endPicker) {
        endPicker.set('minDate', selectedDates[0]);
      }
    }
  });
  endPicker = flatpickr(endEl, {
    enableTime: true,
    dateFormat: 'Y-m-d H:i',
    minDate: 'today'
  });
});
</script>
@endsection
