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
                    <h1 class="text-md font-bold">Grand total:</h1>
                    <p class="text-md font-semibold">${{ $order->grand_total }}</p>
                </div>
                
            </div>
            
        </div>
            
    </div>
@endsection