@extends('app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />

@endsection

@section('content')
    @include('navbar')
    <main class="flex text-center rounded-full justify-center align-middle mt-14  mb-28">
        <div class="bg-indigo-400 p-10 border-4 border-indigo-500 rounded-lg">
            <form action="{{ route('event.store') }}" method="post">
                @csrf
                <label for="Title" class="text-center text-2xl font-black text-white">Event's Title</label><br>
                <input type="text" name="Title" id="Title" class="w-full mb-5 text-sm text-gray-700 form-control rounded-lg text-center py-1.5 font-normal bg-white bg-clip-padding border border-solid border-gray-600 transition ease-in-out m-0 focus:ring-0  focus:bg-white focus:border-gray-900 focus:outline-none">
                <br>
                <label for="desc" class="text-center text-2xl font-bold text-white">Description</label><br>
                <textarea id="desc" name="Object" rows="4" class="mb-5 p-2.5 w-full text-sm text-gray-700 rounded-lg border bg-white border-gray-600 placeholder-gray-400   focus:border-gray-900  focus:outline-none focus:ring-0" placeholder="Describe the event..."></textarea>

                <div class="flex mb-5 items-center">
                    <div class=" datepicker relative  " data-mdb-toggle-button="false">
                        <input type="text" name="Starting_date" id="sDate"
                            class="form-control text-center py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border-gray-600 placeholder-gray-400  border border-solid rounded transition focus:border-gray-900  focus:outline-none focus:ring-0  focus:bg-white "
                            placeholder="Starting date" data-mdb-toggle="datepicker" autocomplete="off"/>
                    </div>
                    <div class="text-white">To</div>
                    <div class="datepicker relative " data-mdb-toggle-button="false">
                        <input type="text" name="Ending_date" 
                        class="form-control text-center py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border-gray-600 placeholder-gray-400  border border-solid rounded transition focus:border-gray-900  focus:outline-none focus:ring-0  focus:bg-white "
                        placeholder="Ending date" data-mdb-toggle="datepicker"  autocomplete="off"/>
                    </div>
                </div>
                
                <div class="flex mb-5 items-center">
                    <div class="timepicker relative form-floating" data-mdb-with-icon="false" id="input-toggle-timepicker">
                      <input type="text" name="Starting_time"
                        class=" text-center py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 placeholder-gray-400 rounded transition focus:border-gray-900 focus:outline-none focus:ring-0  focus:bg-white"
                        placeholder="Starting time" data-mdb-toggle="input-toggle-timepicker"  autocomplete="off"/>
    
                    </div>
                    <div class="text-white">To</div>
                    <div class="timepicker relative form-floating" data-mdb-with-icon="false" id="input-toggle-timepicker">
                        <input type="text" name="Ending_time"
                            class=" text-center py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 placeholder-gray-400 rounded transition focus:border-gray-900 focus:outline-none focus:ring-0  focus:bg-white"
                          placeholder="Endingtime" data-mdb-toggle="input-toggle-timepicker"  autocomplete="off"/>
                    </div>
                </div>
                
                <label for="location" class="text-center text-2xl font-bold text-white">Location</label><br>
                <select type="text" name="location" id="Location" class="w-full mb-5 text-sm text-gray-700 form-control  rounded-lg  text-center py-1.5 font-normal bg-white bg-clip-padding border border-solid border-gray-600 transition  focus:ring-0  focus:bg-white focus:border-gray-900 focus:outline-none">
                    <option value="amdl">Amdl Rabat</option>
                    <option value="tokyo">tokyo</option>
                    <option value="berlin">berlin</option>
                </select>
                <br>
                <label for="room" class="text-center text-2xl font-bold text-white">Room</label><br>
                <input type="text" name="room" id="room" class="w-full mb-10 text-sm text-gray-700 form-control  rounded-lg  text-center py-1.5 font-normal bg-white bg-clip-padding border border-solid border-gray-600 transition  focus:ring-0  focus:bg-white focus:border-gray-900 focus:outline-none">
                <br>
                <button type="submit" class="focus:ring-0 w-[50%]  border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                    <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500 group-hover:font-bold">create</span>
                </button>
    
            </form>
        </div>
    </main>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
@endsection
