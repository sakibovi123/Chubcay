<script src="https://cdn.tailwindcss.com"></script>
@if (session('message'))
    <div class="my-3 w-full bg-red-200 rounded shadow-xl p-2">
        {{ session('message') }}
    </div>
@endif
<form method="post"
    {{-- {{ $feeLink->id }} --}}
     class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow-md" action="{{ route('user.feeCheckout', $feeLink) }}">
    @csrf
    @method('post')
    <h2 class="text-2xl font-bold mb-4">Make a Payment</h2>
    <div class="mb-4">
        <label for="payment_method" class="block text-gray-700 mb-2">Payment Method</label>
        <select name="method" id="payment_method" class="block w-full p-2 border rounded">
            <option value="" disabled selected>Select a payment method</option>
            <option value="check">Pay with Check</option>
            <option value="credit_card">Pay with Credit Card</option>
        </select>
    </div>

    <!-- Check Payment Section -->
    <div id="check_section" class="hidden">
        <div class="mb-4">
            <label for="check_number" class="block text-gray-700 mb-2">Check Number</label>
            <input name="check_number" type="text" id="check_number" class="block w-full p-2 border rounded" placeholder="Enter check number">
        </div>
        <button type="submit" id="submit_check" class="w-full bg-blue-500 text-white p-2 rounded">Pay ${{ $fee }}</button>
    </div>

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
        <button type="submit" id="submit_card" class="w-full bg-blue-500 text-white p-2 rounded">Pay ${{ $fee }}</button>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    $('#payment_method').change(function() {
        let selectedMethod = $(this).val();

        if (selectedMethod === 'check') {
            $('#check_section').show();
            $('#credit_card_section').hide();
        } else if (selectedMethod === 'credit_card') {
            $('#check_section').hide();
            $('#credit_card_section').show();
        } else {
            $('#check_section').hide();
            $('#credit_card_section').hide();
        }
    });

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
