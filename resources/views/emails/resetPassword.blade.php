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
    <h1>Password Reset</h1>
    <p>
        Hello,<br>
        We've recelved a request to reset the password for the account
        account associated with {{ $email }}. <br> No changes
        have been made to your account yet. <br>
        You can reset the password by clicking in the button below.
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
                Change Password
            </span>
        
        </button>
    </a>
    <br>
    <p>
        If you have a hard time clicking on the button you can use the following link: <br>
        <a href="{{ route('password.reset',$rememberPasswordToken) }}">http://127.0.0.1:8000/reset-password/{{ $rememberPasswordToken }}</a><br>
        If you did not request a new password, please let us know by replying to this email.
    </p>


</div>