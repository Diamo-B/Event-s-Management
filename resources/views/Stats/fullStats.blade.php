@extends('app')
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/circleDiagrams.css') }}">
@endsection
@section('content')
    @include('navbar')
    @if (isset($adv))
        <main class="grid grid-cols-3 gap-4 mb-10 mt-5 mx-5 py-[5%] ">
            
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg shadow-2xl">
                        <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Taux d'acceptation total des invitations</h3>
                            <h4 class="relative top-6 text-center font-bold text-gray-400 group-hover:text-white">Invitations acceptées dans tous les événements par rapport à toutes les invitations émises</h4>
                            <div class="each flex justify-center mt-10 mb-8" >
                                <div class="flex items-center justify-center circular-progress relative h-32 w-32 rounded-full" onclick="animateCircle(this)">
                                    <input class="percentEnd" type="hidden" value=" {{ round($acceptanceRate,0,PHP_ROUND_HALF_UP) }}">
                                    <span class="progress-value text-indigo-500 relative text-xl font-bold ">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg shadow-2xl">
                        <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Taux de présence global</h3>
                            <h4 class="relative top-6 text-center font-bold text-gray-400 group-hover:text-white">Participations à tous les événements par rapport à toutes les invitations émises</h4>
                            <div class="each flex justify-center mt-10 mb-8">
                                <div class="flex items-center justify-center circular-progress relative h-32 w-32 rounded-full" onclick="animateCircle(this)">
                                    <input class="percentEnd" type="hidden" value=" {{ round($attandanceRate,0,PHP_ROUND_HALF_UP) }}">
                                    <span class="progress-value text-indigo-500 relative text-xl font-bold ">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg shadow-2xl">
                        <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Taux d'absence total</h3>
                            <h4 class="relative top-6 text-center font-bold text-gray-400 group-hover:text-white">Utilisateurs absents à tous les événements par rapport à toutes les invitations émises</h4>
                            <div class="each flex justify-center mt-10 mb-8">
                                <div class="flex items-center justify-center circular-progress relative h-32 w-32 rounded-full" onclick="animateCircle(this)">
                                    <input class="percentEnd" type="hidden" value=" {{ round($absenceRate,0,PHP_ROUND_HALF_UP) }}">
                                    <span class="progress-value text-indigo-500 relative text-xl font-bold ">0%</span>
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
                    <div class="rounded-lg shadow-2xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Evénements</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $events }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">les événements non commencés, en cours et terminés</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-2xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">En Cours</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $ongoingEvents }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">Depuis {{ $events }} événements en total</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-2xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">N'ont pas encore commencés</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $notStartedYetEvents }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">Depuis {{ $events }} événements en total</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-2xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Terminés</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $endedEvents }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">Depuis {{ $events }} événements en total</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg  shadow-2xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Total des comptes des participants</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $participants }} </p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">De tous les {{ $users }} utilisateurs</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-3xl">
                <div class="w-full mt-1">
                    <div class="rounded-lg shadow-2xl">
                        <div class="rounded-lg bg-gray-100 shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                            <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Nombre total d'invitations aux participants</h3>
                            <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $invites }}</p> 
                            <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">Conçu pour {{ $invites }} événements </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class='flex justify-center'>
            <form action="{{ route('showFullStack') }}" method="post">
                @csrf
                <button class=" border-4 border-gray-200 rounded-3xl mx-6 py-2 px-6 bg-white hover:bg-indigo-300 group ">
                <span class="text-center text-black font-semibold group-hover:text-white">Afficher les statistiques avancées</span>
                </button>
            </form>
        </div>
        @endif
        
    @include('footer')
@endsection

@section('scripts')
<script src="{{ URL::asset('js/Animationscript.js') }}"></script>
@endsection