@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    
    <style>
        .footer
        {
            top: 700px;
        }
    </style>
@endsection


@section('content')
    @include('navbar')
    <main>
        <form action="{{ route('campaign.store') }}" method="post" enctype="multipart/form-data" class="formCard"  style="height:550px;">
            @csrf
            <p class="header" style="width: 485px; left:224px;"> Create a Campaign </p><br><br>

            <div class="formBlock" style="top:50px;">
                <label for="event" style="left: 43%;">Event</label><br>
                <select name="event" id="event" > 
                @if (isset($event))
                <option value="{{ $event->id }}">{{ $event->title }}</option>
                @else
                     @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                @endif
                </select>        
            </div>

            <div class="formBlock" style="top:50px;">
                <label for="status" style="left: 43%;">Status</label><br>
                <select name="status" id="status">
                    <option value="Original">Original</option>
                    <option value="Relanch">Relaunch</option>
                    <option value="Complement">Complement</option>
                </select>        
            </div>

            <div class="formBlock" style="top:50px;">
                <label for="participants" style="left: 39%">Participants</label><br>
                <input type="file" name="participants" id="participants">
            </div>

            <button type="submit" class="submit">Send</button>
        </form>
    </main>
    @include('footer')
@endsection