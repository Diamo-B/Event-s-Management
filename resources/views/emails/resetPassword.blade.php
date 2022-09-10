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
    <h1>Réinitialiser le mot de passe</h1>
    <p>
        Bonjour,<br>
        Nous avons reçu une demande de réinitialisation du mot de passe du compte
        associé à {{ $email }}. <br> Aucun changement
        n'a encore été effectué sur votre compte. <br>
        Vous pouvez réinitialiser le mot de passe en cliquant sur le bouton ci-dessous.
    </p>

    <a href="{{ route('password.reset',$rememberPasswordToken) }}">
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
                text-align: center;">
                Changer le Mot de passe
            </span>
        
        </button>
    </a>
    <br>
    <p>
        Si vous avez du mal à cliquer sur le bouton vous pouvez utiliser le lien suivant: <br>
        <a href="{{ route('password.reset',$rememberPasswordToken) }}">http://127.0.0.1:8000/reset-password/{{ $rememberPasswordToken }}</a><br>
        Si vous n'avez pas demandé de nouveau mot de passe, veuillez nous en informer en répondant à cet e-mail.
    </p>


</div>