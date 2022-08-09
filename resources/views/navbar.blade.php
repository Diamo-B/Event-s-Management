<header>
    <nav class="bg-indigo-400  py-3 px-12 border-b-4 border-gray-400 flex justify-between">
      <a href="{{ route('dashboard') }}"><img src="{{ URL::asset('svg/logo.svg') }}"></a>
      @yield('navbarAdd')
      <button class="absolute right-52 top-6 "href="">
          <img src="{{ URL::asset('svg/day.svg') }}">
      </button>
      {{-- <a class="absolute right-52 top-6 hidden hover:visible "href=""><img src="{{ URL::asset('svg/night.svg') }}"></a> --}}
      <button class="border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group ">
        <a href="{{ route('logout') }}"><span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500">Logout</span></a>
      </button>
  </nav>
</header>
