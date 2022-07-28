@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">

    <style>
        .footer {
            top: 800px;
        }

        .footer p {
            top: 20px;
        }
    </style>
@endsection



@section('content')
    @include('navbar')
    <main>
        <form action="{{ route('invitation.store') }}" method="post" enctype="multipart/form-data" class="formCard" style="height: 650px;">
            @csrf
            <p class="header" style="width: 303px; left:216px;"> Create an Invitation</p><br><br>

            <div class="formBlock" style="top:50px;">
                <label for="Event" style="left: 43.5%">Event</label><br>
                <select name="Event" id="Event" name="Event" style="text-align: center;">
                @foreach ($events as $event)
                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                @endforeach
                </select>
            </div>

            <div class="formBlock" style=" top: 50px;">
                <label for="Body" style="left: 45%">Body</label> <br>
                <textarea id="Body" name="Body" cols="66" rows="4" required autocomplete="off"></textarea>
            </div>

            <div class="formBlock" style="top:50px;">
                <label for="attachment" style="left: 39%">attachment</label><br>
                <input type="file" name="attachment" id="attachment">
            </div>

            <button type="submit" class="submit">Create</button>
        </form>
        <br><br>
    </main>
    @include('footer')
@endsection
