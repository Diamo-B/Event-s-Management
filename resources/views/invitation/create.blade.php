@extends('app')

@section('content')
    @include('navbar')
    <main class="flex text-center rounded-full justify-center align-middle mt-8 mb-28">
        <div class="bg-indigo-400 p-10 border-4 border-indigo-500 rounded-lg">
            <h1 class="text-center text-3xl font-bold text-white pb-5 mb-5 border-b-2">Création une Nouvelle Invitation</h1>
            <form action="{{ route('invitation.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="Event" class="text-center text-2xl font-bold text-white">Evènement</label>
                <select type="text" name="Event" id="Event"
                    class="w-full mb-5 text-base text-gray-700 form-control  rounded-lg  text-center py-1.5 font-semibold bg-white bg-clip-padding border border-solid border-gray-600 transition ease-in-out m-0 focus:ring-0 focus:text-gray-700 focus:bg-white focus:border-gray-900 focus:outline-none">
                    @foreach ($events as $event)
                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
                <br>

                <label for="Body" class="text-center text-2xl font-bold text-white">Description de l'invitation</label>
                <textarea id="Body" name="Body" rows="4" class="mb-5 p-2.5 w-full text-base font-semibold text-gray-500 rounded-lg border bg-white border-gray-600 placeholder-gray-400   focus:border-gray-900 focus:text-gray-700 focus:outline-none focus:ring-0" placeholder="Describe the event..."></textarea>
                <br>

                <label for="attachment" class="text-center text-2xl font-bold text-white">Piéce jointe</label>
                <input name="attachment" id="attachment" class="block w-full text-base font-medium text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none " id="file_input" type="file">

                <br>

                <button type="submit" class="focus:ring-0 w-[50%]  border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                    <span class="text-center text-white text-lg font-bold group-hover:text-indigo-500 group-hover:font-bold">Créer</span>
                </button>

            </form>
        </div>
    </main>
    @include('footer')
@endsection
