@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">

    <style>
        .footer {
            top: 750px;
        }

        .footer p {
            top: 20px;
        }
    </style>
@endsection



@section('content')
    @include('navbar')
    <main>
        <form action="{{ route('invitation.store') }}" method="post" class="formCard" style="height: 600px;">
            @csrf
            <p class="header" style="width: 303px; left:216px;"> Create an Invitation</p><br><br>

            <div class="formBlock" style=" top: 50px;">
                <label for="Title" style="left: 45%">Title</label> <br>
                <input type="text" id="Title" name="Title" required autocomplete="off"> <br>
            </div>

            <div class="formBlock" style=" top: 50px;">
                <label for="Body" style="left: 45%">Body</label> <br>
                <textarea id="Body" name="Body" cols="66" rows="4" required autocomplete="off"></textarea>
            </div>

            <div class="formBlock" style="top:50px;">
                <label for="participants" style="left: 39%">Participants</label><br>
                <input type="file" name="excel" class="fileInput" id="participants">
            </div>

            <button type="submit" class="submit">Create</button>
        </form>
        <br><br>
    </main>
    @include('footer')
@endsection
