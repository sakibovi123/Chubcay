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

        </div>

        <div class="my-5 w-full flex items-center justify-between gap-3">
            <button class="text-white w-full rounded p-2 bg-green-500">Save</button>
            <a href="{{ route('users.index') }}" class="text-center text-white w-full rounded p-2 bg-red-500">Back</a>
        </div>
        
    </form>
</div>
@endsection