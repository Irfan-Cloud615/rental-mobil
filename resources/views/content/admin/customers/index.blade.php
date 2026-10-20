@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Data Pelanggan')

@section('content')
<h4 class="fw-bold py-3 mb-4">Data Pelanggan</h4>

@include('content.admin._partials.flash')

<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-2">
      <div class="col-md-9">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama, email, atau nomor telepon" />
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill">Cari</button>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-label-secondary">Reset</a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Telepon</th>
          <th>Alamat</th>
          <th class="text-center">Pesanan</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($customers as $customer)
        <tr>
          <td><span class="fw-semibold">{{ $customer->name }}</span></td>
          <td>{{ $customer->email }}</td>
          <td>{{ $customer->identity?->phone ?? '-' }}</td>
          <td>{{ $customer->identity?->address ?? '-' }}</td>
          <td class="text-center">
            <span class="badge bg-label-primary">{{ $customer->bookings_count }}</span>
          </td>
          <td class="text-end">
            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-icon btn-label-primary" title="Detail"><i class="ti ti-eye"></i></a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center text-muted py-4">Belum ada pelanggan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($customers->hasPages())
  <div class="card-footer">
    {{ $customers->links() }}
  </div>
  @endif
</div>
@endsection
