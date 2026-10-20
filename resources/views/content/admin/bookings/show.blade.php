@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Detail Pesanan ' . $booking->booking_code)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <h4 class="fw-bold mb-0">Detail Pesanan <span class="text-muted">{{ $booking->booking_code }}</span></h4>
  <a href="{{ route('admin.bookings.index') }}" class="btn btn-label-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali</a>
</div>

@include('content.admin._partials.flash')

<div class="row">
  <div class="col-lg-7 mb-4">
    <div class="card h-100">
      <h5 class="card-header">Informasi Sewa</h5>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <span class="text-muted d-block">Penyewa</span>
            <span class="fw-semibold">{{ $booking->user->name ?? '-' }}</span>
            <div><small class="text-muted">{{ $booking->user->email ?? '' }}</small></div>
            @if ($booking->user && $booking->user->identity)
            <div><small class="text-muted">{{ $booking->user->identity->phone }} &middot; {{ $booking->user->identity->address }}</small></div>
            @endif
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Mobil</span>
            <span class="fw-semibold">{{ $booking->car->name ?? '-' }}</span>
            <div><small class="text-muted">{{ $booking->car->license_plate ?? '' }}</small></div>
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Waktu Ambil</span>
            <span class="fw-semibold">{{ $booking->start_time->format('d M Y H:i') }}</span>
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Waktu Kembali</span>
            <span class="fw-semibold">{{ $booking->end_time->format('d M Y H:i') }}</span>
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Lokasi Penjemputan</span>
            <span class="fw-semibold">{{ $booking->pickup_location ?: '-' }}</span>
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Lokasi Pengembalian</span>
            <span class="fw-semibold">{{ $booking->dropoff_location ?: '-' }}</span>
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Total Biaya</span>
            <span class="fw-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Status</span>
            @include('content.admin._partials.bookingStatus', ['status' => $booking->status])
          </div>
          @if ($booking->customer_note)
          <div class="col-12">
            <span class="text-muted d-block">Catatan Pelanggan</span>
            <span>{{ $booking->customer_note }}</span>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-5 mb-4">
    <div class="card h-100">
      <h5 class="card-header">Ubah Status Pesanan</h5>
      <div class="card-body">
        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
          @csrf @method('PATCH')
          <div class="mb-3">
            <label class="form-label" for="status">Status</label>
            <select name="status" id="status" class="form-select">
              @foreach (['pending_payment' => 'Menunggu Pembayaran', 'waiting_verification' => 'Menunggu Verifikasi', 'confirmed' => 'Dikonfirmasi', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $lbl)
              <option value="{{ $val }}" @selected($booking->status == $val)>{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Simpan Status</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card">
      <h5 class="card-header">Pembayaran Terkait</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>Nomor</th>
              <th>Metode</th>
              <th>Nominal</th>
              <th>Status</th>
              <th>Diverifikasi Oleh</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($booking->payments as $payment)
            <tr>
              <td>{{ $payment->number }}</td>
              <td>{{ ucfirst($payment->method) }}</td>
              <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
              <td>@include('content.admin._partials.paymentStatus', ['status' => $payment->status])</td>
              <td>{{ $payment->verifiedBy->name ?? '-' }}</td>
              <td class="text-end">
                <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-icon btn-label-primary" title="Lihat pembayaran"><i class="ti ti-receipt"></i></a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Belum ada pembayaran.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
