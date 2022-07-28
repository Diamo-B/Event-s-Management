<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <header>
        <h1>Invitation to the event: '{{ $eventData->title }}'</h1>
        <h2>Invitation Status: {{ $CampaignStatus }}</h2>
    </header>
    <main>
        <p>
            dear {{ $dataRecipient["title"] }} {{ $dataRecipient["firstName"] }},
        </p>
        <p>
            {{ $invitationData->object }}
        </p>
        <br>
        <h4>Attachment:</h4>
        {{ $invitationData->attachment }}
    </main>
    <footer>
        <p>
            See you there, <br>
            <strong>WebMaster</strong>
        </p>

    </footer>
</body>

</html>
