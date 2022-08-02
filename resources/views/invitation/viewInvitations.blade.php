@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/container.css') }}">
    <style>

        .infoTable {
            margin: 20px;
            text-align: center;
        }

        table,
        th,
        td {
            border: 3px solid white;
            padding: 10px;
        }

        #header {
            color: #20DF7F;
            font-size: 20px;
        }

        .body {
            color: white;
            font-size: 20px;
        }

        .body a {
            text-decoration: underline;
            color: pink;
        }

        .del {
            color: white;
            font-size: 15px;
            border: 3px solid white;
            margin-bottom: 20px;
            padding: 10px 50px;
            border-radius: 20px;
            font-weight: 700;
            background-color: #15f082;
        }

        .del:hover {
            background: white;
        }

        .del:hover span {
            color: #232427;
        }
    </style>
@endsection

@section('content')
    @include('navbar')

    <main class="Xcontainer">
        <div class="bigBox">
            @isset($events)
                <div class="header">
                    <h1>Events</h1>
                    <h2>Choose an event</h2>
                </div>
                <form action="{{ route('invitation.index') }}" method="post">
                    @csrf
                    <select name="Events">
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                    <br>
                    <button type="submit" class="button"><span>Find Invitation</span></button>
                </form>
            @endisset
            @isset($invitation)
                <table class="infoTable">
                    <tr id="header">
                        <th>Event</th>
                        <th>Object</th>
                        <th>Attachment</th>
                    </tr>

                    <tr class="body">
                        <td>{{ $event['title'] }}</td>
                        <td>{{ $invitation['object'] }}</td>
                        <td>
                            <a href="{{ route('download.attachment', ['attachment' => $invitation['attachmentName']]) }}">
                                {{ $invitation['attachmentName'] }}
                            </a>
                        </td>
                    </tr>
                </table>
                <form action="{{ route('invitation.delete', ['id' => $invitation['id']]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="del"><span>Delete</span></button>
                </form>
            @endisset
        </div>
    </main>
    @include('footer')
@endsection
