@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Data Mobil')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <h4 class="fw-bold mb-0">Data Mobil</h4>
  <a href="{{ route('admin.cars.create') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i> Tambah Mobil</a>
</div>

@include('content.admin._partials.flash')

<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.cars.index') }}" class="row g-3 align-items-end">
      <div class="col-md-5">
        <label class="form-label">Cari</label>
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nama, merek, atau plat nomor" />
      </div>
      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua</option>
          <option value="active" @selected(request('status') == 'active')>Aktif</option>
          <option value="maintenance" @selected(request('status') == 'maintenance')>Maintenance</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Unggulan</label>
        <select name="featured" class="form-select">
          <option value="">Semua</option>
          <option value="1" @selected(request('featured') === '1')>Ya</option>
          <option value="0" @selected(request('featured') === '0')>Tidak</option>
        </select>
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill">Filter</button>
        <a href="{{ route('admin.cars.index') }}" class="btn btn-label-secondary">Reset</a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Mobil</th>
          <th>Plat</th>
          <th>Harga/Hari</th>
          <th>Status</th>
          <th class="text-center">Unggulan</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($cars as $car)
        <tr>
          <td>
            <div class="d-flex align-items-center">
              <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="rounded me-2" style="width:44px;height:32px;object-fit:cover" />
              <div>
                <span class="fw-semibold d-block">{{ $car->name }}</span>
                <small class="text-muted">{{ $car->brand }} &middot; {{ ucfirst($car->transmission) }} &middot; {{ $car->seat_capacity }} kursi</small>
              </div>
            </div>
          </td>
          <td>{{ $car->license_plate }}</td>
          <td>Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
          <td>
            <span class="badge {{ $car->status === 'active' ? 'bg-label-success' : 'bg-label-warning' }}">{{ ucfirst($car->status) }}</span>
          </td>
          <td class="text-center">
            <form action="{{ route('admin.cars.toggle-featured', $car) }}" method="POST" class="d-inline">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-sm btn-icon {{ $car->is_featured ? 'btn-label-warning' : 'btn-label-secondary' }}" title="Toggle unggulan">
                <i class="ti ti-star{{ $car->is_featured ? '-filled' : '' }}"></i>
              </button>
            </form>
          </td>
          <td class="text-end">
            <div class="d-inline-flex gap-1">
              <form action="{{ route('admin.cars.toggle-status', $car) }}" method="POST" class="d-inline">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-sm btn-icon btn-label-info" title="Ganti status aktif/maintenance">
                  <i class="ti ti-refresh"></i>
                </button>
              </form>
              <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-icon btn-label-primary" title="Edit"><i class="ti ti-pencil"></i></a>
              <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus mobil {{ $car->name }}?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-icon btn-label-danger" title="Hapus"><i class="ti ti-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center text-muted py-4">Belum ada mobil.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($cars->hasPages())
  <div class="card-footer">
    {{ $cars->links() }}
  </div>
  @endif
</div>
@endsection
