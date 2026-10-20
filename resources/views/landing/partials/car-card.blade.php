{{-- Kartu mobil. Dipakai oleh carousel beranda, daftar mobil, dan mobil terkait. --}}
<div class="car-wrap rounded ftco-animate">
  <div class="img rounded d-flex align-items-end" style="background-image: url({{ $car->image_url }});"></div>
  <div class="text">
    <h2 class="mb-0"><a href="{{ route('landing.cars.show', $car) }}">{{ $car->name }}</a></h2>
    <div class="d-flex mb-3">
      <span class="cat">{{ $car->seat_capacity }} kursi &middot; {{ ucfirst($car->transmission) }}</span>
      <p class="price ml-auto text-nowrap">Rp{{ number_format($car->price_per_day, 0, ',', '.') }} <span>/hari</span></p>
    </div>
    <p class="d-flex mb-0 d-block">
      @if ($car->is_booked)
        <span class="btn btn-secondary py-2 mr-1 disabled" aria-disabled="true">Sedang dibooking</span>
      @else
        <a href="#" class="btn btn-primary py-2 mr-1">Pesan Sekarang</a>
      @endif
      <a href="{{ route('landing.cars.show', $car) }}" class="btn btn-secondary py-2 ml-1">Detail</a>
    </p>
  </div>
</div>
