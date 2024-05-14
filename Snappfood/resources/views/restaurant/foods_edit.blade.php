@extends('layouts.restaurant')
@section('content')

<div class=" p-4 mb-4 text-center">
    <h1 class="text-white">Edit Food</h1>
</div>

@if($food and !$food->is_deleted)
        @if($food->restaurant_id == $restaurant->id)
    <form action="/restaurant/{{$restaurant->name}}/foods/{{$food->id}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="mb-3 mt-3">
            <label class="form-label text-white">Food Name:</label>
            <input type="text" class="form-control" name="name" value="{{$food->name}}">
        </div>

        <div class="mb-3">
            <label class="form-label text-white">Material:</label>
            <textarea class="form-control" name="material">{{$food->material}}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label text-white">Price:</label>
            <input type="text" class="form-control" name="price" value="{{$food->price}}">
        </div>

        <div class="mt-3">
            <label class="form-label text-white">Change Type Of Food:</label>
            <select class="form-select" name="type_of_food">
                @foreach($typeOfFoods as $typeOfFood)
                    <option value="{{$typeOfFood->type}}">{{$typeOfFood->type}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
    @else
        <h3>not exist</h3>
        @endif
    @endif

@endsection
