@extends('admin.base')

@section('title', 'Home Page')

@section('content')
    <div class="w-full my-5 p-1 md:p-3 container md:mx-auto">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-xl font-bold">Manage Members</h1>
            <div class="flex gap-3 items-center">
                <a href="{{ route('users.create') }}" class="p-2 bg-sky-600 rounded-xl text-white transition-all delay-5 hover:bg-sky-700">
                    Add user
                </a>
                <a class="flex items-center gap-3 justify-center text-white p-2 bg-blue-500 rounded-xl" href="{{ route('users.export') }}">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/>
                      </svg>
                      Download Emails
                </a>
            </div>
            
        </div>
        <div class="w-full bg-white rounded-xl shadow-md md:p-3 my-5">
            @if ($users)
            <div class="md:max-w-full max-w-80 overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b-2">
                     
                        {{-- <th class="p-2">CREATED AT</th> --}}
                        <th class="p-2">NAME</th>
                       
                        <th class="p-2">EMAIL</th>
                        <th class="p-2">STATUS</th>
                        <th class="p-2">ROLE</th>
                        <th class="p-2">ACTIONS</th>
                    </thead>
                    
                    <tbody class="text-center">
                        @foreach ($users as $user)
                        <tr id="tr_{{ $user->id }}" class="w-full border-b-2 border-gray-100 cursor-pointer transition-all delay-5 hover:bg-gray-50">
                            
                            {{-- <td class="w-full p-3">{{ $user->created_at }}</td> --}}
                            <td class="p-3">{{ $user->first_name }} {{ $user->last_name }}</td>
                           
                            <td class="p-3">
                                {{ $user->email }}
                            </td>
                            <td class="p-3">
                                <input id="user_id_{{ $user->id }}" type="hidden" value="{{ $user->id }}" name="user_id">
                                <select data-status="{{ $user->status }}" id="statusChange_{{ $user->id }}" class="p-1 rounded-full border" name="status">
                                    <option className="bg-green-500" value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Pending" {{ $user->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                   
                                </select>
                            </td>
                            <td class=" p-3">
                                
                                @if ($user->is_admin == 1)
                                    <p class="bg-green-400 p-1 rounded-full">Admin</p>
                                @else
                                    <p class="text-white bg-blue-500 p-1 rounded-full">Member</p>
                                @endif
                                
                            </td>
                            <td class="p-3 flex items-center h-full justify-center gap-4">
                                    <a href="{{ route('users.edit', $user->id) }}">
                                        <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-yellow-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" onclick="deleteUser({{ $user->id }})">
                                        <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                        </svg>
                                    </a>
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
    {{-- modal --}}
    <div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="feeModal">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-auto">
          <div class="flex justify-between items-center border-b p-4">
            <h5 class="text-lg font-medium" id="feeModalLabel">Set Registration Fee</h5>
            <button type="button" class="text-gray-500 hover:text-gray-700" data-close="modal">
              <span class="text-xl">&times;</span>
            </button>
          </div>
          <div class="p-4">
            <form id="feeForm">
              <div class="mb-4">
                <label for="fee" class="block text-gray-700">Fee</label>
                <input type="number" class="form-input mt-1 block w-full p-2 border rounded" id="fee" name="fee" required>
              </div>
              <input type="hidden" id="modalUserId">
              <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
@endsection