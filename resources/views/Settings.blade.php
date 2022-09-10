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
            <h1 class="text-center font-bold text-2xl mb-5">Modifier les détails de l'utilisateur</h1>
            <form action="{{ route('settings') }}" method="post">
                @csrf
                @method('POST')
                <label for="firstname" class="font-semibold">Prénom</label><br>
                <input name="Fname" type="text" class="w-full rounded-xl text-gray-600 text-base font-medium placeholder:text-gray-400" placeholder={{ Auth::user()->firstName }}><br>
                <label for="lastName" class="font-semibold">Nom</label><br>
                <input name="Lname" type="text" class="w-full rounded-xl text-gray-600 text-base font-medium placeholder:text-gray-400" placeholder={{ Auth::user()->lastName }}> <br>
                <label for="lang" class="font-semibold">Langue</label><br>
            
                <select name="Lang" id="lang" class="text-gray-600 w-full rounded-xl mb-5 ">
                    <option value="" selected disabled hidden class="text-gray-400">Sélectionnez une langue</option>
                    <option value="en" class="bg-indigo-300 focus:bg-indigo-200 ">Anglais</option>
                    <option value="fr" class="bg-indigo-300 focus:bg-indigo-200">Français</option>
                </select> <br>
                <a id="changePassTrigger" onclick="showPassChange(this)" class="text-center block text-white hover:text-gray-500"><i class="fa-solid fa-key"></i>Changer le mot de passe</i></a>
                <div class="flex justify-center w-full m-0">
                    <button type="submit" name="submit" value="save" class="focus:ring-0 w-fit my-5 relative border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                        <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500 group-hover:font-bold">Enregistrer les modifications</span>
                    </button>
                </div>
                <div id="changePass" class="hidden">
                    <label for="New" class="font-semibold">Nouveau mot de passe</label><br>
                    <input name="New" type="password" class="w-full rounded-xl text-gray-600 text-base font-medium placeholder:text-gray-400"><br>
                    <label for="Confirm" class="font-semibold">Confirmer le nouveau mot de passe</label><br>
                    <input name="Confirm" type="password" class="w-full rounded-xl text-gray-600 text-base font-medium placeholder:text-gray-400"><br>
                    <div class="flex justify-center">
                        <button type="submit" name = "submit" value="changePass" class="focus:ring-0 w-fit my-5 justify-self-center border-4 border-white rounded-3xl px-8 py-1 hover:bg-white group  ">
                            <span class="text-center text-white text-lg font-semibold group-hover:text-indigo-500 group-hover:font-bold">Changer le mot de passe</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    @include('footer')
@endsection