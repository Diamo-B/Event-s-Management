<style>
    *
    {
        all: unset;
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
<div style='text-align:center; background-color: rgb(129,140,248); padding-left:80px; padding-right:80px; padding-top:25px; padding-bottom:25px;'>

        <h1 style="color: white;">Invitation to the event:'{{ $eventData->title }}'</h1>
        <h3 style="color: rgb(165,243,252);">Invitation Status: {{ $CampaignStatus }}</h3>
        <div style="color: white;">
            <p>
                dear {{ $dataRecipient["title"] }} {{ $dataRecipient["firstName"] }},
            </p>
            <div>
                <p>{{ $invitationData->object }}</p><br>
                <h4 style="color: rgb(165,243,252);">The Event's objective:<br></h4>
                <p>{{ $eventData->object }}</p><br>
                <p>The event will take place in : {{ $eventData->location }},{{ $eventData->room }} <br>
                from: {{ $eventData->startingAt }} &rarr; Until {{ $eventData->endingAt }}</p>
            </div>
            <br>
            <p style='color:darkslateblue'><strong>To Accept the invitation please press the button below</strong></p>
            <a href="{{ route('AcceptInvite', $inviteToken) }}">
                <button
                style="
                all:unset;
                background-color: rgb(129,140,248);
                padding-top: 8px;
                padding-bottom: 8px; 
                padding-left: 20px;
                padding-right: 20px; 
                border: 2px solid white;
                border-radius: 15px;">
                    <span style="
                        all:unset;
                        color: white; 
                        font-weight: 700; 
                        text-align: center;"
                    >
                        Accept the invitation
                    </span>
                
                </button>
            </a>
            <p>
                See you there, <br>
                <strong style="color:indigo;">WebMaster</strong>
            </p>
        </div>
</div>
