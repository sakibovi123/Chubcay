@extends('admin.base')

@section('title', 'Create Plan')

@section('content')

<div class="w-full my-5 p-3 container md:mx-auto">
    
    <div class="w-full flex items-center justify-between gap-3">
        <h1 class="text-xl font-bold text-gray-700">CREATE PLAN</h1>
        <a href="{{ route('membership.index') }}" class="gont-bold text-white bg-blue-600 transition-all delay-5 hover:bg-sky-600 p-2 rounded-xl">GO BACK</a>
    </div>
    <form class="w-full my-7" action="{{ route('membership.store') }}" method="post">
        @csrf
        <div class="w-full">
            <label class="text-gray-600 font-bold text-md" for="">Title</label><br>
            <input required name="title" type="text" placeholder="Enter title..." class="p-2 rounded w-full border">
        </div>
        <div class="my-3 flex items-center jusitify-between gap-5">
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Sub title</label><br>
                <input required name="sub_title" type="text" placeholder="Enter sub title..." class="p-2 rounded w-full border">
            </div>
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Price</label>
                <input required name="price" id="price" type="text" placeholder="Enter price..." class="p-2 rounded w-full border">
            </div> 
        </div>

        <div class="my-3 flex items-center jusitify-between gap-5">
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Discount</label><br>
                <input name="discount" type="float" placeholder="discount" class="p-2 rounded w-full border">
            </div>
            <div class="w-full">
                <label class="text-gray-600 font-bold text-md" for="">Duration</label>
                <select required name="duration_title" class="p-2 rounded w-full border">
                    <option value="">Select plan</option>
                    <option value="monthly">Monthly</option>
                    <option value="quaterly">Quaterly</option>
                    <option value="yearly">Yearly</option>
                    
                </select>
            </div> 
        </div>

        <div class="w-full">
            <label class="text-gray-600 font-bold text-md" for="">Features</label>

            <div id="container">
                <div id="featureContainer" class="w-full flex items-center justify-between gap-3 mt-2">
                    <input required name="features[0][key]" placeholder="Enter key" class="w-full p-2 rounded border" type="text">
                    <input required name="features[0][value]" placeholder="Enter value" class="w-full p-2 rounded border" type="text">
                    <div class="button-container">
                        <p id="addContainer" class="cursor-pointer text-2xl font-bold">+</p>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="my-5 w-full flex items-center justify-between gap-3">
            <button class="text-white w-full rounded p-2 bg-green-500">Save</button>
            <button class="text-white w-full rounded p-2 bg-red-500">Back</button>
        </div>
        
    </form>
</div>
@endsection