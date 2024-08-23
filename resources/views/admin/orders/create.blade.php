@extends('admin.base')

@section('title', 'Create Plan')

@section('content')

<div class="w-full my-5 p-3 container md:mx-auto">

    @if (session('message'))
        <div class="my-3 w-full bg-orange-200 rounded shadow-xl p-2">
            {{ session('message') }}
        </div>
    @endif
    
    <div class="w-full flex items-center justify-between gap-3">
        <h1 class="text-xl font-bold text-gray-700">CREATE ORDER</h1>
        <a href="{{ route('checkout.index') }}" class="gont-bold text-white bg-blue-600 transition-all delay-5 hover:bg-sky-600 p-2 rounded-xl">GO BACK</a>
    </div>
    <form class="w-full my-7" action="{{ route('checkout.store') }}" method="post">
        @csrf
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
                <select required name="package_id" class="p-2 rounded w-full border">
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}">{{ $package->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full">
                <label class="text-gray-600 font-bold text-md">Select Payment Status</label><br>
                <select disabled required name="payment_status" class="p-2 rounded w-full border">
                    <option value="1">Paid</option>
                    <option selected value="0">Due</option>
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
                    <input id="card-number" maxlength="19" required name="card_number" type="text" placeholder="4242 4242 4242 4242" class="p-2 rounded w-full border">
                </div>
    
                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">Month</label><br>
                    <input maxlength="2" id="month" required name="month" type="text" placeholder="mm" class="no p-2 rounded w-full border">
                </div>
    
                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">Year</label><br>
                    <input maxlength="2" id="yy" required name="yy" type="text" placeholder="YY" class="no p-2 rounded w-full border">
                </div>
    
                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">CVC</label><br>
                    <input maxlength="3" id="cvv" required name="cvv" type="text" placeholder="xxx" class="p-2 rounded w-full border">
                </div>
            </div>
           
        </div>

        
        <div class="my-5 w-full flex items-center justify-between gap-3">
            <button type="submit" class="text-white w-full rounded p-2 bg-green-500">Save</button>
            <a href="{{ route('checkout.index') }}" class="text-center text-white w-full rounded p-2 bg-red-500">Back</a>
        </div>
        
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#payment_method').change(function() {
                if ($(this).val() === 'pay_now') {
                    $('.payment-section').show();
                    $('#card_number, #month, #yy, #cvv').attr('required', true);
                } else {
                    $('.payment-section').hide();
                    $('#card_number, #month, #yy, #cvv').removeAttr('required');
                }
            });    
        }); 
    </script>
    <script>
        $(document).ready(function() {
            $('#card-number').on('keypress change', function () {
                $(this).val(function (index, value) {
                    // Remove all non-alphanumeric characters and format with spaces
                    let formattedValue = value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
                    
                    // Trim the trailing space if the length is 19 characters (16 digits + 3 spaces)
                    return formattedValue.trimEnd();
                });
            });
            
        });

        $(document).ready(function() {
            $('.no').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numeric input
            });
        });
    </script>

@endsection