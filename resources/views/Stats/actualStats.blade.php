@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/circleDiagrams.css') }}">
@endsection
@section('navbarAdd')
    @isset($search)
    <div class="relative  w-[40%] self-center right-12 ">
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
                            <p class="inline-block col-span-4 ">Latest events</p>
                            <input name="SearchCrit" type="checkbox" value="latest" class="inline-block col-span-1 text-indigo-500 bg-gray-100 rounded border-gray-300" onclick="checkboxChange(this)"></input>
                        </div>
                        <div class="border-y-2 col-span-5  border-solid border-white w-full flex space-x-4 justify-between px-5 h-fit py-2">
                            <p class="inline-block col-span-4 ">Events With Campaigns</p>
                            <input name="SearchCrit" type="checkbox" value="Camp" class="inline-block col-span-1 text-indigo-500 bg-gray-100 rounded border-gray-300" onclick="checkboxChange(this)"></input>
                        </div>
                        <div class="border-t-2 border-b-4 col-span-5  border-solid border-white w-full flex space-x-4 justify-between px-5 h-fit py-2">
                            <p class="inline-block col-span-4 ">Events Without Campaigns</p>
                            <input name="SearchCrit" type="checkbox" value="NoCamp" class="inline-block col-span-1 text-indigo-500 bg-gray-100 rounded border-gray-300" onclick="checkboxChange(this)"></input>
                        </div>
                        <div class="mt-2 col-span-5  border-solid border-white w-full flex justify-center px-5 h-fit py-2">
                            <button name="submit" value="filter" type="submit" class="col-span-5 w-fit text-center  border-4 border-white rounded-3xl px-10 py-1 hover:bg-indigo-200 group ">
                                <span class="text-center text-gray-800 text-md font-bold  group-hover:text-white">Filter</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- alphabetical order A to Z -->
                <button name="submit" value="orderDesc" id="orderAsc" type="submit" onclick='alphaOrder(this)' class="text-black absolute left-[98%] bottom-1 bg-white border-2 border-white  hover:bg-indigo-400 hover:text-white font-medium rounded-lg text-sm px-4 py-1">
                    <i class="fa-solid fa-arrow-down-a-z"></i>
                </button>

                <!-- alphabetical order Z to A -->
                <button name="submit" value="orderAsc" id="orderDesc" type="submit" onclick='alphaOrder(this)' class="text-black absolute left-[109%] bottom-1 bg-white border-2 border-white hover:bg-indigo-400 hover:text-white font-medium rounded-lg text-sm px-4 py-1">
                    <i class="fa-solid fa-arrow-up-a-z"></i>
                </button>

                <input type="hidden" name="events" value="{{ json_encode($events) }}">
            </form>
        </div>
                
    </div>
    
    @endisset
@endsection


@section('content')
    @include('navbar')

    <!-- Section: Design Block -->
    <div class="container absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] grid grid-cols-3 justify-center gap-4 px-2">
        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-2xl">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                        <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Invited Users</h3>
                        <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $invitedUsersCount }} </p> 
                        <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">from {{ count($participantIds) }} users with participant role</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-2xl">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                        <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Confirmed Users</h3>
                        <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $acceptedUsersCount }} </p> 
                        <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">from {{ $invitedUsersCount }} invited users</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-2xl">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden text-center hover:bg-indigo-400 group">
                        <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Attanded Users</h3>
                        <p class="text-5xl mt-8 font-bold text-teal-500 group-hover:text-pink-300">{{ $attendedUsersCount }} </p> 
                        <p class="text-base mt-3 mb-8 font-bold text-gray-400 group-hover:text-white">from {{ $acceptedUsersCount  }} confirmed users</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-2xl">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden hover:bg-indigo-400 group">
                        <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Invitation Rate</h3>
                        <h4 class="relative top-6 text-center font-bold text-gray-400 group-hover:text-white">Invited users against all the participant role </h4>
                        <div class=" each flex justify-center mt-10 mb-8">
                            <div class="flex items-center justify-center circular-progress relative h-32 w-32 rounded-full" onclick="animateCircle(this)">
                                <input class="percentEnd" type="hidden" value="{{ round($userInvitationRate,0,PHP_ROUND_HALF_UP) }}">
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
                        <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Confirmation Rate</h3>
                        <h4 class="relative top-6 text-center font-bold text-gray-400 group-hover:text-white">Confirmed users against all the invited ones </h4>
                        <div class="each flex justify-center mt-10 mb-8">
                            <div class="flex items-center justify-center circular-progress relative h-32 w-32 rounded-full" onclick="animateCircle(this)">
                                <input class="percentEnd" type="hidden" value="{{ round($invitationConfirmationRate,0,PHP_ROUND_HALF_UP) }}">
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
                        <h3 class="relative top-5 text-center font-bold text-orange-500 group-hover:text-white">Attandance Rate</h3>
                        <h4 class="relative top-6 text-center font-bold text-gray-400 group-hover:text-white">Users attanding the event against the invited users</h4>
                        <div class="each flex justify-center mt-10 mb-8"> 
                            <div class="flex items-center justify-center circular-progress relative h-32 w-32 rounded-full" onclick="animateCircle(this)">
                                <input class="percentEnd" type="hidden" value="{{ round($eventAttendanceRate,0,PHP_ROUND_HALF_UP) }}">
                                <span class="progress-value text-indigo-500 relative text-xl font-bold ">0%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection

@section('scripts')
<script src="{{ URL::asset('js/Animationscript.js') }}"></script>
@endsection
