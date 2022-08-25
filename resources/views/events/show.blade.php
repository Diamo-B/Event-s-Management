@extends('app')

@section('scripts')
    <script>
    function showFilter() {
        let filter_panel = document.getElementById('filter_panel');
        if (filter_panel.classList.contains('hidden')) 
        {
            filter_panel.classList.remove('hidden');
            filter_panel.classList.add('flex');
        }
        else
        {
            filter_panel.classList.remove('flex');
            filter_panel.classList.add('hidden');
        }
    }

    function checkboxChange(el) {
        let ckName = document.getElementsByName(el.name);
        for (var i = 0, c; c = ckName[i]; i++) {
        c.disabled = !(!el.checked || c === el);
        }
    }

    function alphaOrder(el){
        let icon = document.getElementById(el.id);

        if (icon.classList.contains('text-black')) 
        {
            icon.classList.remove('text-black');
            icon.classList.remove('bg-white');
            icon.classList.remove('hover:text-white');
            icon.classList.remove('hover:bg-indigo-400');
            icon.classList.add('bg-indigo-400');
            icon.classList.add('text-white');
            icon.classList.add('hover:text-black');
            icon.classList.add('hover:bg-white');
        }
        else
        {
            icon.classList.remove('bg-indigo-400');
            icon.classList.remove('text-white');
            icon.classList.remove('hover:text-black');
            icon.classList.remove('hover:bg-white');
            icon.classList.add('text-black');
            icon.classList.add('bg-white');
            icon.classList.add('hover:text-white');
            icon.classList.add('hover:bg-indigo-400');
        }
    }
    </script>
@endsection

@section('navbarAdd')
    @isset($search)
    <div class="w-[40%] self-center">
        <div class="relative">
            <form action="{{ route('event.search') }}" method="post" class="m-0">
                @method('POST')
                @csrf
                <!-- search -->
                <input type="search" id="default-search" name="search"
                    class="w-[68%] text-sm text-white bg-indigo-400 rounded-lg border-2 border-white focus:border-white focus:outline-none  focus:font-bold   placeholder:text-white placeholder:font-bold"
                    placeholder="Search Any Event By Name Or Location">
                <button type="submit" class="text-black absolute right-20 bottom-1 bg-white border-2 border-white hover:bg-indigo-400 hover:text-white  font-medium rounded-lg text-sm px-4 py-1">
                    Search
                </button>
            </form>


            <form action="{{ route('event.filter') }}" method="post" class="m-0">
                @method('POST')
                @csrf
                <!-- filter button -->
                <button type="button" class="text-black absolute left-[85%] bottom-1 bg-white border-2 border-white hover:bg-indigo-400 hover:text-white  font-medium rounded-lg text-sm px-4 py-1" onclick="showFilter()">
                    <i class="fa-solid fa-filter"></i><i class="fa-solid fa-caret-down"></i>
                </button>

                <!-- filter panel -->
                <div id='filter_panel' class="absolute hidden text-sm w-[63%] z-50 text-gray-600 font-semibold " style='margin-left: 350px;'>
                    <div class=" grid grid-cols-5 mt-3 py-5 bg-indigo-300 rounded-2xl ">
                        <div class="border-b-2 col-span-5  border-solid border-white w-full flex justify-between space-x-4 px-5 h-fit py-2 ">
                            <p class="inline-block col-span-4 ">Nearest events</p>
                            <input name="SearchCrit" type="checkbox" value="nearest" class="inline-block col-span-1 text-indigo-500 bg-gray-100 rounded border-gray-300" onclick="checkboxChange(this)"></input>
                        </div>
                        <div class="border-y-2 col-span-5  border-solid border-white w-full flex justify-between space-x-4 px-5 h-fit py-2 ">
                            <p class="inline-block col-span-4 ">Latest events</p>
                            <input name="SearchCrit" type="checkbox" value="latest" class="inline-block col-span-1 text-indigo-500 bg-gray-100 rounded border-gray-300" onclick="checkboxChange(this)"></input>
                        </div>
                        <div class="border-y-2 col-span-5  border-solid border-white w-full flex space-x-4 justify-between px-5 h-fit py-2">
                            <p class="inline-block col-span-4 ">Events With Campaigns</p>
                            <input name="SearchCrit" type="checkbox" value="camp" class="inline-block col-span-1 text-indigo-500 bg-gray-100 rounded border-gray-300" onclick="checkboxChange(this)"></input>
                        </div>
                        <div class="border-t-2 border-b-4 col-span-5  border-solid border-white w-full flex space-x-4 justify-between px-5 h-fit py-2">
                            <p class="inline-block col-span-4 ">Events Without Campaigns</p>
                            <input name="SearchCrit" type="checkbox" value="nocamp" class="inline-block col-span-1 text-indigo-500 bg-gray-100 rounded border-gray-300" onclick="checkboxChange(this)"></input>
                        </div>
                        <div class="mt-2 col-span-5  border-solid border-white w-full flex justify-center px-5 h-fit py-2">
                            <button name="submit" value="filter" type="submit" class="col-span-5 w-fit text-center  border-4 border-white rounded-3xl px-10 py-1 hover:bg-indigo-200 group ">
                                <span class="text-center text-gray-800 text-md font-bold  group-hover:text-white">Filter</span>
                            </button>
                        </div>
                    </div>
                </div>

                @if(!isset($hideOrder)||(isset($hideOrder) && $hideOrder == true))
                    <!-- alphabetical order A to Z -->
                    <button name="submit" value="orderDesc" id="orderAsc" type="submit" onclick='alphaOrder(this)' class="text-black absolute left-[98%] bottom-1 bg-white border-2 border-white  hover:bg-indigo-400 hover:text-white font-medium rounded-lg text-sm px-4 py-1">
                        <i class="fa-solid fa-arrow-down-a-z"></i>
                    </button>

                    <!-- alphabetical order Z to A -->
                    <button name="submit" value="orderAsc" id="orderDesc" type="submit" onclick='alphaOrder(this)' class="text-black absolute left-[109%] bottom-1 bg-white border-2 border-white hover:bg-indigo-400 hover:text-white font-medium rounded-lg text-sm px-4 py-1">
                        <i class="fa-solid fa-arrow-up-a-z"></i>
                    </button>
                @endif    
                
            </form>
        </div>
                
    </div>
    
    @endisset
