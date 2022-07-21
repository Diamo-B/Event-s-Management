@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;800&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            min-height: 100vh;
            background: #232427;
        }

        body .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 40px 0;
        }

        body .container .card {
            position: relative;
            min-width: 320px;
            height: 440px;
            box-shadow: inset 5px 5px 5px rgba(0, 0, 0, 0.2),
                inset -5px -5px 15px rgba(255, 255, 255, 0.1),
                5px 5px 15px rgba(0, 0, 0, 0.3), -5px -5px 15px rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            margin: 30px;
            transition: 0.5s;
        }

        body .container .card:nth-child(1) .box .content a {
            background: #20DF7F;
        }

        body .container .card:nth-child(2) .box .content a {
            background: #20DF7F;
        }

        body .container .card:nth-child(3) .box .content a {
            background: #20DF7F;
        }

        body .container .card .box {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            background: #3B5B75;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            transition: 0.5s;
        }

        body .container .card .box:hover {
            transform: translateY(-50px);
        }

        body .container .card .box:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background: rgba(255, 255, 255, 0.03);
        }

        body .container .card .box .content {
            padding: 20px;
            text-align: center;
        }

        body .container .card .box .content h2 {
            position: absolute;
            top: -10px;
            right: 30px;
            font-size: 8rem;
            color: rgba(255, 255, 255, 0.1);
        }

        body .container .card .box .content h3 {
            font-size: 1.8rem;
            color: #fff;
            z-index: 1;
            transition: 0.5s;
            margin-bottom: 15px;
        }

        body .container .card .box .content p {
            font-size: 1rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.9);
            z-index: 1;
            transition: 0.5s;
        }

        body .container .card .box .content a {
            position: relative;
            display: inline-block;
            padding: 8px 20px;
            background: black;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            margin-top: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: 0.5s;
        }

        body .container .card .box .content a:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6);
            background: #fff;
            color: #000;
        }

        .nextPrevious {
            position: absolute;
            top: 560px;
            left: 1210px;
        }

        .nextPrevious a {
            text-decoration: none;
            color: #0088ff;
        }

        .searchbar
        {
            color: white;
            font-family: 'ubuntu';
            font-weight: 200;
            position: relative;
            width: 260px;
            height: 30px;
            left: 40.5%;
            top: 20px;
            background-color: #3B5B75;
            text-align: center;
            border: 1px solid white;
            border-radius:5px;
        }
        .searchbar::placeholder
        {
            color: rgba(255, 255, 255, 0.548);
        }
        .searchButton
        {
            color: white;
            position: relative;
            top: 20px;
            left: 41%;
            border: 1px solid white;
            width:30px;
            border-radius: 20px;
            background-color: #15f082; 
        } 
        .searchButton:hover 
        {
            background: white;           
        }
        .searchButton:hover span
        {
            color:#232427;
        }
    </style>
@endsection

@section('navbar addition')
<form action="{{ route('event.search') }}" method="post">
    @csrf
    <input type="text" name="search"  placeholder="Search an event by title or location" autocomplete="off" class="searchbar">
    <button type="submit" class="searchButton"><span>></span></button>
</form>   
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
                            <h3>{{ $event->title }}</h3>
                            <p>{{ Str::limit($event->object, 100, $end='.......') }}</p>
                            <a href="{{ route('event.show',$event->id) }}">Read More</a>
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
                                <p>{{ Str::limit($event->object, 100, $end='....') }}</p>
                                <a href="{{ route('event.show',$event->id) }}">Read More</a>
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
            <div class="container">
                <div class="card" style="background:#3B5B75; color:white;">
                    <div class="content" style="text-align:center;" >
                        <div style="border:5px solid #3c5f7c; border-radius:10px; background-color:#374755; padding:5px 0px">
                            <h3>{{ $details->title }}</h3>
                        </div>
                        
                        <div style="border:5px solid #3c5f7c; background-color:#374755; padding:5px 0px">
                            <p>{{ $details->object }}</p>
                        </div>

                        <div style="border:5px solid #3c5f7c; border-radius:10px; background-color:#374755; padding:5px 0px">
                            <h3>Starting At: <br> {{ $details->startingAt }} <br> Ending At: <br> {{ $details->endingAt }}</h3>
                        </div>

                        <div style="border:5px solid #3c5f7c; border-radius:10px; background-color:#374755; padding:5px 0px">
                            <h3>Location: {{ $details->location }}</h3>    
                        </div>
                        <div style="border:5px solid #3c5f7c; border-radius:10px; background-color:#374755; padding:5px 0px">
                            <h3>Room: {{ $details->room }}</h3> 
                        </div>
                    </div>    
                </div>
                <br><br> 
            </div>
        @endisset
    
    </main>
    @include('footer')
@endsection
