@extends('admin.base')

@section('title', 'Home Page')

@section('content')
    <div class="w-full my-5 p-3 container md:mx-auto">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-xl font-bold">Manage Payments</h1>
            <div class="flex items-center gap-5">
                {{-- <a class="text-white bg-sky-500 p-2 rounded" href="{{ route('checkout.create') }}">
                    CREATE ORDER
                </a> --}}
                {{-- <a href="{{ route('checkout.invoice') }}">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M16.444 18H19a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h2.556M17 11V5a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v6h10ZM7 15h10v4a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-4Z"/>
                      </svg>  
                </a> --}}
                <a href="{{ route('payment.download') }}" class="p-2 bg-sky-600 rounded-xl text-white transition-all delay-5 hover:bg-sky-700">
                    DOWNLOAD PENDING PAYMENTS
                </a>
            </div>
            
        </div>
        <div class="w-full p-1 md:p-3 my-5">
            
            @if ($fees)
            <div class="md:max-w-full max-w-80 overflow-x-auto">
                <table class="w-full bg-white rounded">
                    <thead class="border-b-2">
                        <th class="p-3">CREATED AT</th>
                        <th class="p-3">CUSTOMER</th>
                        {{-- <th class="p-3">CUSTOMER</th> --}}
                        <th class="p-3">METHOD</th>
                        <th class="p-3">TERM</th>
                        <th class="p-3">TOTAL</th>
                        <th class="p-3">PAID</th>
                        <th class="p-3">DUE</th>  
                        <th class="p-3">PAYMENT STATUS</th>
                        <th class="p-2">ACTIONS</th>
                    </thead>
                    
                    <tbody class="text-center">
                        @foreach ($fees as $fee)
                            <tr class="border-b-2 border-gray-100 cursor-pointer transition-all delay-5 hover:bg-gray-50">
                                <td class="p-3">{{ $fee->created_at }}</td>
                                
                                
                                <td class="p-3">{{ $fee->user->first_name }}</td>
                                <td class="p-3 uppercase">{{ $fee->method }}</td>
                                <td class="p-3 uppercase">{{ $fee->term }}</td>
                                <td class="p-3">${{ $fee->total_charge }}</td>

                                <td class="p-3">
                                    @if ($fee->paid == 0)
                                        $0.00
                                    @else
                                        ${{ $fee->paid }}
                                    @endif
                                    
                                </td>

                                <td class="p-3">
                                    @if ($fee->due == 0)
                                        $0.00
                                    @else
                                        ${{ $fee->due }}
                                    @endif
                                    
                                </td>
                                
                                <td class="p-3">
                                    @if ($fee->payment_status == 'paid')
                                        <p class="bg-green-400 p-1 rounded-xl">{{ $fee->payment_status }}</p>
                                   
                                    @else
                                        <p class="bg-red-400 p-1 rounded-xl">{{ $fee->payment_status }}</p>
                                    @endif
                                </td>
                                <td class="p-3 flex items-center h-full justify-center gap-4">
                                    
                                    
                                    <a href="{{ route('payment.edit', $fee->id) }}">
                                        <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-yellow-600"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </a>
                                    
                                </td>
                            </tr>
                            
                        @endforeach
                        
                        
                    </tbody>
                </table>
            </div>
            
            @else
                <p class="text-2xl text-center font-bold">No Data Found!</p>
            @endif
            @if( $records )
                <h1 class="text-2xl font-bold my-5">Records</h1>
                    <div class="my-5 md:max-w-full max-w-80 overflow-x-auto">
                        <table class="w-full bg-white rounded">
                            <thead class="border-b-2">
                            <th class="p-3">CREATED AT</th>
                            <th class="p-3">CUSTOMER</th>
                            {{-- <th class="p-3">CUSTOMER</th> --}}

                            <th class="p-3">TOTAL</th>
                            <th class="p-3">PAID</th>
                            <th class="p-3">DUE</th>

                            <th class="p-2">ACTION</th>
                            </thead>

                            <tbody class="text-center">
                            @foreach ($records as $record)
                                <tr class="border-b-2 border-gray-100 cursor-pointer transition-all delay-5 hover:bg-gray-50">
                                    <td class="p-3">{{ $record->created_at }}</td>


                                    <td class="p-3">{{ $record->user->first_name }}</td>
{{--                                    <td class="p-3 uppercase">{{ $record->method }}</td>--}}
{{--                                    <td class="p-3 uppercase">{{ $fee->term }}</td>--}}
                                    <td class="p-3">${{ $record->total_amount }}</td>

                                    <td class="p-3">
                                        @if ($record->paid_amount == 0)
                                            $0.00
                                        @else
                                            ${{ $record->paid_amount }}
                                        @endif

                                    </td>

                                    <td class="p-3">
                                        @if ($record->due_amount == 0)
                                            $0.00
                                        @else
                                            ${{ $record->due_amount }}
                                        @endif

                                    </td>

{{--                                    <td class="p-3">--}}
{{--                                        @if ($fee->payment_status == 'paid')--}}
{{--                                            <p class="bg-green-400 p-1 rounded-xl">{{ $fee->payment_status }}</p>--}}

{{--                                        @else--}}
{{--                                            <p class="bg-red-400 p-1 rounded-xl">{{ $fee->payment_status }}</p>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
                                    <td class="p-3 flex items-center h-full justify-center gap-4">
                                        {{ $record->action }}

{{--                                        <a href="{{ route('payment.edit', $fee->id) }}">--}}
{{--                                            <svg class="w-6 h-6 text-gray-800 transition-all delay-10 hover:text-yellow-600"--}}
{{--                                                 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
{{--                                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>--}}
{{--                                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>--}}
{{--                                            </svg>--}}
{{--                                        </a>--}}

                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>
                    </div>
                @else
                <p>No Data found</p>
                @endif

            
        </div>
    </div>
@endsection