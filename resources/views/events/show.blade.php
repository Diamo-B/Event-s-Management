@extends('app')


@section('navbarAdd')
    @isset($search)
    <div class="self-center w-[30%] ">
        <div class="relative">
            <form action="{{ route('event.search') }}" method="post" class="m-0">
                @method('POST')
                @csrf
                <input type="search" id="default-search" name="search"
                    class="block  w-full text-sm text-white bg-indigo-400 rounded-lg border-2 border-white focus:border-white focus:outline-none  focus:font-bold   placeholder:text-white placeholder:font-bold"
                    placeholder="Search Any Event By Name Or Location" required>
                <button type="submit"
                    class="text-black absolute right-1 bottom-1 bg-white border-2 border-white hover:bg-indigo-400 hover:text-white  font-medium rounded-lg text-sm px-4 py-1">Search</button>
              
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
        @if (session('error'))
            <div style="position:relative; top:49px; padding:1rem; margin-bottom: 1rem; font-size: 16px; font-weight: 700; border-radius: 25px; line-height: 1.25rem; --tw-text-opacity: 1; color:  rgba(185,28,28,var(--tw-text-opacity)); --tw-bg-opacity: 1; background-color:  rgba(254,226,226,var(--tw-bg-opacity)); text-align: center;"
            role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="grid justify-center mt-14 mb-28">
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
                        @if (!isset($type) && (isset($realtimedata) || isset($Historydata)) && $events->currentPage() == 1)    
                            <tr class="bg-pink-300 border-b text-white text-center  group">
                                <td scope="row" colspan="4">
                                    The events with Campaigns start here
                                </td>
                            </tr>
                        @endif
                        @foreach ($events as $event)
                            @if ($event == 'Events with Campaigns' && !isset($type))
                            <tr class="bg-pink-300 border-b text-white text-center  group">
                                <td scope="row" colspan="4">
                                    The events with Campaigns end here
                                </td>
                            </tr>
                            @else


                                <tr class="bg-white border-b hover:bg-indigo-300 hover:text-white group">
                                    <td scope="row"
                                        class="py-4 px-6 font-medium text-left text-gray-900 group-hover:text-white whitespace-nowrap ">
                                        
                                            @if (isset($realtimedata) || isset($Historydata) || isset($type))
                                                {{ Str::limit(  $event->title, 60, $end = '.......')}}
                                            @else
                                            {{ Str::limit( $event['title'], 60, $end = '.......')}} 
                                            @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @if (isset($realtimedata)|| isset($Historydata) || isset($type))
                                            {{ $event->startingAt }}
                                        @else
                                            {{ $event['startingAt'] }}
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @if (isset($realtimedata)|| isset($Historydata) || isset($type))
                                            {{ $event->endingAt }}
                                        @else
                                            {{ $event['endingAt'] }}
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right group">
                                        @if (isset($realtimedata))
                                            <form action="{{ route('realTimeData') }}" method="POST">
                                                @csrf
                                                <input type="text" class=" hidden" name="Event" value="{{ $event->id }}">
                                                <button type='submit' class=" group-hover:text-white hover:font-semibold">View Details</button>
                                            </form>
                                        @elseif(isset($Historydata))
                                            <form action="{{ route('history') }}" method="POST">
                                                @csrf
                                                <input type="text" class=" hidden" name="Event" value="{{ $event->id }}">
                                                <button type='submit' class=" group-hover:text-white hover:font-semibold">View Details</button>
                                            </form>
                                        @elseif(isset($type) && $type == 'DataStat')
                                            <form action="{{ route('DataStats') }}" method="POST">
                                                @csrf
                                                <input type="text" class=" hidden" name="Events" value="{{ $event->id }}">
                                                <button type='submit' class=" group-hover:text-white hover:font-semibold">View Details</button>
                                            </form>
                                        @elseif(isset($type) && $type == 'HistoryStat')
                                            <form action="{{ route('HistoryStats') }}" method="POST">
                                                @csrf
                                                <input type="text" class=" hidden" name="Events" value="{{ $event->id }}">
                                                <button type='submit' class=" group-hover:text-white hover:font-semibold">View Details</button>
                                            </form>
                                        @else
                                            
                                            <a href="{{ route('event.show', $event['id']) }}"
                                                class=" group-hover:text-white hover:font-semibold">View Details
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
            
            @if ($events->hasPages())
            <div class="flex justify-end">
                {{ $events->links() }}
            </div>
            @endif

        </div>
    </main>       
    @endisset

    <!-- -----------------------------------------     details    --------------------------------------------- -->
    @isset($details)
    <main class="my-10 mb-28"> 
        <div class="flex flex-col justify-center items-center mx-72 p-10 bg-indigo-400 rounded-3xl text-center text-white">                
            <h1 class=" text-4xl font-bold mb-10">Event's Details</h1>



            <div class=" w-full hover:rounded-3xl  hover:text-cyan-200">
                <h3 class=" text-3xl font-semibold">Title</h3>
                <p class=" text-xl font-semibold ">{{ $details->title }}</p>
            </div>
            <br>
            <div class=" w-full hover:rounded-3xl  hover:text-cyan-200">
                <h3 class="text-3xl font-semibold">Description</h3>
                <p>{{ $details->object }}</p>
            </div>
            <br>
            <div class="flex w-full justify-evenly">
                <div class="hover:text-cyan-200">
                    <h3 class="text-xl font-semibold">Starting on 
                        {{ $Date_Time[0] }}
                    </h3>
                    
                    <h3 class="text-xl font-semibold">
                        At 
                        {{ $Date_Time[2] }}
                    </h3>
                    
                </div>
                <br>
                <div class="hover:text-cyan-200">
                    <h3 class="text-xl font-semibold">Ending on
                        {{ $Date_Time[1] }}
                    </h3>

                    <h3 class="text-xl font-semibold">
                        At
                        {{ $Date_Time[3] }}
                    </h3>
                </div>
            </div>
            <br>
            <div class="flex w-[50%] mb-5 justify-evenly">
                <div class="hover:text-cyan-200">
                    <h3 class="text-3xl font-semibold">Location</h3>
                    <p>{{ $details->location }}</p>
                </div class="hover:text-cyan-200">
                <br>
                <div class="hover:text-cyan-200">
                    <h3 class="text-3xl font-semibold">Room</h3>
                    <p>{{ $details->room }}</p>
                </div>
            </div>
            
            @isset($showButton)
            <form action="" method="POST"> 
                @csrf
                <input type="text" class="hidden" name="eventTitle" value="{{ $details->title }}">
                <button type="submit" class="focus:ring-0   border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                    <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500 group-hover:font-bold">view Campaigns</span>
                </button>
            </form>
            @endisset
        </div>
    </main>
    @endisset


    @include('footer')
@endsection
