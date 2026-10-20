@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Rekening Bank')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <h4 class="fw-bold mb-0">Rekening Bank</h4>
  <a href="{{ route('admin.bank-accounts.create') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i> Tambah Rekening</a>
</div>

@include('content.admin._partials.flash')

<div class="card">
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Bank</th>
          <th>Nomor Rekening</th>
          <th>Atas Nama</th>
          <th class="text-center">Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($accounts as $account)
        <tr>
          <td><span class="fw-semibold">{{ $account->bank_name }}</span></td>
          <td>{{ $account->account_number }}</td>
          <td>{{ $account->account_holder_name }}</td>
          <td class="text-center">
            <span class="badge {{ $account->is_active ? 'bg-label-success' : 'bg-label-secondary' }}">{{ $account->is_active ? 'Aktif' : 'Nonaktif' }}</span>
          </td>
          <td class="text-end">
            <div class="d-inline-flex gap-1">
              <form action="{{ route('admin.bank-accounts.toggle-active', $account) }}" method="POST" class="d-inline">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-sm btn-icon btn-label-info" title="{{ $account->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                  <i class="ti ti-toggle-{{ $account->is_active ? 'left' : 'right' }}"></i>
                </button>
              </form>
              <a href="{{ route('admin.bank-accounts.edit', $account) }}" class="btn btn-sm btn-icon btn-label-primary" title="Edit"><i class="ti ti-pencil"></i></a>
              <form action="{{ route('admin.bank-accounts.destroy', $account) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus rekening {{ $account->bank_name }}?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-icon btn-label-danger" title="Hapus"><i class="ti ti-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center text-muted py-4">Belum ada rekening bank.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($accounts->hasPages())
  <div class="card-footer">
    {{ $accounts->links() }}
  </div>
  @endif
</div>
@endsection
