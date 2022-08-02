@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/details.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/eventShow&search.css')}}">
@endsection

@section('navbar addition')
    @isset ($search)
        <form action="{{ route('event.search') }}" method="post">
            @csrf
            <input type="text" name="search" placeholder="Search an event by title or location" autocomplete="off"
                class="searchbar">
            <button type="submit" class="searchButton"><span>></span></button>
        </form>
    @endisset
@endsection

@section('content')
    @include('navbar')
    <main>

        <!-- -----------------------------------------     index      --------------------------------------------- -->
        @isset($events)
            <div class="container">

                @foreach ($events as $event)
                    <div class="card">
                        <div class="box">
                            <div class="content">
                                <h3>{{ Str::limit($event->title, 20, $end = '.......') }}</h3>
                                <p>{{ Str::limit($event->object, 100, $end = '.......') }}</p>
                                <a href="{{ route('event.show', $event->id) }}">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            @if ($events->hasPages())
                <div class="nextPrevious">
                    {{ $events->links() }}
                </div>
            @endif
        @endisset
        <!-- -----------------------------------------     Search    --------------------------------------------- -->
        @isset($foundEvent)
            <div class="container">
                @foreach ($foundEvent as $event)
                    <div class="card">
                        <div class="box">
                            <div class="content">
                                <h3>{{ $event->title }}</h3>
                                <p>{{ Str::limit($event->object, 100, $end = '....') }}</p>
                                <a href="{{ route('event.show', $event->id) }}">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($foundEvent->hasPages())
                <div class="nextPrevious">
                    {{ $foundEvent->links() }}
                </div>
            @endif
        @endisset

        <!-- -----------------------------------------     details    --------------------------------------------- -->
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
                        <form method="post" action="{{ route('event.destroy', $details->id) }}" style="position: relative; left: 50%; margin-top: 10px;">
                            @method('DELETE')
                            @csrf
                            <button class="del" type="submit"><span>Delete</span></button>
                          </form>
                    </div>
                </div>
            </div>
        @endisset

    </main>
    @include('footer')
@endsection
