@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Data Pemesanan')

@section('content')
<h4 class="fw-bold py-3 mb-4">Data Pemesanan</h4>

@include('content.admin._partials.flash')

<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3 align-items-end">
      <div class="col-md-5">
        <label class="form-label">Cari</label>
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Kode pesanan atau nama penyewa" />
      </div>
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua Status</option>
          @foreach (['pending_payment', 'waiting_verification', 'confirmed', 'completed', 'cancelled'] as $st)
          <option value="{{ $st }}" @selected(request('status') == $st)>{{ $st }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill">Filter</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-label-secondary">Reset</a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Penyewa</th>
          <th>Mobil</th>
          <th>Jadwal Ambil &rarr; Kembali</th>
          <th>Total</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($bookings as $booking)
        <tr>
          <td><span class="fw-semibold">{{ $booking->booking_code }}</span></td>
          <td>{{ $booking->user->name ?? '-' }}</td>
          <td>{{ $booking->car->name ?? '-' }}</td>
          <td>
            <small>{{ $booking->start_time->format('d M Y H:i') }}</small>
            <i class="ti ti-arrow-right ti-xs mx-1"></i>
            <small>{{ $booking->end_time->format('d M Y H:i') }}</small>
          </td>
          <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
          <td>@include('content.admin._partials.bookingStatus', ['status' => $booking->status])</td>
          <td class="text-end">
            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-icon btn-label-primary" title="Detail"><i class="ti ti-eye"></i></a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center text-muted py-4">Belum ada pesanan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($bookings->hasPages())
  <div class="card-footer">
    {{ $bookings->links() }}
  </div>
  @endif
</div>
@endsection
