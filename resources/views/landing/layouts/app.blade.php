<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? 'WrentRU' }} &mdash; {{ config('app.name', 'WrentRU') }}</title>
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('landing/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('landing/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('landing/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('landing/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('landing/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/jquery.timepicker.css') }}">


    <link rel="stylesheet" href="{{ asset('landing/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/style.css') }}">
  </head>
  <body>

    @include('landing.partials.nav', ['activeNav' => $activeNav ?? ''])

    @yield('content')

    @include('landing.partials.footer')


    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


    <script src="{{ asset('landing/js/jquery.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('landing/js/popper.min.js') }}"></script>
    <script src="{{ asset('landing/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('landing/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('landing/js/aos.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('landing/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('landing/js/scrollax.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="{{ asset('landing/js/google-map.js') }}"></script>
    <script src="{{ asset('landing/js/main.js') }}"></script>
    @stack('scripts')

  </body>
</html>
