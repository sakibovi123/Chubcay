@extends('admin.base')

@section('title', 'Home Page')

@section('content')
    <div class="w-full my-5 p-1 md:p-3 container md:mx-auto">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-xl font-bold">Manage Members</h1>
            <div class="flex gap-3 items-center">
                <a href="{{ route('types.create') }}" class="p-2 bg-sky-600 rounded-xl text-white transition-all delay-5 hover:bg-sky-700">
                    Add Membership Type
                </a>


            </div>

        </div>
        <div class="w-full bg-white rounded-xl shadow-md md:p-3 my-5">
            @if ($types)
                <div class="md:max-w-full max-w-80 overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b-2">

                        {{-- <th class="p-2">CREATED AT</th> --}}
                        <th class="p-2">MEMBER SHIP TYPE NAME</th>

                        <th class="p-2">ACTIONS</th>
                        </thead>

                        <tbody class="text-center">

                        @foreach ($types as $type)
                            <tr class="w-full border-b-2 border-gray-100 cursor-pointer transition-all delay-5 hover:bg-gray-50">

                                <td class="p-3">
                                    {{ $type->name }}
                                </td>

                                <td class="p-3 flex items-center h-full justify-center gap-4">
                                    <a href="{{ route('types.details', $type->id) }}">
                                        <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-yellow-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('types.destroy', $type->id) }}" method="post">
                                        @csrf
                                        @method('delete')
{{--                                        <input type="hidden">--}}
                                        <button type="submit">
                                            <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                            </svg>

                                        </button>

                                    </form>



                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

            @else
                <div class="w-full flex items-center justify-center">
                    {{--                    <p class="text-2xl text-center font-bold">No Data Found!</p>    --}}
                    <img src="{{ asset('images/no-data.png') }}" alt="">
                </div>
            @endif

        </div>
    </div>
    {{-- modal --}}


@endsection