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
        <form class="w-full my-7" action="{{ route('users.create_record') }}" method="post">
            @csrf
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md">Select User or <a class="text-blue-700" href="{{ route('users.create') }}">Create User</a></label><br>
                <select required name="user_id" class="p-2 rounded w-full border">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                    @endforeach

                </select>
            </div>


            <div class="w-full">
                <label class="text-gray-600 font-bold text-md">Select Payment Status</label><br>
                <select required name="payment_status" class="p-2 rounded w-full border">
                    <option value="paid">Paid</option>
                    <option selected value="due">Due</option>
                </select>
            </div>


            <div id="cardOrcash" class="w-full">
                <label class="text-gray-600 font-bold text-md">Select Payment Method</label><br>

                <select id="method" required name="payment_method" class="p-2 rounded w-full border">
                    <option value="" selected>Select Method</option>
                    <option value="card">Card</option>
                    <option value="cash">Cash</option>
                </select>

            </div>

            <div id="term" class="w-full hidden">
                <label class="text-gray-600 font-bold text-md">Select Payment Term</label><br>

                <select id="paymentTerm" required name="payment_term" class="p-2 rounded w-full border">
                    <option value="" selected>Select Term</option>
                    <option value="partial">Partial</option>
                    <option value="full">Full</option>
                </select>

            </div>

            <div id="amount_section" class="w-full hidden">
                <label class="text-gray-600 font-bold text-md" for="">Amount</label><br>
                <input id="amount" maxlength="19"  name="amount" type="text" placeholder="$"
                       class="p-2 rounded w-full border">
            </div>

            <div class="w-full flex gap-2 payment-section" style="display: none">
                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">Card Number</label><br>
                    <input id="card-number" maxlength="19"  name="card_number" type="text" placeholder="4242 4242 4242 4242" class="p-2 rounded w-full border">
                </div>

                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">Month</label><br>
                    <input maxlength="2" id="month"  name="month" type="text" placeholder="mm" class="no p-2 rounded w-full border">
                </div>

                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">Year</label><br>
                    <input maxlength="2" id="yy"  name="yy" type="text" placeholder="YY" class="no p-2 rounded w-full border">
                </div>

                <div class="w-full">
                    <label class="text-gray-600 font-bold text-md" for="">CVC</label><br>
                    <input maxlength="3" id="cvv"  name="cvv" type="text" placeholder="xxx" class="p-2 rounded w-full border">
                </div>
            </div>

        {{-- <div class="w-full flex items-center gap-3">
            <h4 class="text-gray-600 font-bold text-md" for="">Total: <span></span></h4><br>

        </div> --}}

    </div>

    <div class="my-5 w-full flex items-center justify-between gap-3">
        <button type="submit" class="text-white w-full rounded p-2 bg-green-500">Save</button>
        <a href="{{ route('checkout.index') }}" class="text-center text-white w-full rounded p-2 bg-red-500">Back</a>
    </div>

    </form>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // let method = $('#method');
        $(document).ready(function() {


            $('#method').on('change', function() {
                if ($(this).val() === 'card') {
                    $('.payment-section').show();
                    $('#term').show();
                    $('#card_number, #month, #yy, #cvv').attr('required', true);  // Make card fields required
                } else {
                    $('.payment-section').hide();
                    $('#term').show();
                    $('#card_number, #month, #yy, #cvv').removeAttr('required');  // Remove required from card fields
                }
            });

            // Payment term selection change event
            $('#paymentTerm').on('change', function() {
                if($(this).val() === 'partial') {
                    $('#amount_section').show();  // Show amount section
                    $('#amount').attr('required', true);  // Make amount required
                } else {
                    $('#amount_section').hide();  // Hide amount section
                    $('#amount').removeAttr('required');  // Remove required from amount
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

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}

{{--            document.getElementById('addSection').addEventListener('click', function(){--}}
{{--                let customFieldSection = document.getElementById('customFieldSection')--}}
{{--                let orderUpdatebutton = document.getElementById('orderUpdatebutton')--}}
{{--                // console.log(customFieldSection)--}}
{{--                customFieldSection.classList.remove('hidden')--}}
{{--                orderUpdatebutton.classList.remove('hidden')--}}
{{--            })--}}

{{--            // Event listener for adding a new container--}}
{{--            document.getElementById('addContainer').addEventListener('click', function () {--}}
{{--                const container = document.getElementById('customFields');--}}

{{--                // Clone the container--}}
{{--                const newContainer = container.cloneNode(true);--}}

{{--                // Clear the values in the cloned inputs--}}
{{--                newContainer.querySelectorAll('input').forEach(input => input.value = '');--}}

{{--                // Update the names of the cloned inputs--}}
{{--                const featureCount = document.querySelectorAll('.w-full.flex.items-center.justify-between.gap-3.mt-2').length;--}}
{{--                newContainer.querySelectorAll('input').forEach((input) => {--}}
{{--                    const name = input.getAttribute('name');--}}
{{--                    const newName = name.replace(/\d+/, featureCount);--}}
{{--                    input.setAttribute('name', newName);--}}
{{--                });--}}

{{--                // Replace "+" with "-" for the cloned container--}}
{{--                const buttonContainer = newContainer.querySelector('.button-container');--}}
{{--                buttonContainer.innerHTML = '<p class="removeContainer cursor-pointer text-2xl font-bold">-</p>';--}}

{{--                // Append the new container after the original container--}}
{{--                container.parentElement.appendChild(newContainer);--}}
{{--            });--}}

{{--            // Event listener for removing a container--}}
{{--            document.addEventListener('click', function (event) {--}}
{{--                if (event.target && event.target.classList.contains('removeContainer')) {--}}
{{--                    event.target.closest('.w-full.flex.items-center.justify-between.gap-3.mt-2').remove();--}}

{{--                    // Renumber the remaining containers--}}
{{--                    document.querySelectorAll('.w-full.flex.items-center.justify-between.gap-3.mt-2').forEach((item, index) => {--}}
{{--                        item.querySelectorAll('input').forEach(input => {--}}
{{--                            const name = input.getAttribute('name');--}}
{{--                            const newName = name.replace(/\d+/, index);--}}
{{--                            input.setAttribute('name', newName);--}}
{{--                        });--}}
{{--                    });--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--    </script>--}}

@endsection