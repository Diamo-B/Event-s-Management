<header>
    <nav class="navbar">
      <div>
        <a href="{{ route('dashboard') }}"><img src="{{ URL::asset('svg/logo.svg'); }}" alt="Amdl Logo" class="logo" /></a>
        @yield('navbar addition')
        <a href="https://laravel.com/docs/9.x/migrations"><img src="{{ URL::asset('svg/gear.svg') }}" alt="settings" class="setingsGear"/></a>
        <a href="{{ route('logout') }}"><button class="Logout"><span>Logout</span></button></a>
      </div>
    </nav>
  </header>