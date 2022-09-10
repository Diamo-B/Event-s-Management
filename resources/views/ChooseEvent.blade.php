@extends('app')

@section('content')
    @include('navbar')
    
    <main class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] ">

        <div class="flex text-center rounded-full justify-center">
            @isset($events)
            
            <div class="bg-indigo-400 py-10 px-28 border-4 border-indigo-500 rounded-lg ">
                
                
                <!-- selecting the event -->
                <label for="Event" class="text-center text-3xl text-white font-bold">Evènement</label>
                <h3 class="text-xl text-gray-500 font-semibold">Veuiller choisir un évènement</h3><br>
                @if(isset($Inv))
                    <form action="{{ route('invitation.index') }}" method="post" >
                @elseif(isset($Camp))
                    <form action="{{ route('campaign.view') }}" method="post" >
                @elseif(isset($type) && $type == 'DataStat' )
                    <form action="{{ route('DataStats') }}" method="post" >
                @elseif(isset($type) &&  $type == 'HistoryStat') 
                    <form action="{{ route('HistoryStats') }}" method="post" >
                @endif
                    @csrf
                    <select type="text" name="Events" id="Events"
                        class="form-select mb-5 rounded-lg text-center text-base font-semibold text-gray-700 border border-gray-400">
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                    <br>
                    @if(isset($Inv))
                        <button type="submit" class="focus:ring-0 w-full  border-4 border-white rounded-3xl  px-8 py-1 hover:bg-white group  ">
                        <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500">Afficher l'invitation de cet événement</span>
                        </button>
                    @elseif(isset($Camp))
                        <button type="submit" class="focus:ring-0 w-full border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                        <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500">Afficher les campagnes de cet événement</span>
                        </button>
                    @elseif(isset($type))
                        <button type="submit" class="focus:ring-0 w-full border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                        <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500">Afficher les statistiques de cet événement</span>
                        </button>
                    @endif
                    

                </form>

            </div>
            @endisset
        </div>
    </main>

    @include('footer')
@endsection
