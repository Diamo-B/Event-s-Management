@extends('app')

@section('navbarAdd')
    @if($role == 2)  
    <button class=" ml-60 border-4 border-white rounded-3xl  py-1 bg-inherit hover:bg-white group">
        <span class="text-center text-white font-semibold px-5 group-hover:text-black"><a href="{{ route('showFullStack') }}">Afficher les statistiques générales</a></span>
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
                <span class="font-medium">Succés !</span> {{ session()->get('successMsg') }}
                </div>
            </div>     
        </div>
        @endif
    <main class="py-[10%] mb-2.5">        
        <!-- Coordinator -->
        @if ($role == 1)
            <div class="grid grid-cols-3 w-full justify-center">   
             <div class="bg-indigo-400  p-5 shadow-lg rounded-3xl mx-16 py-10  grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold  text-white ">Evènements</p>
                <button class="border-4 border-white  rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('event.create') }}">Créer un Nouvel Evènement</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('event.index') }}">Consulter les Détails des Evènements</a></span>
                </button>
            </div>


            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white ">Invitations</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('invitation.create') }}">Créer une Nouvelle Invitation</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('invitation.index') }}">Consulter les Détails des Invitations</a></span>
                </button>
            </div>


            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white">Campagnes</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('campaign.create') }}">
                        Créer une Nouvelle Campagne</span></a>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group-hover:text-white">
                    <span class="text-center text-black font-semibold"><a href="{{ route('campaign.view') }}">Consulter les Détails des Campagnes</a></span>
                </button>
            </div> 
        </div>
        @elseif($role == 2)
        <!-- Top manager -->
        
        <div class="grid grid-cols-2 px-52 w-full justify-center ">  
            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white">Données</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-4 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('realTimeData') }}">Afficher les données en temps réel</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('history') }}">Afficher les données de l'historique</a></span>
                </button>
            </div>

            <div class="p-5 shadow-lg bg-indigo-400 rounded-3xl mx-16 py-10 grid gap-4">
                <p class="relative -top-5 text-center text-2xl font-bold text-white">Statistiques</p>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('DataStats') }}">Afficher les statistiques en temps réel</a></span>
                </button>
                <button class="border-4 border-white rounded-3xl mx-6 py-1 bg-white hover:bg-indigo-300 group">
                    <span class="text-center text-black font-semibold group-hover:text-white"><a href="{{ route('HistoryStats') }}">Afficher les statistiques de l'historique</a></span>
                </button>
            </div> 
        </div>
        @else
        <p>Aucun rôle n'a été attribué à cet utilisateur. Veuillez contacter un administrateur</p>
    @endif
    </main>
@include('footer')
@endsection