@extends('admin.base')

@section('title', 'Home Page')

@section('content')
<div class="w-full my-5 md:p-3 container md:mx-auto">
    <div class="flex items-center md:justify-between w-full gap-5">
        <h1 class="text-xl font-bold">Manage Membership Plans</h1>
        <a href="{{ route('membership.create') }}" class="text-sm p-2 bg-sky-600 rounded-xl text-white transition-all delay-5 hover:bg-sky-700">
            Create Plan
        </a>
    </div>
    
    <div class="w-full p-1 md:p-3 my-5">
        @if ($plans)
        <div class="bg-white rounded max-w-80 md:max-w-full relative overflow-x-auto ">
            <table class="w-full">
                <thead class="bg-white border-b-2">
                    {{-- <tr> --}}
                        <th class="text-sm p-2 sm:p-3">CREATED AT</th>
                        <th class="text-sm p-2 sm:p-3">PACKAGE NAME</th>
                        <th class="text-sm p-2 sm:p-3">PLAN NAME</th>
                        <th class="text-sm p-2 sm:p-3">PRICE</th>
                        <th class="text-sm p-2 sm:p-3">STATUS</th>
                        <th class="text-sm p-2 sm:p-3">ACTIONS</th>
                    {{-- </tr> --}}
                </thead>
                
                <tbody class="text-center">
                    @foreach ($plans as $plan)
                    <tr class="border-b-2 border-gray-100 cursor-pointer transition-all delay-5 hover:bg-gray-50">
                        <td class="p-2 sm:p-3">{{ $plan->created_at->format('Y-m-d') }}</td>
                        <td class="p-2 sm:p-3">{{ $plan->title }}</td>
                        <td class="p-2 sm:p-3">{{ $plan->duration_title }}</td>
                        <td class="p-2 sm:p-3">${{ $plan->price }}</td>
                        <td class="p-2 sm:p-3">
                            @if ($plan->status == 'Active')
                                <p class="bg-green-400 p-1 rounded-xl">{{ $plan->status }}</p>
                            @else
                                <p class="bg-red-400 p-1 rounded-xl">{{ $plan->status }}</p>
                            @endif
                        </td>
                        <td class="p-2 sm:p-3 flex items-center justify-center gap-4">
                            <a href="{{ route('membership.edit', $plan->slug) }}">
                                <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-yellow-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </a>
                            <form action="{{ route('membership.destroy', $plan->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
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
            <p class="text-2xl text-center font-bold">No Data Found!</p>
        @endif
    </div>
</div>
@endsection
