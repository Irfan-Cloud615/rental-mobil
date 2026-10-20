@php
$configData = Helper::appClasses();
$tabs = [
'submitted' => 'Perlu Verifikasi',
'pending' => 'Menunggu',
'completed' => 'Lunas',
'rejected' => 'Ditolak',
'expired' => 'Kedaluwarsa',
'all' => 'Semua',
];
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<h4 class="fw-bold py-3 mb-4">Verifikasi Pembayaran</h4>

@include('content.admin._partials.flash')

<div class="card">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" role="tablist">
      @foreach ($tabs as $key => $label)
      <li class="nav-item">
        <a class="nav-link {{ $status === $key ? 'active' : '' }}" href="{{ route('admin.payments.index', ['status' => $key]) }}">
          {{ $label }}
          @if ($key !== 'all')
          <span class="badge bg-label-secondary ms-1">{{ $counts[$key] ?? 0 }}</span>
          @endif
        </a>
      </li>
      @endforeach
    </ul>
  </div>

  <div class="card-body pb-0 mt-3">
    <form method="GET" action="{{ route('admin.payments.index') }}" class="row g-2">
      <input type="hidden" name="status" value="{{ $status }}" />
      <div class="col-md-9">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nomor pembayaran atau kode pesanan" />
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill">Cari</button>
        <a href="{{ route('admin.payments.index', ['status' => $status]) }}" class="btn btn-label-secondary">Reset</a>
      </div>
    </form>
  </div>

  <div class="table-responsive text-nowrap mt-3">
    <table class="table">
      <thead>
        <tr>
          <th>Nomor</th>
          <th>Pesanan</th>
          <th>Penyewa</th>
          <th>Metode</th>
          <th>Nominal</th>
          <th>Bukti</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($payments as $payment)
        <tr>
          <td><span class="fw-semibold">{{ $payment->number }}</span></td>
          <td>{{ $payment->booking?->booking_code ?? '-' }}</td>
          <td>{{ $payment->booking?->user?->name ?? '-' }}</td>
          <td>{{ ucfirst($payment->method) }}</td>
          <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
          <td>
            @if ($payment->proof_image_path)
            <a href="{{ preg_match('#^https?://#', $payment->proof_image_path) ? $payment->proof_image_path : asset('storage/' . $payment->proof_image_path) }}" target="_blank" class="btn btn-sm btn-label-info">Lihat</a>
            @else
            <small class="text-muted">Tidak ada</small>
            @endif
          </td>
          <td>@include('content.admin._partials.paymentStatus', ['status' => $payment->status])</td>
          <td class="text-end">
            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-icon btn-label-primary" title="Tinjau"><i class="ti ti-eye"></i></a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center text-muted py-4">Tidak ada pembayaran pada kategori ini.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($payments->hasPages())
  <div class="card-footer">
    {{ $payments->links() }}
  </div>
  @endif
</div>
@endsection
