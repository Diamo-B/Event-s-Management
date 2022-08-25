@extends('app')

@section('navbarAdd')
    @if($role == 2)  
    <button class="border-4 border-white rounded-3xl  py-1 bg-inherit hover:bg-white group">
        <span class="text-center text-white font-semibold px-5 group-hover:text-black"><a href="{{ route('showFullStack') }}">View General Statistics</a></span>
    </button>
    @endif
@endsection

@section('content')
@include('navbar')
        @if(Session::has('successMsg'))
        <div class="absolute grid grid-cols-1 w-full justify-items-center" id="alert">
            <div class="flex w-fit px-40 py-4 mt-2 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Info</span>
                <div>
                <span class="font-medium">Success !</span> {{ session()->get('successMsg') }}
                </div>
            </div>     
        </div>
        @endif
    <main class="py-[10%] mb-2.5">        
        <!-- Coordinator -->
        @if ($role == 1)
            <div class="grid grid-cols-3 w-full justify-center">   
             <div class="bg-indigo-400  p-5 shadow-lg rounded-3xl mx-16 py-10  grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold  text-white ">{{ __('Coordinator/dashboard.Events') }}</p>
                <button class="border-4 border-white  rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('event.create') }}">{{ __('Coordinator/dashboard.EventsCreate') }}</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('event.index') }}">{{ __('Coordinator/dashboard.EventsView') }}</a></span>
                </button>
            </div>


            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white ">{{ __('Coordinator/dashboard.Invite') }}</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('invitation.create') }}">{{ __('Coordinator/dashboard.InviteCreate') }}</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('invitation.index') }}">{{ __('Coordinator/dashboard.InviteView') }}</a></span>
                </button>
            </div>


            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white">{{ __('Coordinator/dashboard.Camp') }}</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('campaign.create') }}">
                        {{ __('Coordinator/dashboard.CampCreate') }}</span></a>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group-hover:text-white">
                    <span class="text-center text-black font-semibold"><a href="{{ route('campaign.view') }}">{{ __('Coordinator/dashboard.CampView') }}</a></span>
                </button>
            </div> 
        </div>
        @elseif($role == 2)
        <!-- Top manager -->
        
        <div class="grid grid-cols-2 px-52 w-full justify-center ">  
            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white">Data</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('realTimeData') }}">View Real Time Data</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('history') }}">View History Data</a></span>
                </button>
            </div>

            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white">Statistics</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('DataStats') }}">View Real Time Stats</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('HistoryStats') }}">View History Stats</a></span>
                </button>
            </div> 
        </div>
        @else
        <p>NO role was assigned to this user. Please contact an administrator</p>
    @endif
    </main>
@include('footer')
@endsection