@php
 $pageConfigs = ['myLayout' => 'horizontal'];
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Akun /</span> Riwayat Pesanan</h4>
  <a href="{{ route('home') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i> Pesan Mobil</a>
</div>

<div class="card">
  @if ($bookings->isEmpty())
  <div class="card-body text-center py-5">
    <p class="text-muted mb-3">Belum ada riwayat pesanan.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Cari Mobil Sekarang</a>
  </div>
  @else
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Mobil</th>
          <th>Periode Sewa</th>
          <th>Total</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bookings as $booking)
        <tr>
          <td><span class="fw-semibold">{{ $booking->booking_code }}</span></td>
          <td>
            <div class="d-flex align-items-center">
              @if ($booking->car)
              <img src="{{ $booking->car->image_url }}" alt="{{ $booking->car->name }}" class="rounded me-2" style="width:44px;height:32px;object-fit:cover" />
              @endif
              <span>{{ $booking->car->name ?? '-' }}</span>
            </div>
          </td>
          <td>
            <small>{{ $booking->start_time->format('d M Y') }} &rarr; {{ $booking->end_time->format('d M Y') }}</small>
          </td>
          <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
          <td>@include('content.pages._partials.booking-status', ['status' => $booking->status])</td>
          <td class="text-end">
            @if ($booking->car)
            <a href="{{ route('booking.create', $booking->car) }}" class="btn btn-sm btn-label-primary" title="Pesan lagi">Pesan Lagi</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
@endsection
