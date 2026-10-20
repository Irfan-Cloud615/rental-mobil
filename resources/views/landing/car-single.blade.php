@extends('landing.layouts.app')

@section('content')
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('landing/images/bg_3.jpg') }}');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{ route('landing.index') }}">Beranda <i class="ion-ios-arrow-forward"></i></a></span> <span>{{ $car->name }} <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">{{ $car->name }}</h1>
          </div>
        </div>
      </div>
    </section>
		

		<section class="ftco-section ftco-car-details">
      <div class="container">
      	<div class="row justify-content-center">
      		<div class="col-md-12">
      			<div class="car-details">
      				<div class="img rounded" style="background-image: url({{ $car->image_url }});"></div>
    				<div class="text text-center">
    					<span class="subheading">{{ $car->license_plate }}</span>
    					<h2>{{ $car->name }}</h2>
    					<p class="price mt-3 mb-0 text-nowrap">Rp<span>{{ number_format($car->price_per_day, 0, ',', '.') }}</span> <span>/hari</span></p>
    					<p class="mt-3 mb-0">
    						@if ($isBooked)
    							<span class="btn btn-secondary py-2 disabled" aria-disabled="true">Sedang dibooking</span>
    						@else
    							<a href="{{ route('landing.contact') }}" class="btn btn-primary py-2">Pesan Sekarang</a>
    						@endif
    						<a href="{{ route('landing.cars') }}" class="btn btn-secondary py-2 ml-1">Lihat semua mobil</a>
    					</p>
    				</div>
      			</div>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-dashboard"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Jarak Tempuh
		                	<span>&mdash;</span>{{-- kolom mileage belum ada di tabel cars --}}
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-pistons"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Transmisi
		                	<span>{{ ucfirst($car->transmission) }}</span>
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-car-seat"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Kursi
		                	<span>{{ $car->seat_capacity }} Dewasa</span>
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-backpack"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Bagasi
		                	<span>&mdash;</span>{{-- kolom luggage belum ada di tabel cars --}}
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
          <div class="col-md d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services">
              <div class="media-body py-md-4">
              	<div class="d-flex mb-3 align-items-center">
	              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-diesel"></span></div>
	              	<div class="text">
		                <h3 class="heading mb-0 pl-3">
		                	Bahan Bakar
		                	<span>&mdash;</span>{{-- kolom fuel belum ada di tabel cars --}}
		                </h3>
	                </div>
                </div>
              </div>
            </div>      
          </div>
      	</div>
      	<div class="row">
      		<div class="col-md-12 pills">
						<div class="bd-example bd-example-tabs">
							<div class="d-flex justify-content-center">
							  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

							    <li class="nav-item">
							      <a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Fitur</a>
							    </li>
							    <li class="nav-item">
							      <a class="nav-link" id="pills-manufacturer-tab" data-toggle="pill" href="#pills-manufacturer" role="tab" aria-controls="pills-manufacturer" aria-expanded="true">Deskripsi</a>
							    </li>
							    <li class="nav-item">
							      <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review" role="tab" aria-controls="pills-review" aria-expanded="true">Ulasan</a>
							    </li>
							  </ul>
							</div>

						  <div class="tab-content" id="pills-tabContent">
						    <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
						    	<div class="row">
						    		<div class="col-md-4">
						    			<ul class="features">
						    				<li class="check"><span class="ion-ios-checkmark"></span>AC</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>Kursi Anak</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>GPS</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>Bagasi</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>Musik</li>
						    			</ul>
						    		</div>
						    		<div class="col-md-4">
						    			<ul class="features">
						    				<li class="check"><span class="ion-ios-checkmark"></span>Sabuk Pengaman</li>
						    				<li class="remove"><span class="ion-ios-close"></span>Tempat Tidur</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>Air Minum</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>Bluetooth</li>
						    				<li class="remove"><span class="ion-ios-close"></span>Komputer Onboard</li>
						    			</ul>
						    		</div>
						    		<div class="col-md-4">
						    			<ul class="features">
						    				<li class="check"><span class="ion-ios-checkmark"></span>Audio Input</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>Perjalanan Jauh</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>Perangkat Mobil</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>Kunci Pusat Remote</li>
						    				<li class="check"><span class="ion-ios-checkmark"></span>Pengatur Suhu</li>
						    			</ul>
						    		</div>
						    	</div>
						    </div>

						    <div class="tab-pane fade" id="pills-manufacturer" role="tabpanel" aria-labelledby="pills-manufacturer-tab">
						      <p>Mobil ini dirawat secara berkala untuk memastikan performa dan kenyamanan terbaik di setiap perjalanan. Kondisi mesin sehat, interior bersih, dan bodi terawat.</p>
									<p>Cocok untuk perjalanan keluarga maupun bisnis. Dengan kabin yang luas dan konsumsi bahan bakar yang efisien, mobil ini menjadi pilihan tepat untuk berbagai kebutuhan sewa Anda.</p>
						    </div>

						    <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
						      <div class="row">
							   		<div class="col-md-7">
							   			<h3 class="head">23 Ulasan</h3>
							   			<div class="review d-flex">
									   		<div class="user-img" style="background-image: url({{ asset('landing/images/person_1.jpg') }})"></div>
									   		<div class="desc">
									   			<h4>
									   				<span class="text-left">Budi Santoso</span>
									   				<span class="text-right">14 Maret 2024</span>
									   			</h4>
									   			<p class="star">
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
								   					</span>
								   					<span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
									   			</p>
									   			<p>Mobilnya nyaman dan bersih, proses pemesanan mudah. Sangat membantu perjalanan kami sekeluarga.</p>
									   		</div>
									   	</div>
									   	<div class="review d-flex">
									   		<div class="user-img" style="background-image: url({{ asset('landing/images/person_2.jpg') }})"></div>
									   		<div class="desc">
									   			<h4>
									   				<span class="text-left">Budi Santoso</span>
									   				<span class="text-right">14 Maret 2024</span>
									   			</h4>
									   			<p class="star">
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
								   					</span>
								   					<span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
									   			</p>
									   			<p>Mobilnya nyaman dan bersih, proses pemesanan mudah. Sangat membantu perjalanan kami sekeluarga.</p>
									   		</div>
									   	</div>
									   	<div class="review d-flex">
									   		<div class="user-img" style="background-image: url({{ asset('landing/images/person_3.jpg') }})"></div>
									   		<div class="desc">
									   			<h4>
									   				<span class="text-left">Budi Santoso</span>
									   				<span class="text-right">14 Maret 2024</span>
									   			</h4>
									   			<p class="star">
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
								   					</span>
								   					<span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
									   			</p>
									   			<p>Mobilnya nyaman dan bersih, proses pemesanan mudah. Sangat membantu perjalanan kami sekeluarga.</p>
									   		</div>
									   	</div>
							   		</div>
							   		<div class="col-md-5">
							   			<div class="rating-wrap">
								   			<h3 class="head">Tulis Ulasan</h3>
								   			<div class="wrap">
									   			<p class="star">
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					(98%)
								   					</span>
								   					<span>20 Ulasan</span>
									   			</p>
									   			<p class="star">
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					(85%)
								   					</span>
								   					<span>10 Ulasan</span>
									   			</p>
									   			<p class="star">
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					(70%)
								   					</span>
								   					<span>5 Ulasan</span>
									   			</p>
									   			<p class="star">
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					(10%)
								   					</span>
								   					<span>0 Ulasan</span>
									   			</p>
									   			<p class="star">
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					(0%)
								   					</span>
								   					<span>0 Ulasan</span>
									   			</p>
									   		</div>
								   		</div>
							   		</div>
							   	</div>
						    </div>
						  </div>
						</div>
		      </div>
				</div>
      </div>
    </section>

    <section class="ftco-section ftco-no-pt">
    	<div class="container">
    		<div class="row justify-content-center">
          <div class="col-md-12 heading-section text-center ftco-animate mb-5">
          	<span class="subheading">Pilih Mobil</span>
            <h2 class="mb-2">Mobil Lainnya</h2>
          </div>
        </div>
        <div class="row">
        	@forelse ($relatedCars as $car)
        		<div class="col-md-4">
        			@include('landing.partials.car-card', ['car' => $car])
        		</div>
        	@empty
        		<div class="col-md-12 text-center">
        			<p class="mb-0">Belum ada mobil lain yang tersedia.</p>
        		</div>
        	@endforelse
        </div>
    	</div>
    </section>
@endsection
