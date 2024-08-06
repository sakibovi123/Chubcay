@extends('admin.base')

@section('title', 'Home Page')

@section('content')
    <div class="w-full my-5 p-3 container md:mx-auto">
        <div class="flex items-center justify-between gap-5">
            <div class="bg-white p-5 border border-orange-100 w-full rounded-xl">
                <p class="text-sm text-gray-400">Revenue</p>
                <h1 class="font-bold text-3xl">${{ $totalRevenue }}</h1>
                <p class="text-green-500 flex items-center gap-3">
                    68% increase
                    <svg class="w-5 h-5 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
                      </svg>
                      
                </p>
            </div>

            <div class="bg-white p-5 border border-orange-100 w-full rounded-xl">
                <p class="text-sm text-gray-400">New customers</p>
                <h1 class="font-bold text-3xl">{{ $totalCustomers }}</h1>
                <p class="text-green-500 flex items-center gap-3">
                    35% increase
                    <svg class="w-5 h-5 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
                      </svg>
                      
                </p>
            </div>

            <div class="bg-white p-5 border border-orange-100 w-full rounded-xl">
                <p class="text-sm text-gray-400">New orders</p>
                <h1 class="font-bold text-3xl">{{ $totalOrders }}</h1>
                <p class="text-red-500 flex items-center gap-3">
                    15% deacrease
                    <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207"/>
                      </svg>
                      
                      
                </p>
            </div>
        </div>
        {{-- order table --}}
        <div class="w-full bg-white rounded-xl shadow-md p-3 my-5">
            <div class="w-full flex items-center justify-between gap-2">
                <h1 class="uppercase p-2 text-lg font-semibold">Latest Orders</h1>
                <a href="{{ route('checkout.index') }}" class="font-semibold p-2 bg-blue-600 text-white rounded-full uppercase">Go to all orders</a>
            </div>
            
            @if ($orders)
            <table class="w-full my-4">
                <thead class="w-full bg-gray-100 border-b-2">
                    <th class="p-3">CREATED AT</th>
                    <th class="p-3">ORDER ID</th>
                    {{-- <th class="p-3">CUSTOMER</th> --}}
                    <th class="p-3">TOTAL</th>
                    {{-- <th class="p-3">CUSTOMER</th>
                    <th class="p-3">GRAND TOTAL</th> --}}
                    <th class="p-3">PAYMENT STATUS</th>
                    {{-- <th class="p-2">ACTIONS</th> --}}
                </thead>
                
                <tbody class="text-center">
                    @foreach ($orders as $order)
                        <tr class="border-b-2 border-gray-100 cursor-pointer transition-all delay-5 hover:bg-gray-50">
                            <td class="p-3">{{ $order->created_at }}</td>
                            <td class="p-3">{{ $order->trx_id }}</td>
                            {{-- <td class="p-3">DAATA</td> --}}
                            {{-- <td class="p-3">{{ $order->package->duration_title }}</td> --}}
                            {{-- <td class="p-3">{{ $order->user->first_name }} {{ $order->user->last_name }}</td> --}}
                            <td class="p-3">${{ $order->grand_total }}</td>
                            
                            <td class="p-3">
                                @if ($order->status == 'Success')
                                    <p class="bg-green-400 p-1 rounded-xl">{{ $order->payment_status }}</p>
                                @elseif ( $order->status == 'Pending' )
                                    <p class="bg-yellow-400 p-1 rounded-xl">{{ $order->status }}</p>
                                @elseif ( $order->status == 'Returned' )
                                    <p class="bg-red-400 p-1 rounded-xl">{{ $order->status }}</p>
                                @else
                                    <p class="bg-red-400 p-1 rounded-xl">{{ $order->status }}</p>
                                @endif
                            </td>
                            <td class="p-3 flex items-center h-full justify-center gap-4">
                                {{-- <a href="{{ route('membership.edit', $plan->slug) }}">
                                    <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                </svg>
                                </a> --}}
                                
                                {{-- <a href="{{ route('checkout.details', $order->id) }}">
                                    <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-yellow-600"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </a>
                                <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                        </svg>
                                    </button>
                                    
                                </form> --}}
                                
                            </td>
                        </tr>
                    @endforeach
                    
                    
                </tbody>
            </table>
            @else
                <p class="text-2xl text-center font-bold">No Data Found!</p>
            @endif
        </div>

        {{-- order table ends --}}
    </div>


    
@endsection
