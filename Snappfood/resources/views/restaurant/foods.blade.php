@extends('layouts.restaurant')
@section('content')


    <div class=" p-4 mb-4 text-center">
        <h1 class="text-white">Food</h1>
    </div>
    <div class=" p-4 mb-4 text-center justify-content-sm-around">
        <h5 class="text-white">Create New Food:</h5>
        <a href="/restaurant/{{$restaurant->name}}/foods/foods_create" class="mb-1 mt-2 btn btn-primary btn-link text-decoration-none text-white ms-2">Add</a>
    </div>

    <div class=" p-4 mb-4 m-5 justify-content-around">
        <form action="/restaurant/{{ $restaurant->name }}/foods/search" method="GET">
            <div class="form-row text-center">
                <div class="form-group col-md-4 m-auto">
                    <h5 class="text-white">Search Food Name</h5>
                    <input type="text" class="form-control" name="search_name" placeholder="Search by name" value="{{ request('search_name') }}">
                </div>
                <div class="form-group col-md-4 m-auto mt-3">
                    <h5 class="text-white">Search Food Type</h5>
                    <select class="form-control" name="search_type">
                        <option class="text-dark" value="">Select Type</option>
                        @foreach($typeOfFoods as $typeOfFood)
                            <option value="{{ $typeOfFood->id }}" {{ request('search_type') == $typeOfFood->id ? 'selected' : '' }}>
                                {{ $typeOfFood->type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4 m-auto mt-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>


    <div class="container">
        @foreach($foods as $food)
            @if($food->restaurant_id == $restaurant->id)
                <div class="bg-light p-3 mb-3 rounded">
                    <ul class="list-unstyled">
                        <li class="mb-2">Food Name: {{$food->name}}</li>

                        <li class="mb-2">Material: {{$food->material}}</li>

                        <li class="mb-2">Price: {{$food->price}}</li>

                        <form action="/restaurant/{{$restaurant->name}}/foods/{{$food->id}}" method="POST">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger">Delete</button>
                        </form>

                        <a href="/restaurant/{{$restaurant->name}}/foods/{{$food->id}}" class="mb-1 mt-2 btn btn-info btn-link text-decoration-none text-white ms-2">Edit</a>



                    </ul>
                </div>
            @endif
        @endforeach
    </div>








@endsection
