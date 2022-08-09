@extends('app')

@section('content')
    @include('navbar')
    <main class="flex text-center rounded-full justify-center align-middle mt-8 mb-28">
        <div class="bg-indigo-400 p-10 border-4 border-indigo-500 rounded-lg">
            <h1 class="text-center text-3xl font-bold text-white pb-5 mb-5 border-b-2">Create Campaign</h1>
            <form action="{{ route('campaign.store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <label for="event" class="text-center text-2xl font-bold text-white">Event</label>
                <select name="event" id="event" class="form-select w-full mb-5 py-1.5 text-center text-base font-semibold text-gray-700 border border-solid rounded-lg border-gray-600 bg-white focus:text-gray-700  focus:border-gray-900 focus:outline-none focus:ring-0 " > 
                    @if (isset($event))
                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @else
                         @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    @endif
                </select>        
                
                <br>

                <label for="status" class="text-center text-2xl font-bold text-white">Status</label><br>
                <select name="status" id="status" class="form-select  mb-5 p-1.5 pr-5 text-center text-base font-semibold text-gray-700 border border-solid rounded-lg border-gray-600 bg-white focus:text-gray-700   focus:border-gray-900  focus:outline-none focus:ring-0">
                    <option value="Original">Original</option>
                    <option value="Relanch">Relaunch</option>
                    <option value="Complement">Complement</option>
                </select>

                <br>

                <label for="participants" class="text-center text-2xl font-bold text-white">Participants</label>
                <input type="file" name="participants" id="participants" class="block w-full py-1 px-4 text-base font-medium text-gray-700 bg-white rounded-lg border border-gray-600 cursor-pointer focus:outline-none ">

                <br>

                <button type="submit" class="focus:ring-0 w-[50%]  border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                    <span class="text-center text-white text-lg font-bold group-hover:text-indigo-500 group-hover:font-bold">create</span>
                </button>

            </form>
        </div>
    </main>
    @include('footer')
@endsection
