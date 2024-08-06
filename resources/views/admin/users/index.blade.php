@extends('admin.base')

@section('title', 'Home Page')

@section('content')
    <div class="w-full my-5 p-3 container md:mx-auto">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-xl font-bold">Manage Users</h1>
            {{-- <a href="{{ route('membership.create') }}" class="p-2 bg-sky-600 rounded-xl text-white transition-all delay-5 hover:bg-sky-700">
                Add user
            </a> --}}
        </div>
        <div class="w-full bg-white rounded-xl shadow-md p-3 my-5">
            <div class="w-full flex items-center justify-between gap-3">
                <h1 class="p-2 text-lg font-semibold">Plans</h1>

            </div>
            @if ($users)
            <table class="w-full">
                <thead class="bg-gray-100 border-b-2">
                    <th class="p-3">ID</th>
                    <th class="p-3">CREATED AT</th>
                    <th class="p-3">NAME</th>
                    {{-- <th class="p-3">CUSTOMER</th> --}}
                    <th class="p-3">EMAIL</th>
                    <th class="p-3">STATUS</th>
                    <th class="p-3">ROLE</th>
                    <th class="p-2">ACTIONS</th>
                </thead>
                
                <tbody class="text-center">
                    @foreach ($users as $user)
                    <tr id="tr_{{ $user->id }}" class="border-b-2 border-gray-100 cursor-pointer transition-all delay-5 hover:bg-gray-50">
                        <td class="p-3">{{ $user->id }}</td>
                        <td class="p-3">{{ $user->created_at }}</td>
                        <td class="p-3">{{ $user->first_name }} {{ $user->last_name }}</td>
                        {{-- <td class="p-3">DAATA</td> --}}
                        {{-- <td class="p-3">{{ $user->last_name }}</td> --}}
                        <td class="p-3">
                            {{ $user->email }}
                        </td>
                        <td>
                            <input id="user_id_{{ $user->id }}" type="hidden" value="{{ $user->id }}" name="user_id">
                            <select id="statusChange_{{ $user->id }}" class="p-1 rounded-full border" name="status">
                                <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Pending" {{ $user->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Cancel" {{ $user->status == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                            </select>
                        </td>
                        <td class="p-3">
                            {{-- {{ gettype($user->is_admin) }} --}}
                            @if ($user->is_admin == 1)
                                <p class="bg-green-400 p-1 rounded-full">Admin</p>
                            @else
                                <p class="bg-red-400 p-1 rounded-full">Member</p>
                            @endif
                            
                        </td>
                        <td class="p-3 flex items-center h-full justify-center gap-4">
                            {{-- <a href="{{ route('membership.edit', $plan->slug) }}">
                                <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                              </svg>
                            </a> --}}
                              
                            {{-- <a href="">
                                <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-yellow-600"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </a> --}}
                            {{-- <form action="" method="POST"> --}}
                                {{-- @csrf --}}
                                {{-- @method('DELETE') --}}
                                <a href="javascript:void(0)" onclick="deleteUser({{ $user->id }})">
                                    <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                    </svg>
                                </a>
                                 
                            {{-- </form> --}}
                            
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