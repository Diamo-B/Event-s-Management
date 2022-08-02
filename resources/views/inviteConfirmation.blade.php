<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <title>Confirmation</title>
    <style>
        html,
        body {
            margin: 0px;
            height: 100%;
        }

        .grid {
            display: grid;
            justify-content: center;
            justify-items: center;
            align-items: center;
        }

        .box {
            background-color: #8ED2C2;
            position: absolute;
            top: 0px;
            right: 0px;
            bottom: 0px;
            left: 0px;
        }

        #lastbox {
            border: 4px solid white;
            padding: 10px;
            border-radius: 25px;
        }

        p {
            font-family: 'Ubuntu', sans-serif;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="box grid">
        <div class="grid" id="lastbox">
            <p>Thank you for accepting our invitation. see you there! &#128516;</p>
            <p>You can close this window</p>
        </div>
    </div>


</body>

</html>
