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
    <main class="py-[10%] mb-2.5">        
        <!-- Coordinator -->
        @if ($role == 1)
            <div class="grid grid-cols-3 w-full justify-center ">   
             <div class="bg-indigo-400  p-5 shadow-lg rounded-3xl mx-16 py-10  grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold  text-white ">Events</p>
                <button class="border-4 border-white  rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('event.create') }}">Create a New Event</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('event.index') }}">View Events Info</a></span>
                </button>
            </div>


            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white ">Invitations</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('invitation.create') }}">Create a New Invitation</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('invitation.index') }}">View Invitation Info</a></span>
                </button>
            </div>


            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white">Campaigns</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('campaign.create') }}">
                        Create a New Campaigns</span></a>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group-hover:text-white">
                    <span class="text-center text-black font-semibold"><a href="{{ route('campaign.view') }}">View Campaigns Info</a></span>
                </button>
            </div> 
        </div>
        @elseif($role == 2)
        <!-- Top manager -->
        <div class="grid grid-cols-2 px-52 w-full justify-center ">  
            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white">Options</p>
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