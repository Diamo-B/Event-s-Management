<style>
        *
    {
        all: unset;
        font-size: 20px;
        color: black;
    }
    p
    {
        font-weight: 500;
    }
    button:hover
    {
        background-color: white;
    }

    button a
    {
        color:black;
    }
</style>
<div style='text-align:center; padding-left:80px; padding-right:80px; padding-top:25px; padding-bottom:25px;'>
    <h1>Invitation à l'événement:<br><span style="color: rgb(129,140,248);">{{ $eventData->title }}</span></h1>
    <h3 style="color: rgb(243, 33, 103); text-align:left;">État de l'invitation: @if ($CampaignStatus == "Original")
        Originale
    @elseif ($CampaignStatus == "Relanch")
        Relance
    @elseif ($CampaignStatus == "Complement")
        Complément
    @endif</h3>
    <div style='text-align:left;'>
        <p >
            Chér(e) {{ $dataRecipient["title"] }} {{ $dataRecipient["firstName"] }},
        </p>
        <div>
            <p>{{ $invitationData->object }}</p><br>
            <h3 style="color: rgb(243, 33, 103);">L'objectif de l'événement :<br></h3>
            <p>{{ $eventData->object }}</p>
            <p>L'événement aura lieu à: {{ $eventData->location }},{{ $eventData->room }} <br>
            À partir de: {{ $eventData->startingAt }} &rarr; Jusqu'a {{ $eventData->endingAt }}</p>
        </div>
    </div>
        <br>
    <div style='text-align:center;'>
        <p><strong>Pour accepter l'invitation, veuillez appuyer sur le bouton ci-dessous</strong></p>
        <a href="{{ route('AcceptInvite', $inviteToken) }}">
            <button
            style="
            all:unset;
            color: rgb(243, 33, 103);
            padding-top: 8px;
            padding-bottom: 8px; 
            padding-left: 20px;
            padding-right: 20px; 
            border: 2px solid rgb(194, 194, 194);
            border-radius: 15px;">
                <span style="
                    all:unset;
                    font-weight: 700; 
                    text-align: center;">
                    Accepter l'invitation
                </span>
            </button>
        </a>
        <p>
            On se voit là-bas, <br>
            <strong style="rgb(209, 0, 192);">WebMaster</strong>
        </p>
    </div>     
</div>
