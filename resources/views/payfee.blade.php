<script src="https://cdn.tailwindcss.com"></script>
@if (session('message'))
    <div class="my-3 w-full bg-red-200 rounded shadow-xl p-2">
        {{ session('message') }}
    </div>
@endif

@if (Auth::user()->id == $feeLink->user->id)
<form method="post"

{{-- {{ $feeLink->id }} --}}
 class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow-md" action="{{ route('user.feeCheckout', $feeLink) }}">
@csrf
@method('post')
<h2 class="text-2xl font-bold mb-4">Make a Payment</h2>
<p class="mb-5">Total: ${{ $feeLink->total_charge }}</p>
<p class="mb-5">
    Paid: 
    @if ($feeLink->paid == 0.00)
        $0.00
    @else
        ${{ $feeLink->paid }}
    @endif
    
</p>
<p class="mb-5">
    Due: 
    @if ($feeLink->due == 0.00)
        ${{ $fee }}
    @else
        ${{ $feeLink->due }}
    @endif
    
</p>


<div class="mb-4">
    <label for="payment_method" class="block text-gray-700 mb-2">Payment Method</label>
    <select name="method" id="payment_method" class="block w-full p-2 border rounded">
        <option value="" disabled selected>Select a payment method</option>
         <option value="wallet">Pay with Wallet</option>
        <option value="credit_card">Pay with Credit Card</option>
    </select>
</div>

{{-- payment term section --}}

<div id="payment-term-section" class="mb-4 hidden">
    <label for="payment_terms" class="block text-gray-700 mb-2">Payment Term</label>
    <select name="term" id="payment_term" class="block w-full p-2 border rounded">
        <option value="" disabled selected>Select a payment term</option>
        <option value="full">Full</option>
        <option value="partial">Partial</option>
    </select>
</div>

{{-- payment amount when partial selected --}}

<div id="payment-amount" class="mb-4 hidden">
    <label for="amount" class="block text-gray-700 mb-2">Amount</label>
    <input id="paid-amount" placeholder="$ Enter amount" type="text" name="amount" class="block w-full p-2 border rounded">
</div>

<!-- Check Payment Section -->
<div id="check_section" class="hidden">
{{--    <div class="mb-4">--}}
{{--        <label for="check_number" class="block text-gray-700 mb-2"></label>--}}
{{--        <input name="check_number" type="text" id="check_number" class="block w-full p-2 border rounded" placeholder="Enter check number">--}}
{{--    </div>--}}
    <button type="submit" id="submit_check" class="w-full bg-blue-500 text-white p-2 rounded">Pay</button>
</div>
{{--<button hidden type="submit" id="submit_check" class="w-full bg-blue-500 text-white p-2 rounded">Pay</button>--}}

<!-- Credit Card Payment Section -->
<div id="credit_card_section" class="hidden">
    <div class="mb-4">
        <label for="card_number" class="block text-gray-700 mb-2">Card Number</label>
        <input name="card_number" type="text" id="card_number" maxlength="19" class="block w-full p-2 border rounded" placeholder="4242 4242 4242 4242">
    </div>
    <div class="mb-4 flex space-x-4">
        <div>
            <label for="month" class="block text-gray-700 mb-2">Month</label>
            <input name="mm" type="text" id="month" maxlength="2" class="block w-full p-2 border rounded" placeholder="MM">
        </div>
        <div>
            <label for="year" class="block text-gray-700 mb-2">Year</label>
            <input name="yy" type="text" id="year" maxlength="2" class="block w-full p-2 border rounded" placeholder="YY">
        </div>
        <div>
            <label for="cvv" class="block text-gray-700 mb-2">CVC</label>
            <input type="text" id="cvv" maxlength="3" class="block w-full p-2 border rounded" placeholder="CVC">
        </div>
    </div>
    {{-- <button type="submit" id="submit_card" class="w-full bg-blue-500 text-white p-2 rounded">Pay</button> --}}

    <button type="submit" id="" class="w-full bg-blue-500 text-white p-2 rounded">Pay</button>
</div>
</form>
@else
    <p class="container mx-auto my-5 text-center text-white bg-red-600 p-5 text-xl">Wrong user <a class="text-blue-600" href="{{ route('home.home') }}">Go back</a></p>
@endif


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    $(document).ready(function() {

    $('#payment_method').change(function() {

        let selectedMethod = $(this).val();

        if (selectedMethod === 'wallet') {
            $('#check_section').show();
            // $('#submit_check').show();
            $('#credit_card_section').hide();
        } else if (selectedMethod === 'credit_card') {
            $('#check_section').hide();
            $('#credit_card_section').show();
        } else {
            $('#check_section').hide();
            $('#credit_card_section').hide();
        }
        if (selectedMethod) {
            $('#payment-term-section').show();
        } else {
            $('#payment-term-section').hide();
        }
    });

    // checking payment
    $('#payment_term').change(function(){
        let selectedTerm = $(this).val();
        // let fee = '{{ $fee }}';
        // console.log(selectedTerm);

        if(selectedTerm == 'partial') {
            $('#payment-amount').show();
            // $('#payment-amount').show();
            // $('#submit_card').text('Pay');
        }
        else {
            $('#payment-amount').hide();
            // $('#submit_card').text('Pay $' + fee);
        }

    });
    $('#payment_term').trigger('change');

    // validating payment amount
{{--    $('#paid-amount').on('input', function(){--}}
{{--    let amount = $(this).val();--}}

{{--    // Remove any non-numeric characters (allow only integers)--}}
{{--    amount = amount.replace(/[^0-9]/g, '');--}}

{{--    // Convert the cleaned value to an integer--}}
{{--    amount = parseInt(amount, 10);--}}

{{--    // Check if the amount is a valid number--}}
{{--    if (isNaN(amount)) {--}}
{{--        amount = ''; // Reset amount if it's not a number--}}
{{--    } else {--}}
{{--        // Assuming $fee is set to 400 in your script--}}
{{--        const fee = @json($fee);--}}

{{--        // If the amount is greater than the fee, set it back to the fee--}}
{{--        if (amount > fee) {--}}
{{--            amount = fee;--}}
{{--            alert("Amount can't be greater than the total charge of $" + fee);--}}
{{--        }--}}
{{--    }--}}

{{--    // Set the input value to the validated integer amount--}}
{{--    $(this).val(amount);--}}
{{--});--}}


    // Credit Card input formatting
    $('#card_number').on('input', function() {
        let value = $(this).val().replace(/\D/g, '').substring(0, 16); // Remove non-digits and limit to 16 digits
        $(this).val(value.replace(/(.{4})/g, '$1 ').trim()); // Add space after every 4 digits
    });

    // Allow only numbers in month, year, and cvv fields
    $('#month, #year, #cvv').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numeric input
    });
});

</script>
