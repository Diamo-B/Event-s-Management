@extends('app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />

@endsection

@section('content')
    @include('navbar')
    @if($errors->any())
    <div class="grid grid-cols-1 w-full mt-3 justify-items-center" id="alert">
        <div class="flex p-4 text-sm w-fit text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Info</span>
            <div>
            <span class="font-medium">Alert!</span> {{ $errors->first() }}
            </div>
        </div>
    </div>
    @endif 
    <main class="grid text-center rounded-full justify-center align-middle mt-14 mb-28">
        <div class="bg-indigo-400 p-10 border-4 border-indigo-500 rounded-lg">
            <h1 class="text-center text-3xl font-bold text-white pb-5 mb-5 border-b-2">{{ __('Coordinator/EventCreate.containertitle') }}</h1>
            <form action="{{ route('event.store') }}" method="post">
                @csrf
                <label for="Title" class="text-center text-2xl font-black text-white">{{ __('Coordinator/EventCreate.title') }}</label><br>
                <input type="text" name="Title" id="Title" class="w-full mb-5 text-sm text-gray-700 form-control rounded-lg text-center py-1.5 font-normal bg-white bg-clip-padding border border-solid border-gray-600 transition ease-in-out m-0 focus:ring-0  focus:bg-white focus:border-gray-900 focus:outline-none">
                <br>
                <label for="desc" class="text-center text-2xl font-bold text-white">{{ __('Coordinator/EventCreate.desc') }}</label><br>
                <textarea id="desc" name="Object" rows="4" class="mb-5 p-2.5 w-full text-sm text-gray-700 rounded-lg border bg-white border-gray-600 placeholder-gray-400   focus:border-gray-900  focus:outline-none focus:ring-0" placeholder="{{ __('Coordinator/EventCreate.descPlaceholder') }}"></textarea>

                <div class="flex mb-5 items-center">
                    <div class=" datepicker relative  " data-mdb-toggle-button="false">
                        <input type="text" name="Starting_date" id="sDate"
                            class="form-control text-center py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border-gray-600 placeholder-gray-400  border border-solid rounded transition focus:border-gray-900  focus:outline-none focus:ring-0  focus:bg-white "
                            placeholder="{{ __('Coordinator/EventCreate.Sdate') }}" data-mdb-toggle="datepicker" autocomplete="off"/>
                    </div>
                    <div class="text-white">{{ __('Coordinator/EventCreate.To') }}</div>
                    <div class="datepicker relative " data-mdb-toggle-button="false">
                        <input type="text" name="Ending_date" 
                        class="form-control text-center py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border-gray-600 placeholder-gray-400  border border-solid rounded transition focus:border-gray-900  focus:outline-none focus:ring-0  focus:bg-white "
                        placeholder="{{ __('Coordinator/EventCreate.Edate') }}" data-mdb-toggle="datepicker"  autocomplete="off"/>
                    </div>
                </div>
                
                <div class="flex mb-5 items-center">
                    <div class="timepicker relative form-floating" data-mdb-with-icon="false" id="input-toggle-timepicker">
                      <input type="text" name="Starting_time"
                        class=" text-center py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 placeholder-gray-400 rounded transition focus:border-gray-900 focus:outline-none focus:ring-0  focus:bg-white"
                        placeholder="{{ __('Coordinator/EventCreate.Stime') }}" data-mdb-toggle="input-toggle-timepicker"  autocomplete="off"/>
    
                    </div>
                    <div class="text-white">{{ __('Coordinator/EventCreate.To') }}</div>
                    <div class="timepicker relative form-floating" data-mdb-with-icon="false" id="input-toggle-timepicker">
                        <input type="text" name="Ending_time"
                            class=" text-center py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 placeholder-gray-400 rounded transition focus:border-gray-900 focus:outline-none focus:ring-0  focus:bg-white"
                          placeholder="{{ __('Coordinator/EventCreate.Etime') }}" data-mdb-toggle="input-toggle-timepicker"  autocomplete="off"/>
                    </div>
                </div>
                
                <label for="location" class="text-center text-2xl font-bold text-white">{{ __('Coordinator/EventCreate.Location') }}</label><br>
                <input type="text" name="location" id="Location" class="w-full mb-5 text-sm text-gray-700 form-control  rounded-lg  text-center py-1.5 font-normal bg-white bg-clip-padding border border-solid border-gray-600 transition  focus:ring-0  focus:bg-white focus:border-gray-900 focus:outline-none">
                <br>
                <label for="room" class="text-center text-2xl font-bold text-white">{{ __('Coordinator/EventCreate.Room') }}</label><br>
                <input type="text" name="room" id="room" class="w-full mb-10 text-sm text-gray-700 form-control  rounded-lg  text-center py-1.5 font-normal bg-white bg-clip-padding border border-solid border-gray-600 transition  focus:ring-0  focus:bg-white focus:border-gray-900 focus:outline-none">
                <br>
                <button type="submit" class="focus:ring-0 w-[50%]  border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                    <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500 group-hover:font-bold">{{ __('Coordinator/EventCreate.button') }}</span>
                </button>
    
            </form>
        </div>
    </main>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
@endsection
