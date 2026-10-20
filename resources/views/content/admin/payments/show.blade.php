@php
$configData = Helper::appClasses();
$proofUrl = $payment->proof_image_path
    ? (preg_match('#^https?://#', $payment->proof_image_path) ? $payment->proof_image_path : asset('storage/' . $payment->proof_image_path))
    : null;
$bookingTotal = $payment->booking?->total_price;
$amountMatch = $bookingTotal !== null && (float) $payment->amount === (float) $bookingTotal;
$canReview = in_array($payment->status, ['pending', 'submitted'], true);
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tinjau Pembayaran ' . $payment->number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <h4 class="fw-bold mb-0">Tinjau Pembayaran <span class="text-muted">{{ $payment->number }}</span></h4>
  <a href="{{ route('admin.payments.index') }}" class="btn btn-label-secondary"><i class="ti ti-arrow-left me-1"></i> Kembali</a>
</div>

@include('content.admin._partials.flash')

<div class="row">
  <!-- Bukti transfer & rincian -->
  <div class="col-lg-7 mb-4">
    <div class="card h-100">
      <h5 class="card-header">Bukti Transfer</h5>
      <div class="card-body">
        @if ($proofUrl)
        <a href="{{ $proofUrl }}" target="_blank">
          <img src="{{ $proofUrl }}" alt="Bukti transfer" class="img-fluid rounded border" />
        </a>
        <div class="mt-2"><small class="text-muted">Klik gambar untuk memperbesar.</small></div>
        @else
        <div class="alert alert-warning mb-0">Tidak ada bukti transfer diunggah (metode <b>{{ ucfirst($payment->method) }}</b>).</div>
        @endif
      </div>
    </div>
  </div>

  <!-- Ringkasan & pencocokan nominal -->
  <div class="col-lg-5 mb-4">
    <div class="card h-100">
      <h5 class="card-header">Ringkasan</h5>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-12">
            <span class="text-muted d-block">Status</span>
            @include('content.admin._partials.paymentStatus', ['status' => $payment->status])
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Metode</span>
            <span class="fw-semibold">{{ ucfirst($payment->method) }}</span>
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Rekening Tujuan</span>
            <span class="fw-semibold">{{ $payment->rentalBankAccount?->bank_name ?? '-' }}</span>
            <div><small class="text-muted">{{ $payment->rentalBankAccount?->account_number ?? '' }}</small></div>
          </div>
          <div class="col-12">
            <span class="text-muted d-block">Pesanan</span>
            <span class="fw-semibold">{{ $payment->booking?->booking_code ?? '-' }}</span>
            <div><small class="text-muted">{{ $payment->booking?->user?->name ?? '' }}</small></div>
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Nominal Bayar</span>
            <span class="fw-semibold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
          </div>
          <div class="col-md-6">
            <span class="text-muted d-block">Tagihan Pesanan</span>
            <span class="fw-semibold">Rp {{ $bookingTotal !== null ? number_format($bookingTotal, 0, ',', '.') : '-' }}</span>
          </div>
          <div class="col-12">
            <div class="alert {{ $amountMatch ? 'alert-success' : 'alert-warning' }} mb-0 py-2">
              <small>{{ $amountMatch ? 'Nominal sesuai dengan tagihan pesanan.' : 'Nominal TIDAK sama dengan tagihan pesanan, periksa kembali.' }}</small>
            </div>
          </div>
          @if ($payment->customer_notes)
          <div class="col-12">
            <span class="text-muted d-block">Catatan Pelanggan</span>
            <span>{{ $payment->customer_notes }}</span>
          </div>
          @endif
          @if ($payment->verified_at)
          <div class="col-12">
            <small class="text-muted">Diproses oleh {{ $payment->verifiedBy->name ?? 'sistem' }} pada {{ $payment->verified_at->format('d M Y H:i') }}</small>
          </div>
          @endif
          @if ($payment->rejection_reason)
          <div class="col-12">
            <span class="text-muted d-block">Alasan Penolakan</span>
            <span class="text-danger">{{ $payment->rejection_reason }}</span>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Aksi verifikasi -->
  @if ($canReview)
  <div class="col-12">
    <div class="card">
      <h5 class="card-header">Keputusan</h5>
      <div class="card-body">
        <div class="row g-4">
          <div class="col-md-6">
            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" onsubmit="return confirm('Validasi pembayaran ini dan konfirmasi pesanan terkait?');">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-success w-100"><i class="ti ti-check me-1"></i> Validasi Pembayaran</button>
            </form>
          </div>
          <div class="col-md-6">
            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">
              @csrf @method('PATCH')
              <div class="mb-2">
                <label class="form-label" for="rejection_reason">Alasan Penolakan</label>
                <textarea class="form-control @error('rejection_reason') is-invalid @enderror" id="rejection_reason" name="rejection_reason" rows="2" placeholder="Contoh: nominal tidak sesuai / bukti tidak jelas"></textarea>
                @error('rejection_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <button type="submit" class="btn btn-danger w-100"><i class="ti ti-x me-1"></i> Tolak Pembayaran</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection
