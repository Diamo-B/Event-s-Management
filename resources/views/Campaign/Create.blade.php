@extends('app')

@section('content')
    @include('navbar')
    @if($errors->any())
        <div class="grid grid-cols-1 w-full mt-3 justify-items-center" id="alert">
            <div class="flex p-4 text-sm w-fit text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Info</span>
                <div>
                <span class="font-medium">Error!</span> {{ $errors->first() }}
                </div>
            </div>
        </div>
    @endif
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
