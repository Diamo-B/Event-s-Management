@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/circleDiagrams.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
@endsection

@section('content')
    @include('navbar')

    <!-- Section: Design Block -->
    <div class="container absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] grid grid-cols-3 justify-center gap-4 px-2">
        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-sm">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden text-center">
                        <h3 class="relative top-5 text-center font-bold text-orange-500">Invited Users</h3>
                        <p class="text-5xl mt-8 font-bold text-teal-500">{{ $invitedUsersCount }} </p> 
                        <p class="text-base mt-3 mb-8 font-bold text-gray-400">from {{ count($participantIds) }} users with participant role</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-sm">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden text-center">
                        <h3 class="relative top-5 text-center font-bold text-orange-500">Confirmed Users</h3>
                        <p class="text-5xl mt-8 font-bold text-teal-500">{{ $acceptedUsersCount }} </p> 
                        <p class="text-base mt-3 mb-8 font-bold text-gray-400">from {{ $invitedUsersCount }} invited users</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-sm">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden text-center">
                        <h3 class="relative top-5 text-center font-bold text-orange-500">Attanded Users</h3>
                        <p class="text-5xl mt-8 font-bold text-teal-500">{{ $attendedUsersCount }} </p> 
                        <p class="text-base mt-3 mb-8 font-bold text-gray-400">from {{ $acceptedUsersCount  }} confirmed users</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-sm">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                        <h3 class="relative top-5 text-center font-bold text-orange-500">Invitation Rate</h3>
                        <h4 class="relative top-6 text-center font-bold text-gray-400">Invited users against all the participant role </h4>
                        <div class="circleDiv">
                            <div class="circle-diagram" style="--percent: {{ round($userInvitationRate,PHP_ROUND_HALF_UP) }}">
                                <p class="statText">{{ round($userInvitationRate,PHP_ROUND_HALF_UP) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-sm">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                        <h3 class="relative top-5 text-center font-bold text-orange-500">Confirmation Rate</h3>
                        <h4 class="relative top-6 text-center font-bold text-gray-400">Confirmed users against all the invited ones </h4>
                        <div class="circleDiv">
                            <div class="circle-diagram" style="--percent: {{ round($invitationConfirmationRate,PHP_ROUND_HALF_UP) }}">
                                <p class="statText">{{ round($invitationConfirmationRate,PHP_ROUND_HALF_UP) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-3xl">
            <div class="w-full mt-1">
                <div class="rounded-lg shadow-sm">
                    <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                        <h3 class="relative top-5 text-center font-bold text-orange-500">Attandance Rate</h3>
                        <h4 class="relative top-6 text-center font-bold text-gray-400">Users attanding the event against the invited users</h4>
                        <div class="circleDiv">
                            <div class="circle-diagram" style="--percent: {{ round($eventAttendanceRate,PHP_ROUND_HALF_UP) }}">
                                <p class="statText">{{ round($eventAttendanceRate,PHP_ROUND_HALF_UP) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
</script>

<script src='https://unpkg.co/gsap@3/dist/gsap.min.js'></script>
<script src="{{ URL::asset('js/Animationscript.js') }}"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LLWL5N9CSM"></script>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}
gtag('js', new Date());
gtag('config', 'G-LLWL5N9CSM');
</script>
@endsection
