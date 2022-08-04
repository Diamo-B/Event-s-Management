@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/container.css') }}">
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
    <main class="Xcontainer">
        @isset($events)
            <div class="bigBox">
                
                <div class="header">
                    <h1>Events</h1>
                    <h2>Choose an event</h2>
                </div>
                <form action="{{ route('campaign.view') }}" method="post">
                    @csrf
                    <select name="Event">
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                    <br>
                    <button type="submit" class="button"><span>Show Event Campaigns</span></button>
                </form>

            </div>
        @endisset

        @isset($CampaignsCount)
            <div class="bigBox">

                <div class="header">
                    <h1>Event:</h1>
                    <h2 class="Evtitle">{{ $event['title'] }}</h2><br>
                </div>

                <div class="DescText">

                    @if ($CampaignsCount == 1)
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
                    <form method="POST"
                        action="{{ route('presenceConfirm', ['eventId' => $event['id'], 'campaigns' => $Campaigns->toJson(JSON_PRETTY_PRINT)]) }}">
                        @csrf
                        <button class="confirm" type="submit"><span>confirm Participants attandance</span></button>
                    </form>

                </div>

            </div>
        @endisset

        @isset($users)
            <form action="{{ route('presenceConfirm', ['eventId' => $eventId]) }}" method="post">
                @csrf
                <table>
                    <thead>
                        <tr>
                            <th scope="col">First name</th>
                            <th scope="col">Last name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Is present</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td data-label="First name">{{ $user['firstName'] }}</td>
                                <td data-label="Last name">{{ $user['lastName'] }}</td>
                                <td data-label="Email">{{ $user['email'] }}</td>
                                <td data-label="Is present"><input type="checkbox" name="presentUserIds[]"
                                        value="{{ $user['id'] }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="confirm"
                    style="padding-left: 50px; padding-right: 50px;"><span>Confirm</span></button>
            </form>
        @endisset
    </main>
    @include('footer')
@endsection
