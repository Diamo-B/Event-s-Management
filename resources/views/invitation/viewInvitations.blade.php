@extends('app')

@section('content')
    @include('navbar')
    <main class="grid justify-center mx-[50%] mt-10 mb-32">

        <div class="flex text-center rounded-full justify-center">
            <div class="bg-indigo-400 py-10 px-28 border-4 border-indigo-500 rounded-lg ">

                <h1 class="mb-5 text-center text-4xl text-white font-bold">Invitation details</h1>

                <div class="mb-5 overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full border-2 border-gray-300  text-sm text-center  text-gray-500">
                        <thead class="text-xs text-gray-700 border  border-b-gray-300 uppercase bg-white ">
                            <tr>
                                <th scope="col" class="py-3 inline-block pr-60 pl-10">
                                    Event
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    attachment
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-gray-300 hover:text-white group">
                                <th scope="row"
                                    class="py-4 pl-10 font-medium text-left text-gray-900  whitespace-nowrap ">
                                    {{ $event['title'] }}
                                </th>
                                <td class="py-4 px-6 group-hover:text-gray-900 ">
                                    <a class="hover:text-black" href="{{ route('download.attachment', ['attachment' => $invitation['attachmentName']]) }}">
                                        {{ $invitation['attachmentName'] }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h2 class="mb-2 text-center text-lg text-white font-bold">Description</h2>
                <p class=" mb-10 text-base text-white">
                    {{ $invitation['object'] }}
                </p>
        </div>
        </div>
    </main>

    @include('footer')
@endsection
