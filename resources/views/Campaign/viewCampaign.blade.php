        @extends('app')

        @section('content')
            @include('navbar')
            <main class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] ">
                @isset($CampaignsCount)
                <div class="flex text-center rounded-full w-full justify-center ">
                    <div class="bg-indigo-400 py-10  border-4 border-indigo-500 rounded-lg  ">
                        
                        <label for="Event" class="text-center text-3xl text-white font-bold">Event</label>
                        <h3 class="mb-5 text-xl text-gray-500 font-semibold">{{ $event['title'] }}</h3>
                        
                        <div class="w-full mb-5 px-7 text-lg text-white font-semibold">
                            @if ($CampaignsCount == 0)
                            <p class='w-30'> This Event has no campaigns</p>
                            @elseif ($CampaignsCount == 1)
                                <p> This Event has a single original campaign</p>
                            @elseif ($CampaignRelaunchesNumber > 0 && $CampaignComplementsNumber == 0)
                                <p>This Event has {{ $CampaignsCount }} campaigns:<br>one original campaign, and
                                {{ $CampaignRelaunchesNumber }}
                                @if ($CampaignRelaunchesNumber == 1)
                                    relaunch
                                @else
                                    relaunches
                                @endif
                                </p>
                            @else
                                <p>This Event has {{ $CampaignsCount }} campaigns:<br>one original campaign,
                                {{ $CampaignRelaunchesNumber }}
                                @if ($CampaignRelaunchesNumber == 1)
                                    relaunch, and
                                @else
                                    relaunches, and
                                @endif
                                {{ $CampaignComplementsNumber }}
                                @if ($CampaignComplementsNumber == 1)
                                    complement.
                                @else
                                    complements
                                @endif
                                </p>
                            @endif
                            <br>
                            @if ($stop == true)
                                <p>where all the users were confirmed as present</p>
                            @endif
                        </div>

                        
                        
                        @if ($CampaignsCount != 0)
                            @if(isset($viewData))
                                <form method="POST"
                                action="{{ route('realTimeData', ['eventId' => $event['id']]) }}">
                                @csrf
                                <button type="submit" class="focus:ring-0 border-4 border-white rounded-3xl mx-5 px-8 py-1 hover:bg-white group  ">
                                    <span class="text-center text-white text-lg font-bold group-hover:text-indigo-500 group-hover:font-bold">view participants attandance</span>
                                </button>
                            @elseif (!isset($viewData) && $stop == false)
                                <form method="POST"
                                action="{{ route('presenceConfirm', ['eventId' => $event['id'], 'campaigns' => $Campaigns->toJson(JSON_PRETTY_PRINT)]) }}">
                                @csrf
                                <button type="submit" class="focus:ring-0 border-4 border-white rounded-3xl mx-5 px-8 py-1 hover:bg-white group  ">
                                    <span class="text-center text-white text-lg font-bold group-hover:text-indigo-500 group-hover:font-bold">Confirm participants attandance</span>
                                </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
                
                @endisset

                @if(isset($users) or isset($viewusers))
                    @isset($users)
                        <form action="{{ route('presenceConfirm', ['eventId' => $eventId]) }}" method="post">
                        @csrf
                    @endisset
                    
                        <div class="grid justify-items-center mt-48 mb-20">
                            <div class="overflow-x-auto mb-5 relative shadow-2xl  sm:rounded-lg">
                                <table class="w-full text-base text-center  text-gray-500">
                                    <thead class="text-sm text-gray-700 bg-indigo-400 ">
                                        <tr>
                                            <th scope="col" class="py-3">
                                                First Name
                                            </th>
                                            <th scope="col" class="py-3">
                                                Last Name
                                            </th>
                                            <th scope="col" class="py-3 px-8">
                                                Email
                                            </th>
                                            @isset($viewusers)
                                                <th scope="col" class="py-3 px-6">
                                                    hasConfirmed
                                                </th>
                                            @endisset
                                            <th scope="col" class="py-3 px-6">
                                                isPresent
                                            </th>
                                            <!--------------------------------------------------------------------->
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @if(isset($users))
                                            @foreach ($users as  $user)
                                                <tr class="bg-white border-b hover:bg-indigo-300 hover:text-white group">
                                                    <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                        {{ $user['firstName'] }}
                                                    </td>
                                                    <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                        {{ $user['lastName'] }}
                                                    </td>
                                                    <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                        {{ $user['email'] }}
                                                    </td>
                                                    
                                                    <td scope="row" class="py-4 px-6 align-center font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                        <input type="checkbox" name="presentUserIds[]" value="{{ $user['id'] }}" class=" text-indigo-500 bg-gray-100 rounded border-gray-300">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @elseif(isset($viewusers))
                                            @foreach ($viewusers as  $user)
                                                <tr class="bg-white border-b hover:bg-indigo-300 hover:text-white group">
                                                    <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                        {{ $user['User']['firstName'] }}
                                                    </td>
                                                    <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                        {{ $user['User']['lastName'] }}
                                                    </td>
                                                    <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                        {{ $user['User']['email'] }}
                                                    </td>
                                                    
                                                    <!--only in view attandance data and remove the button at the end-->
                                                    <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                        @if ($user['isConfirmed'] == 1)
                                                            &#10003;
                                                        @else
                                                            ----
                                                        @endif
                                                    </td>
                        
                                                    <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                        @if ($user['isPresent'] == 1)
                                                            &#10003;
                                                        @else
                                                            ----
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @isset($nonConfirmedData)
                                                @foreach ($nonConfirmedData as  $user)
                                                    <tr class="bg-white border-b hover:bg-indigo-300 hover:text-white group">
                                                        <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                            {{ $user['firstName'] }}
                                                        </td>
                                                        <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                            {{ $user['lastName'] }}
                                                        </td>
                                                        <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                            {{ $user['email'] }}
                                                        </td>
                                                        
                                                        <!--only in view attandance data and remove the button at the end-->
                                                        <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                            ----
                                                        </td>
                            
                                                        <td scope="row" class="py-4 px-6 font-medium text-gray-700 group-hover:text-white whitespace-nowrap ">
                                                            ----
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                        @endif  
                                    </tbody>
                                </table>
                            </div>
                            @isset($users)
                            <button type="submit" class="w-fit border-4 border-gray-300 rounded-3xl px-8 py-1 hover:bg-indigo-400 group  ">
                                <span class="text-center text-gray-500 text-lg font-bold  group-hover:text-white">Confirm Attandance</span>
                            </button>
                            @endisset
                        </div>
                    @isset($users)
                        </form>
                    @endisset
                @endif
            </main>
        
            @include('footer')
        @endsection

