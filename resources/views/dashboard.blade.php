@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/coordDashboard.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
@endsection


@section('content')
  @include('navbar')

    @if ( $role == 1)
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
        
                  <button class="buttons" style="margin-top: 5px;">
                    View Invitations Status
                  </button>
              </div>
      
            </section>
      
            <section class="container" style="left: 1005px; top: 190px">
              <div class="containerTitle" style="top: 20px; left: 80px">Campaigns</div>
              <div class="buttonContainer">
                  <button class="buttons" style="margin-bottom: 18px;">
                      Create a New Campaign
                  </button>
        
                  <button class="buttons" style="margin-top: 5px;">
                        View Campaigns Status
                  </button>
              </div>
            </section>
        </main>
    @elseif( $role == 2)
        <!--TopManager's Dashboard-->
        <p>you are a TopManager</p>
    @elseif( $role == 3)
        <p>you are a Participant</p>
    @else
        <p>NO role was assigned to this user. Please contact an administrator</p>
    @endif 

    
  @include('footer')
@endsection