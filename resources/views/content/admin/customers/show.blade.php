@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <h4 class="fw-bold mb-0">Detail Pelanggan</h4>
  <a href="{{ route('admin.customers.index') }}" class="btn btn-label-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali</a>
</div>

@include('content.admin._partials.flash')

<div class="row">
  <div class="col-lg-5 mb-4">
    <div class="card h-100">
      <h5 class="card-header">Akun &amp; Kontak</h5>
      <div class="card-body">
        <div class="d-flex align-items-center mb-3">
          <span class="avatar avatar-lg me-3">
            <span class="avatar-initial rounded bg-label-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
          </span>
          <div>
            <h5 class="mb-0">{{ $user->name }}</h5>
            <small class="text-muted">{{ $user->email }}</small>
          </div>
        </div>
        <div class="row g-3">
          <div class="col-12">
            <span class="text-muted d-block">Nomor Telepon</span>
            <span class="fw-semibold">{{ $user->identity?->phone ?? '-' }}</span>
          </div>
          <div class="col-12">
            <span class="text-muted d-block">Alamat</span>
            <span class="fw-semibold">{{ $user->identity?->address ?? '-' }}</span>
          </div>
          <div class="col-12">
            <span class="text-muted d-block">Terdaftar</span>
            <span class="fw-semibold">{{ $user->created_at->format('d M Y') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-7 mb-4">
    <div class="card h-100">
      <h5 class="card-header">Riwayat Pesanan</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Mobil</th>
              <th>Jadwal</th>
              <th>Total</th>
              <th>Status</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($bookings as $booking)
            <tr>
              <td><span class="fw-semibold">{{ $booking->booking_code }}</span></td>
              <td>{{ $booking->car->name ?? '-' }}</td>
              <td><small>{{ $booking->start_time->format('d M Y') }} &rarr; {{ $booking->end_time->format('d M Y') }}</small></td>
              <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
              <td>@include('content.admin._partials.bookingStatus', ['status' => $booking->status])</td>
              <td class="text-end">
                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-icon btn-label-primary" title="Detail"><i class="ti ti-eye"></i></a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Pelanggan belum memiliki pesanan.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
