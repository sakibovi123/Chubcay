@extends('admin.base')

@section('title', 'Create Plan')

@section('content')

<div class="w-full my-5 p-3 container md:mx-auto">
    
    <div class="w-full flex items-center justify-between gap-3">
        <h1 class="text-xl font-bold text-gray-700">CREATE ORDER</h1>
        <a href="{{ route('checkout.index') }}" class="gont-bold text-white bg-blue-600 transition-all delay-5 hover:bg-sky-600 p-2 rounded-xl">GO BACK</a>
    </div>
    <form class="w-full my-7" action="{{ route('checkout.store') }}" method="post">
        @csrf
        <div class="w-full">
            <label class="text-gray-600 font-bold text-md" for="">First Name</label><br>
            <input required name="first_name" type="text" placeholder="Enter first name..." class="p-2 rounded w-full border">
        </div>
        <div class="my-3 flex flex-col items-center jusitify-between gap-5">
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Last Name</label><br>
                <input required name="last_name" type="text" placeholder="Enter sub title..." class="p-2 rounded w-full border">
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Email</label><br>
                <input required name="email" type="email" placeholder="Enter email..." class="p-2 rounded w-full border">
            </div>
            

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Phone</label><br>
                <input id="phone" required name="phone" type="text" placeholder="Enter phone..." class="p-2 rounded w-full border">
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md">Select User</label><br>
                <select required name="user_id" class="p-2 rounded w-full border">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                    @endforeach
                    
                </select>
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md">Select Package</label><br>
                <select required name="user_id" class="p-2 rounded w-full border">
                    @foreach ($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->title }}</option>
                    @endforeach
                    
                </select>
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md">Select Payment Status</label><br>
                <select required name="payment_status" class="p-2 rounded w-full border">
                    <option value="1">Paid</option>
                    <option value="0">Due</option>
                </select>
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md">Select Payment Method</label><br>
                <select id="payment_method" required name="payment_method" class="p-2 rounded w-full border">
                    <option value="" selected>Select Method</option>
                    <option value="pay_now">Pay now</option>
                    <option value="send_link">Send Payment Link</option>
                </select>
            </div>

            <div class="w-full flex gap-2 payment-section" style="display: none">
                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">Card Number</label><br>
                    <input id="card_number" required name="card_number" type="text" placeholder="4242 4242 4242 4242" class="p-2 rounded w-full border">
                </div>
    
                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">Month</label><br>
                    <input id="month" required name="month" type="text" placeholder="mm" class="p-2 rounded w-full border">
                </div>
    
                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">Year</label><br>
                    <input id="yy" required name="yy" type="text" placeholder="YY" class="p-2 rounded w-full border">
                </div>
    
                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">CVV</label><br>
                    <input id="cvv" required name="cvv" type="text" placeholder="cvv" class="p-2 rounded w-full border">
                </div>
            </div>
           
        </div>

        
        <div class="my-5 w-full flex items-center justify-between gap-3">
            <button class="text-white w-full rounded p-2 bg-green-500">Save</button>
            <button class="text-white w-full rounded p-2 bg-red-500">Back</button>
        </div>
        
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#payment_method').change(function() {
            if ($(this).val() === 'pay_now') {
                $('.payment-section').show();
            } else {
                $('.payment-section').hide();
            }
        });
    });
    </script>
@endsection