@extends('admin.base')

@section('title', 'Home Page')

@section('content')
    <div class="w-full my-5 p-3 container md:mx-auto">
        <div class="w-full flex items-center justify-end">
            <a href="{{ route('checkout.invoice', $order->id) }}">
                <svg class="mx-6 w-6 h-6 text-gray-800 cursor-pointer transition-all delay-5 hover:text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M16.444 18H19a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h2.556M17 11V5a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v6h10ZM7 15h10v4a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-4Z"/>
                  </svg>
            </a>
            
              
            <a href="{{ route('checkout.index') }}" class="p-2 rounded-full bg-blue-600 transition-all delay-5 text-white font-semibold">
                Go back
            </a>
        </div>
        <div class="w-full bg-white rounded-xl shadow-md p-3 my-5">
            <div class="w-full p-3">
                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-lg font-bold">Invoice number:</h1>
                    <p class="text-lg font-semibold">#{{ $order->invoice }}</p>
                </div>
                
                
                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-lg font-bold">Invoice date:</h1>
                    <p class="text-lg font-semibold">#{{ $order->created_at->format('Y/m/d') }}</p>
                </div>
            </div>
            <h1 class="p-3 text-xl font-bold w-full border-b-2">Customer Details</h1>
            <div class="p-3">
                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-md font-bold">Name:</h1>
                    <p class="text-md font-semibold">{{ $order->user->first_name }} {{ $order->user->first_name }}</p>
                </div><br>
                {{-- <p class="p-2"><span class="font-bold">Name</span>: </p> --}}
                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-md font-bold">Email:</h1>
                    <p class="text-md font-semibold">{{ $order->user->email }}</p>
                </div><br>
                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-md font-bold">Phone:</h1>
                    <p class="text-md font-semibold">{{ $order->user->phone }}</p>
                </div><br>
                <h1 class="text-xl font-bold w-full border-b-2">Package Details</h1>

                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-md font-bold">Package name:</h1>
                    <p class="text-md font-semibold">{{ $order->package->title }}</p>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-md font-bold">Features:</h1>
                    <p class="text-md font-semibold">
                    @foreach ($order->package->features as $feature=>$value)
                        {{ $feature }} -> {{ $value }}<br>
                    @endforeach
                    </p>

                </div>

                <br>
                <div class="flex items-center justify-between gap-2 border-b-2">
                    <h1 class="text-md font-bold">Plan:</h1>
                    <p class="text-md font-semibold">{{ $order->package->duration_title }}</p>
                </div>

                <div class="flex items-center justify-between gap-2 border-b-2">
                    <h1 class="text-md font-bold">Price:</h1>
                    <p class="text-md font-semibold">${{ $order->package->price }}</p>
                </div>
                

                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-md font-bold">Paid:</h1>
                    <p class="text-md font-semibold">
                        @if( $order->paid != 0.00 )
                        ${{ $order->paid }}
                        @else
                        $0.00
                        @endif
                    </p>
                </div>

                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-md font-bold">Due:</h1>
                    <p class="text-md font-semibold">
                        @if( $order->due != 0.00 )
                        ${{ $order->due }}
                        @else
                        $0.00
                        @endif
                    </p>
                </div>

                <div class="flex items-center justify-between gap-2">
                    <h1 class="text-md font-bold">Grand Total:</h1>
                    <p class="text-md font-semibold">
                        @if( $order->grand_total != 0.00 )
                        ${{ $order->grand_total }}
                        @else
                        $0.00
                        @endif
                    </p>
                </div>
                
            </div>

            @php
                $customFields = json_decode($order->custom_fields, true);
            @endphp

            @if(is_array($customFields) && count($customFields) > 0)
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Key</th>
                            <th class="border border-gray-300 p-2 text-left">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customFields as $field)
                            <tr>
                                <td class="border border-gray-300 p-2">{{ $field['key'] }}</td>
                                <td class="border border-gray-300 p-2">{{ $field['value'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No custom fields available.</p>
            @endif

            
        </div>

        <div class="text-xl font-bold flex items-center gap-3">
            <h1>Custom Fields</h1>
            <p id="addSection" class="text-md bg-blue-500 p-1 text-center w-[80px] rounded text-white cursor-pointer">Add</p>
        </div>
        {{-- <form action=""></form> --}}
        <form action="{{ route('checkout.update', $order->id) }}"  method="post">
        
            @csrf
            @method('put')
            <div id="customFieldSection" class="hidden flex flex-col items-center gap-3 my-2">
                <div id="customFields" class="w-full flex items-center justify-between gap-3 mt-2">
                    <input required name="custom_fields[0][key]" placeholder="Enter key" class="w-full p-2 rounded border" type="text">
                    <input required name="custom_fields[0][value]" placeholder="Enter value" class="w-full p-2 rounded border" type="text">
                    <div class="button-container">
                        <p id="addContainer" class="cursor-pointer text-2xl font-bold">+</p>
                    </div>
                </div>
            </div>
            

            <button id="orderUpdatebutton" type="submit" class="hidden bg-blue-600 font-bold bg-2 w-full p-1 text-white rounded">Update</button>
        </form>
            
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.getElementById('addSection').addEventListener('click', function(){
                let customFieldSection = document.getElementById('customFieldSection')
                let orderUpdatebutton = document.getElementById('orderUpdatebutton')
                // console.log(customFieldSection)
                customFieldSection.classList.remove('hidden')
                orderUpdatebutton.classList.remove('hidden')
            })
                    
            // Event listener for adding a new container
            document.getElementById('addContainer').addEventListener('click', function () {
                const container = document.getElementById('customFields');

                // Clone the container
                const newContainer = container.cloneNode(true);

                // Clear the values in the cloned inputs
                newContainer.querySelectorAll('input').forEach(input => input.value = '');

                // Update the names of the cloned inputs
                const featureCount = document.querySelectorAll('.w-full.flex.items-center.justify-between.gap-3.mt-2').length;
                newContainer.querySelectorAll('input').forEach((input) => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/\d+/, featureCount);
                    input.setAttribute('name', newName);
                });

                // Replace "+" with "-" for the cloned container
                const buttonContainer = newContainer.querySelector('.button-container');
                buttonContainer.innerHTML = '<p class="removeContainer cursor-pointer text-2xl font-bold">-</p>';

                // Append the new container after the original container
                container.parentElement.appendChild(newContainer);
            });

            // Event listener for removing a container
            document.addEventListener('click', function (event) {
                if (event.target && event.target.classList.contains('removeContainer')) {
                    event.target.closest('.w-full.flex.items-center.justify-between.gap-3.mt-2').remove();

                    // Renumber the remaining containers
                    document.querySelectorAll('.w-full.flex.items-center.justify-between.gap-3.mt-2').forEach((item, index) => {
                        item.querySelectorAll('input').forEach(input => {
                            const name = input.getAttribute('name');
                            const newName = name.replace(/\d+/, index);
                            input.setAttribute('name', newName);
                        });
                    });
                }
            });
        });

    </script>
@endsection