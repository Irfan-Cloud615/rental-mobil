<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
  <div class="container">
    <a class="navbar-brand" href="{{ route('landing.index') }}">Wrent<span>RU</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="oi oi-menu"></span> Menu
    </button>

    <div class="collapse navbar-collapse" id="ftco-nav">
      <ul class="navbar-nav ml-auto">
        @foreach ([
          'index' => ['label' => 'Beranda', 'route' => 'landing.index'],
          'about' => ['label' => 'Tentang', 'route' => 'landing.about'],
          'cars' => ['label' => 'Mobil', 'route' => 'landing.cars'],
          'contact' => ['label' => 'Kontak', 'route' => 'landing.contact'],
        ] as $key => $item)
          <li class="nav-item {{ ($activeNav ?? '') === $key ? 'active' : '' }}">
            <a href="{{ route($item['route']) }}" class="nav-link">{{ $item['label'] }}</a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</nav>
<!-- END nav -->
