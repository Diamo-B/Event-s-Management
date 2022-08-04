@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/container.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/details.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/confirmPresence.css') }}">
    <style>
        .Evtitle {
            margin: 10px;
            margin-top: 25px;
        }

        .DescText {
            color: white;
            font-size: 25px;
            margin-bottom: 20px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .confirm {
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #20DF7F;
            border: 2px solid white;
            color: white;
            font-size: 18px;
            border-radius: 25px;
        }

        .confirm:hover {
            background-color: white;
        }

        .confirm:hover span {
            color: #000031;
        }
    </style>
@endsection

@section('content')
    @include('navbar')
    @isset($events)
        <div class="Xcontainer">
            @if (session('error'))
                <div style="position: relative; top:49px; padding:1rem; margin-bottom: 1rem; font-size: 16px; font-weight: 700; border-radius: 25px; line-height: 1.25rem; --tw-text-opacity: 1; color:  rgba(185,28,28,var(--tw-text-opacity)); --tw-bg-opacity: 1; background-color:  rgba(254,226,226,var(--tw-bg-opacity)); text-align: center;"
                role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="bigBox">

                <div class="header">
                    <h1>Events</h1>
                    <h2>Choose an event</h2>
                </div>
                @if (isset($type) && $type == 'DataStat')
                    <form action="{{ route('showStats', ['type' => 'data']) }}" method="post">
                    @elseif (isset($type) && $type == 'HistoryStat')
                        <form action="{{ route('showStats', ['type' => 'history']) }}" method="post">
                        @else
                            <form action="" method="post">
                @endif

                @csrf
                <select name="Event">
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
                <br>
                @if (isset($type))
                    <button type="submit" class="button"><span>Show Event's Stats</span></button>
                @else
                    <button type="submit" class="button"><span>Show Event's Data</span></button>
                @endif

                </form>

            </div>

        </div>
    @endisset
    @isset($details)
        <div class="containerX">
            <div class="principle">

                <div class="section">
                    <h3 class="Title">Event Title</h3>
                    <p class="details">{{ $details->title }}</p>
                </div>

                <div class="section">
                    <h3 class="Title">Event Object</h3>
                    <p class="details">{{ $details->object }}</p>
                </div>

            </div>

            <div class="secondary">
                <div class="section">
                    <h3 class="Title">Starting At</h3>
                    <p class="details">{{ $details->startingAt }}</p>
                </div>

                <div class="section">
                    <h3 class="Title">Ending At</h3>
                    <p class="details">{{ $details->endingAt }}</p>
                </div>

                <div class="section">
                    <h3 class="Title">Location</h3>
                    <p class="details">{{ $details->location }}</p>
                </div>

                <div class="section">
                    <h3 class="Title">Room</h3>
                    <p class="details">{{ $details->room }}</p>
                </div>
            </div>
            <a href="{{ route('realTimeData', $details->id) }}" style="display: flex; flex-direction: row;flex-wrap: nowrap; justify-content: space-around; text-decoration:none;">
                <button class="del" style="width:200px; margin: 10px 0px; padding:10px;"><span>view Campaigns</span></button>
            </a>
        </div>
    @endisset
    @isset($campaignCount)
        <div class="Xcontainer">
            <div class="bigBox">
                <div class="header">
                    <h1>Event:</h1>
                    <h2 class="Evtitle">{{ $event['title'] }}</h2><br>
                </div>

                <div class="DescText">

                    @if ($campaignCount == 1)
                        <p> This Event has a single original campaign</p>
                    @elseif ($campaignRelaunchNumber > 0 && $campaignComplementNumber == 0)
                        <p>This Event has {{ $campaignCount }} campaigns:<br>one original campaign, and
                            {{ $campaignRelaunchNumber }}
                            @if ($campaignRelaunchNumber == 1)
                                relaunch
                            @else
                                relaunches
                            @endif
                        </p>
                    @else
                        <p>This Event has {{ $campaignCount }} campaigns:<br>one original campaign,
                            {{ $campaignRelaunchNumber }}
                            @if ($campaignRelaunchNumber == 1)
                                relaunch, and
                            @else
                                relaunches, and
                            @endif
                            {{ $campaignComplementNumber }}
                            @if ($campaignComplementNumber == 1)
                                complement.
                            @else
                                complements
                            @endif
                        </p>
                    @endif
                    <form method="POST" action="{{ route('realTimeData', $event['id']) }}">
                        @csrf
                        <button class="confirm" type="submit"><span>View Participants attendance</span></button>
                    </form>
                </div>
            </div>
        </div>
    @endisset

    @isset($data)
        <div class="Xcontainer">
            <table>
                <thead>
                    <tr>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col" style='width:200px;'>Email</th>
                        <th scope="col">Confirmed</th>
                        <th scope="col">Attended</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $cell)
                        <tr>
                            <td data-label="First name">{{ $cell['User']['firstName'] }}</td>
                            <td data-label="Last name">{{ $cell['User']['lastName'] }}</td>
                            <td data-label="Email">{{ $cell['User']['email'] }}</td>
                            @switch($cell['isConfirmed'])
                                @case(0)
                                    <td data-label="Confirmed">---</td>
                                @break

                                @case(1)
                                    <td data-label="Confirmed">X</td>
                                @break
                            @endswitch

                            @switch($cell['isPresent'])
                                @case(0)
                                    <td data-label="Attended">---</td>
                                @break

                                @case(1)
                                    <td data-label="Attended">X</td>
                                @break
                            @endswitch

                        </tr>
                    @endforeach
                    @foreach ($nonConfirmedData as $cell)
                        <tr>
                            <td data-label="First name">{{ $cell['firstName'] }}</td>
                            <td data-label="Last name">{{ $cell['lastName'] }}</td>
                            <td data-label="Email">{{ $cell['email'] }}</td>
                            <td data-label="Confirmed">---</td>
                            <td data-label="Attended">---</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endisset

    @include('footer')
@endsection
