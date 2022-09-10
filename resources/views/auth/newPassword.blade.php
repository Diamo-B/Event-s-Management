@extends('app')
@section('content')
<main>
    <div class=" bg-white grid justify-items-center h-screen">
    @if($errors->any())
    <div class="w-fit h-fit py-2 px-10 absolute top-16 text-center text-sm  text-red-700 bg-red-100 rounded-lg " role="alert">
        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 pb-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        <p class="inline-block"><span class="font-medium">Alert!</span> {{ $errors->first() }}</p>
    </div>
    @endif
    <section class=" my-auto shadow-2xl rounded-xl">
        <div class="max-w-sm bg-white rounded-xl border border-gray-200 shadow-xl text-center ">
            <div class="p-5">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-700 ">Créer un nouvel mot de passe</h5>
                <form action="{{ route('password.update') }}" method="post">
                    @csrf
                    @method('POST')            
                    <div class="mt-5 mb-2">
                        <label for="New" class="font-semibold">Nouveau mot de passe</label>
                        <input type="password" name="New" id="New" class="w-full mb-5 text-sm text-gray-700 form-control rounded-lg text-center py-1.5 font-normal bg-white bg-clip-padding border border-solid border-gray-600 transition ease-in-out m-0 focus:ring-0  focus:bg-white focus:border-gray-900 focus:outline-none">
                    </div>
                    
                    <div class="mt-2 mb-5">
                        <label for="Confirm" class="font-semibold">Confirmez le mot de passe</label>
                        <input type="password" name="Confirm" id="Confirm" class="w-full  text-sm text-gray-700 form-control rounded-lg text-center py-1.5 font-normal bg-white bg-clip-padding border border-solid border-gray-600 transition ease-in-out m-0 focus:ring-0  focus:bg-white focus:border-gray-900 focus:outline-none">
                    </div>
            </div>
                <input type="hidden" value="{{ $token }}" name="token">
                <button type="submit" class="focus:ring-0  mb-5 border-4 border-gray-700 rounded-3xl px-8 py-1 hover:bg-indigo-500 hover:border-gray-300 group">
                    <span class="text-center text-gray-700 text-base font-semibold  group-hover:text-white group-hover:font-bold">Réinitialiser le mot de passe</span>
                </button>
                </form>
        </div>
    </section>
</div>
</main>
@endsection