@extends('layouts.restaurant')
@section('content')


<div class=" p-4 mb-4 text-center">
    <h1 class="text-white">Create New Food</h1>
</div>


<form action="/restaurant/{{$restaurant->name}}/foods" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="mb-3 mt-3">
        <label class="form-label text-white">Food Name:</label>
        <input type="text" class="form-control" name="name">
    </div>

    <div class="mb-3">
        <label class="form-label text-white">Material:</label>
        <textarea class="form-control" name="material"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label text-white">Price:</label>
        <input type="text" class="form-control" name="price">
    </div>

    <div class="mt-3">
        <label class="form-label text-white">Add Your Type Of Food:</label>
        <select class="form-select" name="type_of_food">
            @foreach($typeOfFoods as $typeOfFood)
                <option value="{{$typeOfFood->type}}">{{$typeOfFood->type}}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
@endsection
