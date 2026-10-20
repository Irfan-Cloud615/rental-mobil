@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('content')
<h4 class="fw-bold py-3 mb-4">Dashboard</h4>

@include('content.admin._partials.flash')

<div class="row">
  <!-- Kartu status pesanan -->
  <div class="col-12 mb-4">
    <div class="row g-3">
      <div class="col-md-6 col-xl-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-muted mb-1">Menunggu Pembayaran</p>
                <h4 class="mb-0">{{ number_format($stats['pending_payment'], 0, ',', '.') }}</h4>
              </div>
              <span class="avatar avatar-online flex-shrink-0 me-0 ms-3">
                <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-clock ti-xs"></i></span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-muted mb-1">Menunggu Verifikasi</p>
                <h4 class="mb-0">{{ number_format($stats['waiting_verification'], 0, ',', '.') }}</h4>
              </div>
              <span class="avatar avatar-online flex-shrink-0 me-0 ms-3">
                <span class="avatar-initial rounded bg-label-info"><i class="ti ti-eye ti-xs"></i></span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-muted mb-1">Pesanan Terkonfirmasi</p>
                <h4 class="mb-0">{{ number_format($stats['confirmed'], 0, ',', '.') }}</h4>
              </div>
              <span class="avatar avatar-online flex-shrink-0 me-0 ms-3">
                <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-check ti-xs"></i></span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-muted mb-1">Total Pesanan</p>
                <h4 class="mb-0">{{ number_format($stats['total_bookings'], 0, ',', '.') }}</h4>
              </div>
              <span class="avatar avatar-online flex-shrink-0 me-0 ms-3">
                <span class="avatar-initial rounded bg-label-success"><i class="ti ti-list-check ti-xs"></i></span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Kartu status pesanan -->

  <!-- Ringkasan operasional -->
  <div class="col-12 mb-4">
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <p class="text-muted mb-0">Mobil Aktif</p>
              <h5 class="mb-0">{{ $stats['cars_active'] }} / {{ $stats['cars_total'] }} unit</h5>
            </div>
            <a href="{{ route('admin.cars.index') }}" class="btn btn-sm btn-label-primary">Kelola</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <p class="text-muted mb-0">Pelanggan Terdaftar</p>
              <h5 class="mb-0">{{ number_format($stats['customers'], 0, ',', '.') }} orang</h5>
            </div>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-label-primary">Lihat</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <p class="text-muted mb-0">Perlu Verifikasi Bayar</p>
              <h5 class="mb-0">{{ number_format($stats['payments_pending'], 0, ',', '.') }} transaksi</h5>
            </div>
            <a href="{{ route('admin.payments.index', ['status' => 'submitted']) }}" class="btn btn-sm btn-label-warning">Verifikasi</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Ringkasan operasional -->

  <div class="col-lg-6 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Butuh Perhatian</h5>
        <small class="text-muted">Pesanan baru & menunggu verifikasi</small>
      </div>
      <div class="table-responsive text-nowrap">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Penyewa</th>
              <th>Mobil</th>
              <th>Status</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($needAttention as $booking)
            <tr>
              <td><span class="fw-semibold">{{ $booking->booking_code }}</span></td>
              <td>{{ $booking->user->name ?? '-' }}</td>
              <td>{{ $booking->car->name ?? '-' }}</td>
              <td>@include('content.admin._partials.bookingStatus', ['status' => $booking->status])</td>
              <td class="text-end"><a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-icon btn-label-primary"><i class="ti ti-eye"></i></a></td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Tidak ada pesanan yang menunggu.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-6 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Pesanan Terbaru</h5>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-label-secondary">Lihat Semua</a>
      </div>
      <div class="table-responsive text-nowrap">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Tanggal Ambil</th>
              <th>Total</th>
              <th>Status</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($recentBookings as $booking)
            <tr>
              <td><span class="fw-semibold">{{ $booking->booking_code }}</span></td>
              <td>{{ $booking->start_time->format('d M Y H:i') }}</td>
              <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
              <td>@include('content.admin._partials.bookingStatus', ['status' => $booking->status])</td>
              <td class="text-end"><a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-icon btn-label-primary"><i class="ti ti-eye"></i></a></td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Belum ada pesanan.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
