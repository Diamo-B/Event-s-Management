@extends('app')


@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/login.css') }}">
@endsection


@section('content')
    <main>
        <section class="container">
            <p class="Title">Sign in</p>
            <p class="Info">Sign in and start managing your events!</p>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <input type="email" class="emailField" placeholder="Email" name="email" autocomplete="off">
                <input type="password" class="passField" placeholder="Password" name="password">
                <div class="options">
                    <input type="checkbox" name="rememberUser"
                        style="display: inline-block; position: relative; top: 2px; left: 4px;">
                    <p>Remember me</p>
                    <a href="">Forgot password</a>
                </div>
                <button type="submit" class="loginButton">Login</button>
            </form>

        </section>
    </main>
    <footer>
        <img src="{{ URL::asset('svg/bigVector.svg') }}" alt="bigVector" class="footer">
    </footer>
@endsection
