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
                <a href="{{ route('users.create_fee_record') }}" class="p-2 bg-sky-600 rounded-xl text-white transition-all delay-5 hover:bg-sky-700">
                    Create Record
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
                        <th class="p-2">Fee</th>

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
                                @if($user->status == 'Pending')
                                    <p class="bg-orange-300 p-1 rounded-full">
                                        {{ $user->status }}
                                    </p>
                                @else
                                    <p class="bg-green-500 p-1 rounded-full text-white">
                                        {{ $user->status }}
                                    </p>
                                @endif

{{--                                <input id="user_id_{{ $user->id }}" type="hidden" value="{{ $user->id }}" name="user_id">--}}
{{--                                <select data-status="{{ $user->status }}" id="statusChange_{{ $user->id }}" class="p-1 rounded-full border" name="status">--}}

{{--                                    <option className="bg-green-500" value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>--}}
{{--                                    <option value="Pending" {{ $user->status == 'Pending' ? 'selected' : '' }}>Pending</option>--}}
{{--                                   --}}
{{--                                </select>--}}
                            </td>
                            <td class="p-3">
                                
                                @if ($user->is_admin == 1)
                                    <p class="bg-green-400 p-1 rounded-full">Admin</p>
                                @else
                                    <p class="text-white bg-blue-500 p-1 rounded-full">Member</p>
                                @endif
                                
                            </td>

                            <td class="p-3">
                                @if($user->fee)
                                    ${{ $user->fee }}
                                @else
                                    $0.00
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
                                <a data-tooltip-target="tooltip-default" class="p-1" href="{{ route('users.reset', $user->id) }}">
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15.141 6 5.518 4.95a1.05 1.05 0 0 1 0 1.549l-5.612 5.088m-6.154-3.214v1.615a.95.95 0 0 0 1.525.845l5.108-4.251a1.1 1.1 0 0 0 0-1.646l-5.108-4.251a.95.95 0 0 0-1.525.846v1.7c-3.312 0-6 2.979-6 6.654v1.329a.7.7 0 0 0 1.344.353 5.174 5.174 0 0 1 4.652-3.191l.004-.003Z"/>
                                    </svg>

                                </a>
                                <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Send password link
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>


                                <input type="hidden" class="user_id_input" value="{{ $user->id }}" name="user_id">
                                <button data-tooltip-target="tooltip-default-cash" class="modalActivator p-1" data-user-id="{{ $user->id }}">
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                    </svg>

                                    <div id="tooltip-default-cash" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        Set Membership Type
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>

                                </button>

                            </td>

{{--                            <td>--}}
{{--                                <a class="bg-blue-500 text-white rounded p-1" href="{{ route('users.reset', $user->id) }}">Send Password Reset Link</a>--}}
{{--                            </td>--}}
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
    <div class="fixed inset-0 flex items-center justify-center z-50 hidden backdrop-blur-sm" id="feeModal">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-auto">
          <div class="flex justify-between items-center border-b p-4">
            <h5 class="text-lg font-medium" id="feeModalLabel">Set Membership Type</h5>
            <button type="button" class="text-gray-500 hover:text-gray-700" data-close="modal">
              <span class="text-xl">&times;</span>
            </button>
          </div>
          <div class="p-4">
            <form id="feeForm">
              <div class="mb-4">
                <label for="fee" class="block text-gray-700">Select Membership Type</label>
                <select class="form-input mt-1 block w-full p-2 border rounded"
                        id="fee" name="fee" required>
                    <option selected disabled value="">Select Membership Type</option>
                        @foreach( $types as $type )
                        <option value="{{ $type->id }}" data-price="{{ $type->price }}">{{ $type->name }}</option>
                        @endforeach
                </select>
              </div>

                <p id="total_price">Total: $0.00</p>

              <input type="hidden" id="modalUserId">
              <div class="flex justify-end">
                <button type="submit" class="flex items-center gap-3 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Submit
                    <svg id="loadingIndicator" aria-hidden="true" class="hidden w-4 h-4 text-gray-100 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>



    <script>
        document.getElementById('fee').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const totalPriceElement = document.getElementById('total_price');

            if (price) {
                totalPriceElement.textContent = `Total: $${parseFloat(price).toFixed(2)}`;
            } else {
                totalPriceElement.textContent = "Total: $0.00";
            }
        });
    </script>
      
@endsection