@endsection

@section('content')
    @include('navbar')
            
    <!-- -----------------------------------------     index  && Search    --------------------------------------------- -->
    @isset($events)
    <main> 
        <p class='mt-3 text-center w-full text-3xl text-gray-700 font-bold'>View Events</p>
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
        <div class="grid justify-center mt-5 mb-28">
            <div class="overflow-x-auto relative shadow-2xl mb-5 sm:rounded-lg">
                <table class="w-full text-sm text-center  text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-indigo-400 ">
                        <tr>
                            <th scope="col" class="py-3 px-40 text-left">
                                Event's title
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Starting On
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Ending On
                            </th>
                            <th scope="col" class="py-3 px-6">
                                <span class="sr-only">Details</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                                <tr class="bg-white border-b hover:bg-indigo-300 hover:text-white group">
                                    <td scope="row"
                                        class="py-4 px-6 font-medium text-left text-gray-900 group-hover:text-white whitespace-nowrap ">
                                            {{ Str::limit( $event['title'], 60, $end = '.......')}} 
                                    </td>
                                    <td class="py-4 px-6">
                                            {{ $event['startingAt'] }}
                                    </td>
                                    <td class="py-4 px-6">
                                            {{ $event['endingAt'] }}
                                    </td>
                                    <td class="py-4 px-6 text-right group">
                                        @if (isset($realtimedata))
                                            <form action="{{ route('realTimeData') }}" method="POST">
                                                @csrf
                                                <input type="text" class=" hidden" name="Event" value="{{ $event['id'] }}">
                                                <button type='submit' class=" group-hover:text-white hover:font-semibold">View Details</button>
                                            </form>
                                        @elseif(isset($Historydata))
                                            <form action="{{ route('history') }}" method="POST">
                                                @csrf
                                                <input type="text" class=" hidden" name="Event" value="{{ $event['id']  }}">
                                                <button type='submit' class=" group-hover:text-white hover:font-semibold">View Details</button>
                                            </form>
                                        @elseif(isset($type) && $type == 'DataStat')
                                            <form action="{{ route('DataStats') }}" method="POST">
                                                @csrf
                                                <input type="text" class=" hidden" name="Events" value="{{ $event['id']  }}">
                                                <button type='submit' class=" group-hover:text-white hover:font-semibold">View Details</button>
                                            </form>
                                        @elseif(isset($type) && $type == 'HistoryStat')
                                            <form action="{{ route('HistoryStats') }}" method="POST">
                                                @csrf
                                                <input type="text" class=" hidden" name="Events" value="{{ $event['id']  }}">
                                                <button type='submit' class=" group-hover:text-white hover:font-semibold">View Details</button>
                                            </form>
                                        @else
                                            
                                            <a href="{{ route('event.show', $event['id']) }}"
                                                class=" group-hover:text-white hover:font-semibold">View Details
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            @if ($events->hasPages())
            <div class="flex justify-end">
                @if (isset($data))
                {{ $events->withQueryString()->appends($data)->links() }}
                @else
                {{ $events->links() }}                                    
                @endif
            </div>
            @endif
        </div>
    </main>       
    @endisset

    <!-- -----------------------------------------     details    --------------------------------------------- -->
    @isset($details)
    <main class="my-10 mb-28"> 
            <div class="grid justify-center items-center mx-20">
                <h1 class="text-4xl font-semibold mb-10 text-gray-400">Event's Details</h1>
                <div class=" relative shadow-2xl mb-5  rounded-xl bg-indigo-400">
                    <table class="w-full text-base text-center text-white">
                            <tr scope="row" class='border-b-4 rounded-xl hover:bg-indigo-300'>
                              <th class="py-3 mx-16 border-r-4 ">Event's Title</th>
                              <td class="px-10">{{ $details->title }}</td>
                            </tr>
                            <tr scope="row" class='border-b-4 hover:bg-indigo-300'>
                              <th class="py-3 px-16 border-r-4">Description</th>
                              <td class="px-10">{{ $details->object }}</td>
                            </tr>
                            <tr scope="row" class='border-b-4 hover:bg-indigo-300'>
                              <th class="py-3 px-6 border-r-4">Starting On</th>
                              <td class="px-10">{{ $Date_Time[0] }}</td>
                            </tr>
                            <tr scope="row" class='border-b-4 hover:bg-indigo-300'>
                                <th class="py-3 px-6 border-r-4">At</th>
                                <td class="px-10">{{ $Date_Time[2] }}</td>
                            </tr>
                            <tr scope="row" class='border-b-4 hover:bg-indigo-300'>
                                <th class="py-3 px-6 border-r-4">Ending On</th>
                                <td class="px-10">{{ $Date_Time[1] }}</td>
                            </tr>
                            <tr scope="row" class='border-b-4 hover:bg-indigo-300'>
                                <th class="py-3 px-6 border-r-4">At</th>
                                <td class="px-10">{{ $Date_Time[3] }}</td>
                            </tr>
                            <tr scope="row" class='border-b-4 hover:bg-indigo-300'>
                                <th class="py-3 px-6 border-r-4">Location</th>
                                <td class="px-10">{{ $details->location }}</td>
                            </tr>
                            <tr scope="row" class='border-b-4 hover:bg-indigo-300' >
                                <th class="py-3 px-6 border-r-4 hover:bg-indigo-300">Room</th>
                                <td class="px-10">{{ $details->room }}</td>
                            </tr>
                            <tr>
                                <th class="py-10 px-6 hover:bg-indigo-300 "></th>
                                <td>
                                    @isset($showButton)
                                        <form action="" method="POST"> 
                                            @csrf
                                            <input type="text" class="hidden" name="eventTitle" value="{{ $details->title }}">
                                            <button type="submit" class="focus:ring-0 border-4 border-gray-400 rounded-3xl px-8 py-1 hover:border-indigo-700 hover:bg-indigo-400 group  ">
                                                <span class="text-center text-gray-600 text-lg font-semibold group-hover:text-white  ">view Campaigns</span>
                                            </button>
                                        </form>
                                    @endisset
                                </td>
                            </tr>
                    </table>  
                    
                </div>
             
            </div>
            
        </div>
    </main>
    @endisset


    @include('footer')
@endsection
