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
            <h1 class="text-xl font-bold text-gray-700">CREATE MEMBER</h1>
            <a href="{{ route('types.index') }}" class="gont-bold text-white bg-blue-600 transition-all delay-5 hover:bg-sky-600 p-2 rounded-xl">GO BACK</a>
        </div>
        <form class="w-full my-7" action="{{ route('types.store') }}" method="post">
            @method('post')
            @csrf
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Membership Type</label><br>
                <input required name="name" type="text" placeholder="Enter..." class="p-2 rounded w-full border">
            </div>


            <div class="my-5 w-full flex items-center justify-between gap-3">
                <button type="submit" class="text-white w-full rounded p-2 bg-green-500">Save</button>
                <a href="{{ route('types.index') }}" class="text-center text-white w-full rounded p-2 bg-red-500">Back</a>
            </div>

        </form>
    </div>

@endsection