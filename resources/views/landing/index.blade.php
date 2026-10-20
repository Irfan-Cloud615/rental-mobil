@extends('landing.layouts.app')

@section('content')
    
    <div class="hero-wrap ftco-degree-bg" style="background-image: url('{{ asset('landing/car-img/car1.jpeg') }}');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
          <div class="col-lg-8 ftco-animate">
          	<div class="text w-100 text-center mb-md-5 pb-md-5">
	            <h1 class="mb-4">Cara Cepat &amp; Mudah Menyewa Mobil</h1>
	            <p style="font-size: 18px;">Wujudkan perjalanan yang nyaman bersama armada mobil kami yang terawat. Sewa harian maupun bulanan dengan harga terjangkau dan layanan yang bisa diandalkan.</p>
	            <a href="https://vimeo.com/45830194" class="icon-wrap popup-vimeo d-flex align-items-center mt-4 justify-content-center">
	            	<div class="icon d-flex align-items-center justify-content-center">
	            		<span class="ion-ios-play"></span>
	            	</div>
	            	<div class="heading-title ml-5">
		            	<span>Langkah mudah menyewa mobil</span>
	            	</div>
	            </a>
            </div>
          </div>
        </div>
      </div>
    </div>

     <section class="ftco-section ftco-no-pt bg-light">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-md-12	featured-top">
    				<div class="row no-gutters">
	  					<div class="col-md-4 d-flex align-items-center">
	  						{{-- Form "Rencanakan Perjalananmu" belum punya backend (lokasi/tanggal); filter mobil tersedia di halaman Cars. --}}
						  <form action="#" class="request-form ftco-animate bg-primary">
		          		<h2>Rencanakan Perjalananmu</h2>
			    				<div class="form-group">
			    					<label for="" class="label">Lokasi Penjemputan</label>
			    					<input type="text" class="form-control" placeholder="Kota, Bandara, Stasiun, dll">
			    				</div>
			    				<div class="form-group">
			    					<label for="" class="label">Lokasi Pengembalian</label>
			    					<input type="text" class="form-control" placeholder="Kota, Bandara, Stasiun, dll">
			    				</div>
			    				<div class="d-flex">
			    					<div class="form-group mr-2">
			                <label for="" class="label">Tanggal Penjemputan</label>
			                <input type="text" class="form-control" id="book_pick_date" placeholder="Tanggal">
			              </div>
			              <div class="form-group ml-2">
			                <label for="" class="label">Tanggal Pengembalian</label>
			                <input type="text" class="form-control" id="book_off_date" placeholder="Tanggal">
			              </div>
		              </div>
		              <div class="form-group">
		                <label for="" class="label">Waktu Penjemputan</label>
		                <input type="text" class="form-control" id="time_pick" placeholder="Waktu">
		              </div>
			            <div class="form-group">
			              <input type="submit" value="Sewa Mobil Sekarang" class="btn btn-secondary py-3 px-4">
			            </div>
			    			</form>
	  					</div>
	  					<div class="col-md-8 d-flex align-items-center">
	  						<div class="services-wrap rounded-right w-100">
	  							<h3 class="heading-section mb-4">Cara Lebih Mudah Menyewa Mobil Idaman Anda</h3>
	  							<div class="row d-flex mb-4">
					          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-route"></span></div>
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Pilih Lokasi Penjemputan</h3>
				                </div>
					            </div>      
					          </div>
					          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-handshake"></span></div>
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Pilih Penawaran Terbaik</h3>
					              </div>
					            </div>      
					          </div>
					          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-rent"></span></div>
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Pesan Mobil Sewaan Anda</h3>
					              </div>
					            </div>      
					          </div>
					        </div>
					        <p><a href="{{ route('login') }}" class="btn btn-primary py-3 px-4">Pesan Mobil Idaman Anda</a></p>
	  						</div>
	  					</div>
	  				</div>
				</div>
  		</div>
    </section>


    <section class="ftco-section ftco-no-pt bg-light">
    	<div class="container">
    		<div class="row justify-content-center">
          <div class="col-md-12 heading-section text-center ftco-animate mb-5">
          	<span class="subheading">Apa yang Kami Tawarkan</span>
            <h2 class="mb-2">Mobil Unggulan</h2>
          </div>
        </div>
    		<div class="row">
    			<div class="col-md-12">
    				<div class="carousel-car owl-carousel">
    				@forelse ($featuredCars as $car)
    					<div class="item">
    						@include('landing.partials.car-card', ['car' => $car])
    					</div>
    				@empty
    					<div class="item">
    						<p class="text-center w-100 mb-0">Belum ada mobil unggulan.</p>
    					</div>
    				@endforelse
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-section ftco-about">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{ asset('landing/car-img/car2.jpeg') }});">
					</div>
					<div class="col-md-6 wrap-about ftco-animate">
	          <div class="heading-section heading-section-white pl-md-5">
	          	<span class="subheading">Tentang Kami</span>
	            <h2 class="mb-4">Selamat Datang di WrentRU</h2>

	            <p>WrentRU adalah layanan rental mobil yang siap menemani perjalanan Anda, baik untuk keperluan keluarga, bisnis, maupun liburan. Kami menghadirkan armada yang terawat dan bersih agar setiap perjalanan terasa nyaman.</p>
	            <p>Dengan proses pemesanan yang mudah dan harga yang bersahabat, kami berkomitmen memberikan pelayanan terbaik. Tim kami selalu siap membantu Anda menemukan mobil yang paling sesuai dengan kebutuhan perjalanan.</p>
	            <p><a href="{{ route('landing.cars') }}" class="btn btn-primary py-3 px-4">Cari Mobil</a></p>
	          </div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
          	<span class="subheading">Layanan</span>
            <h2 class="mb-3">Layanan Kami</h2>
          </div>
        </div>
				<div class="row">
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-wedding-car"></span></div>
            	<div class="text w-100">
                <h3 class="heading mb-2">Mobil Acara Pernikahan</h3>
                <p>Sediakan mobil mewah dan rapi untuk mengiringi hari bahagia Anda bersama keluarga.</p>
              </div>
            </div>
					</div>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-transportation"></span></div>
            	<div class="text w-100">
                <h3 class="heading mb-2">Antar-Jemput Dalam Kota</h3>
                <p>Perjalanan bisnis maupun aktivitas harian di dalam kota menjadi lebih praktis dan efisien.</p>
              </div>
            </div>
					</div>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-car"></span></div>
            	<div class="text w-100">
                <h3 class="heading mb-2">Antar-Jemput Bandara</h3>
                <p>Penjemputan dan pengantaran tepat waktu ke bandara agar perjalanan Anda lebih tenang.</p>
              </div>
            </div>
					</div>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-transportation"></span></div>
            	<div class="text w-100">
                <h3 class="heading mb-2">Paket Wisata Keliling Kota</h3>
                <p>Jelajahi destinasi favorit bersama rombongan dengan mobil yang nyaman dan lapang.</p>
              </div>
            </div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section ftco-intro" style="background-image: url({{ asset('landing/car-img/car3.jpeg') }});">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-end">
					<div class="col-md-6 heading-section heading-section-white ftco-animate">
            <h2 class="mb-3">Butuh Mobil untuk Perjalanan Anda? Kami Siap Membantu.</h2>
            <a href="{{ route('landing.cars') }}" class="btn btn-primary btn-lg">Sewa Mobil Sekarang</a>
          </div>
				</div>
			</div>
		</section>


    <section class="ftco-section testimony-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
          	<span class="subheading">Testimoni</span>
            <h2 class="mb-3">Pelanggan Puas</h2>
          </div>
        </div>
        <div class="row ftco-animate">
          <div class="col-md-12">
            <div class="carousel-testimony owl-carousel ftco-owl">
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('landing/images/person_1.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Proses sewa gampang, mobil bersih dan terawat. Perjalanan keluarga jadi jauh lebih nyaman!</p>
                    <p class="name">Andi Pratama</p>
                    <span class="position">Pengusaha</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('landing/images/person_2.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Harga terjangkau dan antar-jemput tepat waktu. Pelayanannya ramah, sangat kami rekomendasikan.</p>
                    <p class="name">Siti Rahayu</p>
                    <span class="position">Karyawan Swasta</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('landing/images/person_3.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Sudah beberapa kali sewa di sini, kondisinya selalu prima dan respon admin cepat.</p>
                    <p class="name">Budi Santoso</p>
                    <span class="position">Guru</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('landing/images/person_1.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Mobilnya nyaman untuk acara keluarga. BBM penuh dan mobil dibersihkan saat diserahkan.</p>
                    <p class="name">Dewi Lestari</p>
                    <span class="position">Ibu Rumah Tangga</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('landing/images/person_1.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Antar-jemput bandara sangat membantu. Sopirnya ramah dan berpengalaman di rute kota.</p>
                    <p class="name">Rudi Hartono</p>
                    <span class="position">Wisatawan</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    {{-- Counter dinamis: Total Mobil & Pelanggan Puas diambil dari tabel cars & bookings. --}}
    <section class="ftco-counter ftco-section img bg-light" id="section-counter">
			<div class="overlay"></div>
    	<div class="container">
    		<div class="row">
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text text-border d-flex align-items-center">
                <strong class="number" data-number="{{ $stats['cars'] }}">0</strong>{{-- jumlah mobil dari tabel cars --}}
                <span>Total <br>Mobil</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text text-border d-flex align-items-center">
                <strong class="number" data-number="{{ $stats['customers'] }}">0</strong>{{-- pelanggan unik dari tabel bookings --}}
                <span>Pelanggan <br>Puas</span>
              </div>
            </div>
          </div>
        </div>
    	</div>
    </section>
@endsection
