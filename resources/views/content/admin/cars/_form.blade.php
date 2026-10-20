@php
$featuresText = is_array($car->features) ? implode(', ', array_keys($car->features)) : (string) old('features', $car->features ?? '');
@endphp

<div class="card">
  <div class="card-header">
    <h5 class="mb-0">{{ $car->exists ? 'Edit Mobil' : 'Tambah Mobil' }}</h5>
  </div>
  <div class="card-body">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" novalidate>
      @csrf
      @if ($method !== 'POST')
      @method($method)
      @endif

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="name">Nama Mobil <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $car->name) }}" maxlength="100" required />
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label" for="brand">Merek</label>
          <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand', $car->brand) }}" maxlength="60" placeholder="Toyota, Daihatsu, ..." />
          @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
          <label class="form-label" for="license_plate">Plat Nomor <span class="text-danger">*</span></label>
          <input type="text" class="form-control text-uppercase @error('license_plate') is-invalid @enderror" id="license_plate" name="license_plate" value="{{ old('license_plate', $car->license_plate) }}" maxlength="20" required />
          @error('license_plate')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label" for="price_per_day">Harga Sewa / Hari (Rp) <span class="text-danger">*</span></label>
          <input type="number" step="1" min="0" class="form-control @error('price_per_day') is-invalid @enderror" id="price_per_day" name="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}" required />
          @error('price_per_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="transmission">Transmisi <span class="text-danger">*</span></label>
          <select class="form-select @error('transmission') is-invalid @enderror" id="transmission" name="transmission" required>
            <option value="manual" @selected(old('transmission', $car->transmission) == 'manual')>Manual</option>
            <option value="automatic" @selected(old('transmission', $car->transmission) == 'automatic')>Automatic</option>
          </select>
          @error('transmission')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
          <label class="form-label" for="fuel_type">Bahan Bakar <span class="text-danger">*</span></label>
          <select class="form-select @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type" required>
            @foreach (['pertalite' => 'Pertalite', 'pertamax' => 'Pertamax', 'pertamax_turbo' => 'Pertamax Turbo', 'diesel' => 'Diesel', 'hybrid' => 'Hybrid'] as $val => $lbl)
            <option value="{{ $val }}" @selected(old('fuel_type', $car->fuel_type) == $val)>{{ $lbl }}</option>
            @endforeach
          </select>
          @error('fuel_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
          <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
          <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="active" @selected(old('status', $car->status ?: 'active') == 'active')>Aktif</option>
            <option value="maintenance" @selected(old('status', $car->status) == 'maintenance')>Maintenance</option>
          </select>
          @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4">
          <label class="form-label" for="seat_capacity">Kapasitas Kursi</label>
          <input type="number" min="2" max="60" class="form-control @error('seat_capacity') is-invalid @enderror" id="seat_capacity" name="seat_capacity" value="{{ old('seat_capacity', $car->seat_capacity ?? 5) }}" />
          @error('seat_capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
          <label class="form-label" for="luggage_capacity">Kapasitas Bagasi</label>
          <input type="number" min="0" max="20" class="form-control @error('luggage_capacity') is-invalid @enderror" id="luggage_capacity" name="luggage_capacity" value="{{ old('luggage_capacity', $car->luggage_capacity ?? 2) }}" />
          @error('luggage_capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
          <label class="form-label" for="mileage_km">Odometer (km)</label>
          <input type="number" min="0" class="form-control @error('mileage_km') is-invalid @enderror" id="mileage_km" name="mileage_km" value="{{ old('mileage_km', $car->mileage_km) }}" />
          @error('mileage_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
          <label class="form-label" for="features">Fitur (pisahkan dengan koma)</label>
          <input type="text" class="form-control @error('features') is-invalid @enderror" id="features" name="features" value="{{ $featuresText }}" placeholder="Air Conditioner, GPS, Bluetooth" />
          @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
          <label class="form-label" for="description">Deskripsi</label>
          <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $car->description) }}</textarea>
          @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
          <label class="form-label" for="image">Upload Gambar</label>
          <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" id="image" name="image" />
          @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
          @if ($car->image_path)
          <div class="mt-2"><img src="{{ $car->image_url }}" alt="preview" class="rounded" style="max-height:120px" /></div>
          @endif
        </div>
        <div class="col-md-6">
          <label class="form-label" for="image_url">atau URL Gambar</label>
          <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" value="{{ old('image_url', filter_var($car->image_path, FILTER_VALIDATE_URL) ?: null) }}" placeholder="https://..." />
          <div class="form-text">Isi salah satu: upload berkas atau URL. Kosongkan untuk mempertahankan gambar saat ini.</div>
          @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $car->is_featured))>
            <label class="form-check-label" for="is_featured">Tampilkan sebagai mobil unggulan di halaman utama</label>
          </div>
        </div>
      </div>

      <hr class="my-4" />
      <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.cars.index') }}" class="btn btn-label-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">{{ $car->exists ? 'Simpan Perubahan' : 'Tambah Mobil' }}</button>
      </div>
    </form>
  </div>
</div>
