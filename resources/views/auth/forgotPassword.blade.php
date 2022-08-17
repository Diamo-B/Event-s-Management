@extends('app')

@section('content')
<main>
<div class=" bg-white grid justify-items-center mt-36 ">
    @if($errors->any())
    <div class="max-w-sm w-fit h-fit py-2 px-12 mb-5 text-center text-sm  text-red-700 bg-red-100 rounded-lg " role="alert">
        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        <p class="inline-block"><span class="font-medium">Alert!</span> {{ $errors->first() }}</p>
    </div>
    @endif
    <section class=" my-auto shadow-2xl rounded-xl">
        <div class="max-w-sm bg-white rounded-xl border border-gray-200 shadow-xl text-center ">
            <div class="px-5">
                <h2 class=" mt-3 mb-8 text-2xl text-gray-700 font-semibold ">Forgot your password?</h2>
                <p class=" mb-5 text-left text-base text-gray-500 ">Don't fret! Just type in your email and we will send you a code to reset your password!</p>
                <form action="{{ route('password.forget.sendEmail') }}" method="post">
                    @method('POST')
                    @csrf
                    <label for="email" class="font-semibold">Your email</label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" class="w-full mb-5 text-sm text-gray-700 form-control rounded-lg text-center py-1.5 font-normal bg-white bg-clip-padding border border-solid border-gray-600 transition ease-in-out m-0 focus:ring-0  focus:bg-white focus:border-gray-900 focus:outline-none">

                    <button type="submit" class="my-5 w-[60%] border-4 border-gray-500 rounded-3xl px-8 py-1 hover:bg-indigo-500 hover:border-gray-300 group">
                        <span class="text-center text-gray-700 text-base font-semibold  group-hover:text-white group-hover:font-bold">
                            Reset password
                        </span>
                    </button>
                </form>
        </div>

    </section>
</div>
</main> 
@endsection