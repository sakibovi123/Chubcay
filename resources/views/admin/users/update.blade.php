@extends('admin.base')

@section('title', 'Add User')

@section('content')

<div class="w-full my-5 p-3 container md:mx-auto">
    @if (session('message'))
        <div class="my-3 w-full bg-orange-200 rounded shadow-xl p-2">
            {{ session('message') }}
        </div>
    @endif

    <div class="w-full flex items-center justify-between gap-3">
        <h1 class="text-xl font-bold text-gray-700">UPDATE USER</h1>
        <a href="{{ route('users.index') }}" class="gont-bold text-white bg-blue-600 transition-all delay-5 hover:bg-sky-600 p-2 rounded-xl">GO BACK</a>
    </div>
    <form class="w-full my-7" action="{{ route('users.update', $user->id) }}" method="post">
        @method('put')
        @csrf
        <div class="w-full">
            <label class="text-gray-600 font-bold text-md" for="">First Name</label><br>
            <input required value="{{ $user->first_name }}" name="first_name" type="text" placeholder="Enter first name" class="p-2 rounded w-full border">
        </div>
        <div class="my-3 flex flex-col items-center jusitify-between gap-5">
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Last Name</label><br>
                <input value="{{ $user->last_name }}" required name="last_name" type="text" placeholder="Enter last name" class="p-2 rounded w-full border">
            </div>
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Email</label>
                <input value="{{ $user->email }}" required name="email" id="email" type="email" placeholder="example@gmail.com" class="p-2 rounded w-full border">
                
            </div>

            {{-- <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Password</label>
                <input value="{{ $user->password }}" required name="password" id="password" type="password" placeholder="********" class="p-2 rounded w-full border">
                
            </div> --}}
            
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Phone</label>
                <input value="{{ $user->phone }}" required name="phone" id="phone" type="number" placeholder="Enter phone" class="p-2 rounded w-full border">
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Country</label>
                <input value="{{ $user->country }}" required name="country" id="country" type="text" placeholder="Enter country name" class="p-2 rounded w-full border">
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">City</label>
                <input value="{{ $user->city }}" required name="city" id="city" type="text" placeholder="Enter city name" class="p-2 rounded w-full border">
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="status">Status</label>
                <select required name="status" class="p-2 rounded w-full border">
                    <option disabled value="">Select Status</option>
                    <option value="Pending" {{ $user->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                </select>
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="membership_type">Payment Status</label>
                <select required name="payment_status" class="p-2 rounded w-full border">
                    <option disabled value="">Select Payment Status</option>
                    <option value="paid" {{ $user->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="due" {{ $user->payment_status == 'due' ? 'selected' : '' }}>Due</option>
                </select>
            </div>

{{--            <div class="w-full">--}}
{{--                <label class="text-gray-600 font-bold text-md" for="membership_type">Membership Type</label>--}}
{{--                <select required name="membership_type" class="p-2 rounded w-full border">--}}
{{--                    <option disabled value="">Select Membership Type</option>--}}
{{--                    <option value="Social" {{ $user->membership_type == 'Social' ? 'selected' : '' }}>Social</option>--}}
{{--                    <option value="Legacy" {{ $user->membership_type == 'Legacy' ? 'selected' : '' }}>Legacy</option>--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            <div class="w-full">--}}
{{--                <label class="text-gray-600 font-bold text-md" for="">Balance</label>--}}
{{--                <input value="{{ $user->balance }}" required name="balance" id="balance" type="text" placeholder="0.00" class="p-2 rounded w-full border">--}}
{{--            </div>--}}

        </div>

        <div class="my-5 w-full flex items-center justify-between gap-3">
            <button class="text-white w-full rounded p-2 bg-green-500">Save</button>
            <a href="{{ route('users.index') }}" class="text-center text-white w-full rounded p-2 bg-red-500">Back</a>
        </div>
        
    </form>
</div>
<script>
    document.getElementById('balance').addEventListener('input', function() {
        let value = this.value;
    
        // Remove non-numeric characters except the decimal point
        value = value.replace(/[^0-9.]/g, '');
    
        // Split the value at the decimal point
        let parts = value.split('.');
    
        // Ensure that there are no more than 2 decimal places
        if (parts.length > 1) {
            parts[1] = parts[1].slice(0, 2);
        }
    
        // Reconstruct the value
        value = parts.join('.');
    
        // If there's no decimal point or it's at the end, append .00
        if (value.indexOf('.') === -1) {
            value += '.00';
        } else if (value.indexOf('.') === value.length - 1) {
            value += '00';
        } else if (value.indexOf('.') === value.length - 2) {
            value += '0';
        }
    
        // Save cursor position
        let cursorPos = this.selectionStart;
        
        // Update the input value
        this.value = value;
    
        // Restore cursor position
        this.setSelectionRange(cursorPos, cursorPos);
    });
</script>
@endsection