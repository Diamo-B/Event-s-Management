@extends('app')

@section('scripts')
<script>
    function showPassChange($el) 
    {
        $el.classList.add('hidden');
        $panel = document.getElementById('changePass');
        $panel.classList.remove('hidden');  
    }
</script>
@endsection

@section('content')
    @include('navbar')
    <main class="grid  rounded-full justify-center align-middle mt-14 mb-28 mx-40">
        <div class="text-left py-5 w-96 px-5 shadow-2xl rounded-lg bg-indigo-400 text-white text-lg">
            <h1 class="text-center font-bold text-2xl mb-5">Change User's details</h1>
            <form action="{{ route('settings') }}" method="post">
                @csrf
                @method('POST')
                <label for="firstname" class="font-semibold">First Name</label><br>
                <input name="Fname" type="text" class="w-full rounded-xl text-gray-600 text-base font-medium placeholder:text-gray-400" placeholder={{ Auth::user()->firstName }}><br>
                <label for="lastName" class="font-semibold">Last Name</label><br>
                <input name="Lname" type="text" class="w-full rounded-xl text-gray-600 text-base font-medium placeholder:text-gray-400" placeholder={{ Auth::user()->lastName }}> <br>
                <label for="lang" class="font-semibold">Language</label><br>
            
                <select name="Lang" id="lang" class="text-gray-600 w-full rounded-xl mb-5 ">
                    <option value="" selected disabled hidden class="text-gray-400">Select a language</option>
                    <option value="en" class="bg-indigo-300 focus:bg-indigo-200 ">English</option>
                    <option value="fr" class="bg-indigo-300 focus:bg-indigo-200">Français</option>
                </select> <br>
                <a id="changePassTrigger" onclick="showPassChange(this)" class="text-center block text-white hover:text-gray-500"><i class="fa-solid fa-key"></i> Change Password</i></a>
                <button type="submit" name="submit" value="save" class="focus:ring-0 w-fit my-5 relative left-[25%] border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                    <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500 group-hover:font-bold">Save Settings</span>
                </button>
                <div id="changePass" class="hidden">
                    <label for="New" class="font-semibold">New Password</label><br>
                    <input name="New" type="password" class="w-full rounded-xl text-gray-600 text-base font-medium placeholder:text-gray-400"><br>
                    <label for="Confirm" class="font-semibold">Confirm Password</label><br>
                    <input name="Confirm" type="password" class="w-full rounded-xl text-gray-600 text-base font-medium placeholder:text-gray-400"><br>
                    <button type="submit" name = "submit" value="changePass" class="focus:ring-0 w-fit my-5 relative left-[20%] border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                        <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500 group-hover:font-bold">Change Password</span>
                    </button>
                </div>
            </form>
        </div>
    </main>
    @include('footer')
@endsection