<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
        <h1>Invitation to the event: '{{ $eventData->title }}'</h1>
        <h2>Invitation Status: {{ $CampaignStatus }}</h2>
        <p>
            dear {{ $dataRecipient["title"] }} {{ $dataRecipient["firstName"] }},
        </p>
        <p>
            {{ $invitationData->object }}
        </p>
        <br>
        <p>To Accept the invitation please press the button</p>
            <a href="{{ route('AcceptInvite', $inviteToken) }}"><button>Accept the invitation</button></a>
        <p>
            See you there, <br>
            <strong>WebMaster</strong>
        </p>
</body>

</html>
