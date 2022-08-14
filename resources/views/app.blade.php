<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://kit.fontawesome.com/f6a25db151.js" crossorigin="anonymous"></script>
    @yield('css')
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body class="bg-white">

    @yield('content')
    @yield('scripts')
</body>

</html>
