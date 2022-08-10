@extends('app')
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/circleDiagrams.css') }}">
@endsection
@section('content')
    @include('navbar')
    @if (isset($adv))
        <main class="grid grid-cols-3 gap-4 mb-10 mt-5 mx-5 py-[5%] ">
            
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg shadow-sm">
                        <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Total Invitation Acceptance Rate</h3>
                            <h4 class="relative top-6 text-center font-bold text-gray-400 group-hover:text-white">Accepted invitations in all events in regard of all the issued invitations</h4>
                            <div class="circleDiv">
                                <div class="circle-diagram" style="--percent: {{ round($acceptanceRate,PHP_ROUND_HALF_UP) }}">
                                    <p class="statText">{{ round($acceptanceRate,PHP_ROUND_HALF_UP) }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg shadow-sm">
                        <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Total Attandance Rate</h3>
                            <h4 class="relative top-6 text-center font-bold text-gray-400 group-hover:text-white">Attandances in all events in regard of all the issued invitations</h4>
                            <div class="circleDiv">
                                <div class="circle-diagram" style="--percent: {{ round($attandanceRate,PHP_ROUND_HALF_UP) }}">
                                    <p class="statText">{{ round($attandanceRate,PHP_ROUND_HALF_UP) }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg shadow-sm">
                        <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Total Absence Rate</h3>
                            <h4 class="relative top-6 text-center font-bold text-gray-400 group-hover:text-white">Users being absent in all events in regard of all the issued invitations</h4>
                            <div class="circleDiv">
                                <div class="circle-diagram" style="--percent: {{ round($absenceRate,PHP_ROUND_HALF_UP) }}">
                                    <p class="statText">{{ round($absenceRate,PHP_ROUND_HALF_UP) }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </main>
            @else
        <main class="grid grid-cols-3 gap-4 mb-10 mt-5 mx-5 ">
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Events</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $events }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">including not started, ongoing and ended events</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Ongoing</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $ongoingEvents }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">from {{ $events }} events overall</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Has Not Started Yet</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $notStartedYetEvents }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">from {{ $events }} events overall</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Ended</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $endedEvents }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">from {{ $events }} events overall</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Total Participant accounts</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $participants }} </p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">from all the {{ $users }} users</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Total invitations to Participants</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $invites }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">Sent to {{ $participants }} participants</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class='flex justify-center'>
            <form action="{{ route('showFullStack') }}" method="post">
                @csrf
                <button class=" border-4 border-gray-200 rounded-3xl mx-6 py-2 px-6 bg-white hover:bg-indigo-300 group ">
                <span class="text-center text-black font-semibold group-hover:text-white">View Advanced Stats</span>
                </button>
            </form>
        </div>
        @endif
        
    @include('footer')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
</script>

<script src='https://unpkg.co/gsap@3/dist/gsap.min.js'></script>
<script src="{{ URL::asset('js/Animationscript.js') }}"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LLWL5N9CSM"></script>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}
gtag('js', new Date());
gtag('config', 'G-LLWL5N9CSM');
</script>

@endsection