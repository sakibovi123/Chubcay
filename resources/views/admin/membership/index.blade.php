@extends('admin.base')

@section('title', 'Home Page')

@section('content')
    <div class="w-full my-5 p-3 container md:mx-auto">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-xl font-bold">Manage Membership Plans</h1>
            <a href="{{ route('membership.create') }}" class="p-2 bg-sky-600 rounded-xl text-white transition-all delay-5 hover:bg-sky-700">
                Create Plan
            </a>
        </div>
        <div class="w-full bg-white rounded-xl shadow-md p-3 my-5">
            <div class="w-full flex items-center justify-between gap-3">
                <h1 class="p-2 text-lg font-semibold">Plans</h1>

            </div>
            @if ($plans)
            <table class="w-full">
                <thead class="bg-gray-100 border-b-2">
                    <th class="p-3">CREATED AT</th>
                    <th class="p-3">PACKAGE NAME</th>
                    {{-- <th class="p-3">CUSTOMER</th> --}}
                    <th class="p-3">PLAN NAME</th>
                    <th class="p-3">PRICE</th>
                    <th class="p-3">STATUS</th>
                    <th class="p-2">ACTIONS</th>
                </thead>
                
                <tbody class="text-center">
                    @foreach ($plans as $plan)
                    <tr class="border-b-2 border-gray-100 cursor-pointer transition-all delay-5 hover:bg-gray-50">
                        <td class="p-3">{{ $plan->created_at }}</td>
                        <td class="p-3">{{ $plan->title }}</td>
                        {{-- <td class="p-3">DAATA</td> --}}
                        <td class="p-3">{{ $plan->duration_title }}</td>
                        <td class="p-3">${{ $plan->price }}</td>
                        <td class="p-3">
                            @if ($plan->status == 'Active')
                                <p class="bg-green-400 p-1 rounded-xl">{{ $plan->status }}</p>
                            @else
                                <p class="bg-red-400 p-1 rounded-xl">{{ $plan->status }}</p>
                            @endif
                        </td>
                        <td class="p-3 flex items-center h-full justify-center gap-4">
                            {{-- <a href="{{ route('membership.edit', $plan->slug) }}">
                                <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                              </svg>
                            </a> --}}
                              
                            <a href="{{ route('membership.edit', $plan->slug) }}">
                                <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-yellow-600"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
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
            @else
                <p class="text-2xl text-center font-bold">No Data Found!</p>
            @endif
            
        </div>
    </div>
@endsection