@php
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Registrasi - Rental Mobil')

@section('vendor-style')
<!-- Vendor -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/auth-register-steps.js')}}"></script>
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover authentication-bg">
  <div class="authentication-inner row">

    <!-- Left Text -->
    <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-center p-5 auth-cover-bg-color position-relative auth-multisteps-bg-height">
      <img src="{{ asset('assets/img/illustrations/auth-register-multisteps-illustration.png') }}" alt="auth-register-multisteps" class="img-fluid" width="280">

      <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}" alt="auth-register-multisteps" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
    </div>
    <!-- /Left Text -->

    <!--  Multi Steps Registration -->
    <div class="d-flex col-lg-8 align-items-center justify-content-center p-sm-5 p-3">
      <div class="w-px-700">
        <div id="multiStepsValidation" class="bs-stepper shadow-none">
          <div class="bs-stepper-header border-bottom-0">
            <div class="step" data-target="#accountDetailsValidation">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ti ti-smart-home ti-sm"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Akun</span>
                  <span class="bs-stepper-subtitle">Detail Akun</span>
                </span>
              </button>
            </div>
            <div class="line">
              <i class="ti ti-chevron-right"></i>
            </div>
            <div class="step" data-target="#personalInfoValidation">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ti ti-users ti-sm"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Data Diri</span>
                  <span class="bs-stepper-subtitle">Isi Informasi</span>
                </span>
              </button>
            </div>
            <div class="line">
              <i class="ti ti-chevron-right"></i>
            </div>
            <div class="step" data-target="#confirmValidation">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ti ti-file-text ti-sm"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Konfirmasi</span>
                  <span class="bs-stepper-subtitle">Periksa & Daftar</span>
                </span>
              </button>
            </div>
          </div>
          <div class="bs-stepper-content">
            <form id="multiStepsForm" action="{{ route('register.store') }}" method="POST" novalidate>
              @csrf
              @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
              @endif

              <!-- Account Details -->
              <div id="accountDetailsValidation" class="content">
                <div class="content-header mb-4">
                  <h3 class="mb-1">Informasi Akun</h3>
                  <p>Masukkan email dan password untuk akun Rental Mobil Anda</p>
                </div>
                <div class="row g-3">
                  <div class="col-md-12">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="john.doe@email.com" aria-label="john.doe" autocomplete="email" />
                  </div>
                  <div class="col-sm-6 form-password-toggle">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge">
                      <input type="password" id="password" name="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password2" minlength="8" autocomplete="new-password" />
                      <span class="input-group-text cursor-pointer" id="password2"><i class="ti ti-eye-off"></i></span>
                    </div>
                  </div>
                  <div class="col-sm-6 form-password-toggle">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-group input-group-merge">
                      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password_confirmation2" minlength="8" autocomplete="new-password" />
                      <span class="input-group-text cursor-pointer" id="password_confirmation2"><i class="ti ti-eye-off"></i></span>
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-label-secondary btn-prev" disabled> <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                    </button>
                    <button type="button" class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Lanjut</span> <i class="ti ti-arrow-right ti-xs"></i></button>
                  </div>
                </div>
              </div>
              <!-- /Account Details -->

              <!-- Personal Info -->
              <div id="personalInfoValidation" class="content">
                <div class="content-header mb-4">
                  <h3 class="mb-1">Informasi Pribadi</h3>
                  <p>Lengkapi data diri Anda untuk keperluan penyewaan</p>
                </div>
                <div class="row g-3">
                  <div class="col-md-12">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="John Doe" autocomplete="name" />
                  </div>
                  <div class="col-md-12">
                    <label class="form-label" for="phone">No. HP</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="081234567890" maxlength="20" autocomplete="tel" />
                  </div>
                  <div class="col-md-12">
                    <label class="form-label" for="address">Alamat</label>
                    <textarea id="address" name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                  </div>
                  <div class="col-12 d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                    </button>
                    <button type="button" class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Lanjut</span> <i class="ti ti-arrow-right ti-xs"></i></button>
                  </div>
                </div>
              </div>
              <!-- /Personal Info -->

              <!-- Confirm -->
              <div id="confirmValidation" class="content">
                <div class="content-header mb-4">
                  <h3 class="mb-1">Konfirmasi Pendaftaran</h3>
                  <p>Periksa kembali data Anda sebelum mendaftar</p>
                </div>
                <div class="row g-3">
                  <div class="col-md-12">
                    <h6 class="text-uppercase small mb-2">Ringkasan Pendaftaran</h6>
                    <p class="mb-1 d-flex justify-content-between gap-2"><span class="text-muted">Nama</span><span id="reviewName" class="fw-semibold text-end">-</span></p>
                    <p class="mb-1 d-flex justify-content-between gap-2"><span class="text-muted">Email</span><span id="reviewEmail" class="fw-semibold text-end">-</span></p>
                    <p class="mb-1 d-flex justify-content-between gap-2"><span class="text-muted">No. HP</span><span id="reviewPhone" class="fw-semibold text-end">-</span></p>
                    <p class="mb-3 d-flex justify-content-between gap-2"><span class="text-muted">Alamat</span><span id="reviewAddress" class="fw-semibold text-end">-</span></p>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" value="1">
                      <label class="form-check-label" for="terms-conditions">
                        Saya setuju dengan
                        <a href="javascript:void(0);">kebijakan privasi &amp; ketentuan</a>
                      </label>
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                    </button>
                    <button type="submit" class="btn btn-success btn-submit">Daftar</button>
                  </div>
                </div>
              </div>
              <!-- /Confirm -->
            </form>
          </div>
        </div>

        <p class="text-center mt-4 mb-0">
          <span>Sudah punya akun?</span>
          <a href="{{ route('login') }}">
            <span>Masuk di sini</span>
          </a>
        </p>
      </div>
    </div>
    <!-- / Multi Steps Registration -->
  </div>
</div>
@endsection
