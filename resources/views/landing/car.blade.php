@extends('landing.layouts.app')

@section('content')
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('landing/images/bg_3.jpg') }}');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{ route('landing.index') }}">Beranda <i class="ion-ios-arrow-forward"></i></a></span> <span>Pilih Mobil <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Pilih Mobil</h1>
          </div>
        </div>
      </div>
    </section>
		

		<section class="ftco-section bg-light">
    	<div class="container">
    		<form method="get" action="{{ route('landing.cars') }}" class="mb-4">
    			<div class="row no-gutters align-items-end">
    				<div class="col-md-3 pr-md-2">
    					<label class="mb-1" for="transmission">Transmisi</label>
    					<select name="transmission" id="transmission" class="form-control">
    						<option value="">Semua</option>
    						<option value="manual" {{ request('transmission') === 'manual' ? 'selected' : '' }}>Manual</option>
    						<option value="automatic" {{ request('transmission') === 'automatic' ? 'selected' : '' }}>Automatic</option>
    					</select>
    				</div>
    				<div class="col-md-3 pr-md-2">
    					<label class="mb-1" for="seat_capacity">Kapasitas kursi</label>
    					<select name="seat_capacity" id="seat_capacity" class="form-control">
    						<option value="">Semua</option>
    						@foreach ($seatOptions as $seat)
    							<option value="{{ $seat }}" {{ (int) request('seat_capacity') === (int) $seat ? 'selected' : '' }}>{{ $seat }} kursi</option>
    						@endforeach
    					</select>
    				</div>
    				<div class="col-md-3 pr-md-2">
    					<label class="mb-1 d-md-block d-none">&nbsp;</label>
    					<button type="submit" class="btn btn-primary btn-block">Terapkan</button>
    				</div>
    				<div class="col-md-3 d-flex align-items-center">
    					<a href="{{ route('landing.cars') }}" class="btn btn-link">Atur Ulang Filter</a>
    				</div>
    			</div>
    		</form>
    		<div class="row">
    			@forelse ($cars as $car)
    				<div class="col-md-4">
    					@include('landing.partials.car-card', ['car' => $car])
    				</div>
    			@empty
    				<div class="col-md-12 text-center">
    					<p class="lead">Belum ada mobil yang sesuai filter. Coba pilihan lain.</p>
    				</div>
    			@endforelse
    		</div>
    		@if ($cars->hasPages())
    			<div class="row mt-5">
    				<div class="col text-center">
    					<div class="block-27">
    						<ul>
    							@if ($cars->onFirstPage())
    								<li><span>&lsaquo;</span></li>
    							@else
    								<li><a href="{{ $cars->previousPageUrl() }}">&lsaquo;</a></li>
    							@endif

    							@foreach (range(max(1, $cars->currentPage() - 2), min($cars->lastPage(), $cars->currentPage() + 2)) as $page)
    								@if ($page === $cars->currentPage())
    									<li class="active"><span>{{ $page }}</span></li>
    								@else
    									<li><a href="{{ $cars->url($page) }}">{{ $page }}</a></li>
    								@endif
    							@endforeach

    							@if ($cars->hasMorePages())
    								<li><a href="{{ $cars->nextPageUrl() }}">&rsaquo;</a></li>
    							@else
    								<li><span>&rsaquo;</span></li>
    							@endif
    						</ul>
    					</div>
    				</div>
    			</div>
    		@endif
    	</div>
    </section>
@endsection
