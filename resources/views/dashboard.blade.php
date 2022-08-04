@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/coordDashboard.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
@endsection


@section('content')
  @include('navbar')
    @if ($role == 1)
        <!--Coordinator's Dashboard-->
        <main>
            <section class="container" style="left: 81px; top: 190px">
                <div class="containerTitle" style="top: 20px; left: 105px">Events</div>

                <div class="buttonContainer">

                    <a href="{{ route('event.create') }}"><button class="buttons" style="margin-bottom: 18px;">
                            Create a New Event
                        </button></a>

                    <a href="{{ route('event.index') }}"><button class="buttons" style="margin-top: 5px;">
                            View Events Information
                        </button></a>

                </div>

            </section>

            <section class="container" style="left: 543px; top: 190px">
                <div class="containerTitle" style="top: 20px; left: 83px">Invitations</div>

                <div class="buttonContainer">
                    <a href="{{ route('invitation.create') }}"><button class="buttons" style="margin-bottom: 18px;">
                            Create an Invitation Model
                        </button></a>

                    <a href="{{ route('invitation.index') }}"><button class="buttons" style="margin-top: 5px;">
                            View Invitations Status
                        </button></a>
                </div>

            </section>

            <section class="container" style="left: 1005px; top: 190px">
                <div class="containerTitle" style="top: 20px; left: 80px">Campaigns</div>
                <div class="buttonContainer">
                    <a href="{{ route('campaign.create') }}"><button class="buttons" style="margin-bottom: 18px;">
                            Create a New Campaign
                        </button></a>

                    <a href="{{ route('campaign.view') }}"><button class="buttons" style="margin-top: 5px;">
                            View Campaigns Status
                        </button></a>
                </div>
            </section>
        </main>
    @elseif($role == 2)
        <!--TopManager's Dashboard-->
      
        <section class="container" style="position: absolute;top: 50%;left: 35%;transform: translate(-50%, -50%);">
            <div class="containerTitle" style="top: 20px; left: 95.5px">Options</div>
            <div class="buttonContainer">
              @method('get')
              <a href="{{ route('realTimeData') }}"><button class="buttons" style="margin-bottom: 18px;">
                      View Real Time Data
                  </button></a>

              <a href="{{ route('history') }}"><button class="buttons" style="margin-top: 5px;">
                      View Event History
                  </button></a>

            </div>
        </section>

        <section class="container" style="position: absolute;top: 50%;left: 65%;transform: translate(-50%, -50%);">
            <div class="containerTitle" style="top: 20px; left: 95.5px">Statistics</div>
            <div class="buttonContainer">
              <a href="{{ route('DataStats') }}"><button class="buttons" style="margin-bottom: 18px;">
                      View Real Time Stats
                  </button></a>

              <a href="{{ route('HistoryStats') }}"><button class="buttons" style="margin-top: 5px;">
                    View History Stats 
                  </button></a>

            </div>
        </section>
    @else
        <p>NO role was assigned to this user. Please contact an administrator</p>
    @endif
  @include('footer')
@endsection
