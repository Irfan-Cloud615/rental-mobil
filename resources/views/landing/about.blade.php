@extends('landing.layouts.app')

@section('content')
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('landing/images/bg_3.jpg') }}');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{ route('landing.index') }}">Beranda <i class="ion-ios-arrow-forward"></i></a></span> <span>Tentang Kami <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Tentang Kami</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-about">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{ asset('landing/images/about.jpg') }});">
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

		<section class="ftco-section ftco-intro" style="background-image: url({{ asset('landing/images/bg_3.jpg') }});">
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
      <section class="ftco-counter ftco-section img" id="section-counter">
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
