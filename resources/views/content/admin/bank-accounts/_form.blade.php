<div class="card">
  <div class="card-header">
    <h5 class="mb-0">{{ $account->exists ? 'Edit Rekening' : 'Tambah Rekening' }}</h5>
  </div>
  <div class="card-body">
    <form action="{{ $action }}" method="POST" novalidate>
      @csrf
      @if ($method !== 'POST')
      @method($method)
      @endif

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="bank_name">Nama Bank <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name', $account->bank_name) }}" maxlength="50" required />
          @error('bank_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label" for="account_number">Nomor Rekening <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number', $account->account_number) }}" maxlength="50" required />
          @error('account_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label" for="account_holder_name">Atas Nama <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('account_holder_name') is-invalid @enderror" id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name', $account->account_holder_name) }}" maxlength="100" required />
          @error('account_holder_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 d-flex align-items-end">
          <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $account->is_active ?? true))>
            <label class="form-check-label" for="is_active">Aktif &mdash; tampilkan di halaman pembayaran pelanggan</label>
          </div>
        </div>
      </div>

      <hr class="my-4" />
      <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-label-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">{{ $account->exists ? 'Simpan Perubahan' : 'Tambah Rekening' }}</button>
      </div>
    </form>
  </div>
</div>
