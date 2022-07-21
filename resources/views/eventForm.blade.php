@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}">
    <style>
        .footer {
            top: 1300px;
        }

        .footer p {
            top: 10px;
        } 
    </style>
@endsection

@section('content')
    @include('navbar')
    <main>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>@dd($error)</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('event.store') }}" method="POST" class="formCard">
            @csrf
            <p class="header"> Create an event</p><br><br>

            <div class="formBlock" style=" top: 50px;">
                <label for="Title" style="left: 45%">Title</label> <br>
                <input type="text" id="Title" name="Title" required autocomplete="off"> <br>
            </div>

            <div class="formBlock" style=" top: 50px;">
                <label for="Object" style="left: 43.5%">Object</label> <br>
                <textarea id="Object" name="Object" cols="66" rows="2" required autocomplete="off"></textarea>
            </div>

            <div class="formBlock" style=" top: 50px;">
                <label for="Start" style="left: 39%">Starting At</label> <br>
                <input type="date" name="Starting_date" id="Start" required><input type="time"
                    name="Starting_time"id="Start" required autocomplete="off">
            </div>

            <div class="formBlock" style="top: 50px;">
                <label for="End" style="left: 40%">Ending At</label><br>
                <input type="date" name="Ending_date" id="End" required><input type="time" name="Ending_time"
                    id="End" required autocomplete="off">
            </div>

            <div class="formBlock" style="top:50px;">
                <label for="location" style="left: 41%">Location</label><br>
                <select name="location" id="location" required autocomplete="off">
                    <option value="">----------</option>
                    <option value="amdlRabat">Amdl Rabat</option>
                    <option value="Tokyo">Tokyo</option>
                    <option value="Berlin">Berlin</option>
                    <option value="Frankfurt">Frankfurt</option>
                </select>
            </div>

            <div class="formBlock" style=" top: 50px;">
                <label for="room" style="left: 43.5%">Room</label> <br>
                <input type="text" id="room" name="room" required autocomplete="off">
            </div>
            <input type="submit" value="create" class="submit">
        </form>
    </main>
    @include('footer')
@endsection
