<header>
    <nav class="bg-indigo-400  py-3 px-12 border-b-4 border-gray-400 flex justify-between">
      <a href="{{ route('dashboard') }}" class=" mr-36"><img src="{{ URL::asset('svg/logo.svg') }}"></a>
      @yield('navbarAdd')
      
      <a href="{{ route('settings') }}" class=" ml-auto self-center"> <img src="{{ URL::asset('svg/day.svg') }}"> </a>


      <button class="self-center mx-7"> 
        <a href="{{ route('settings') }}"> <img src="{{ URL::asset('svg/gear.svg') }}"> </a>
      </button>


      <button class="border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group ">
        <a href="{{ route('logout') }}"><span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500">Se Déconnecter</span></a>
      </button>
  </nav>
</header>
