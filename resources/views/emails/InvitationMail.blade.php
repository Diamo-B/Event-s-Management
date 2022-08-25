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

        <h1>Invitation to the event:<br><span style="color: rgb(129,140,248);">{{ $eventData->title }}</span></h1>
        <h3 style="color: rgb(243, 33, 103); text-align:left;">Invitation Status: {{ $CampaignStatus }}</h3>
        <div style='text-align:left;'>
            <p >
                dear {{ $dataRecipient["title"] }} {{ $dataRecipient["firstName"] }},
            </p>
            <div>
                <p>{{ $invitationData->object }}</p><br>
                <h3 style="color: rgb(243, 33, 103);">The Event's objective:<br></h3>
                <p>{{ $eventData->object }}</p>
                <p>The event will take place in : {{ $eventData->location }},{{ $eventData->room }} <br>
                from: {{ $eventData->startingAt }} &rarr; Until {{ $eventData->endingAt }}</p>
            </div>
        </div>
            <br>
        <div style='text-align:center;'>
            <p><strong>To Accept the invitation please press the button below</strong></p>
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
                        text-align: center;"
                    >
                        Accept the invitation
                    </span>
                
                </button>
            </a>
            <p>
                See you there, <br>
                <strong style="rgb(209, 0, 192);">WebMaster</strong>
            </p>
        </div>
            
        
</div>
