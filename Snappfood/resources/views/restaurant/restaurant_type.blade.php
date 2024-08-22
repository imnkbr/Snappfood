@extends('layouts.restaurant')

@section('content')
    <div class="container mt-3">

        <h3 class="text-white text-center">Choose Your Restaurant Type</h3>

        <form action="/restaurant/{{$restaurant->name}}/setting/restaurant_type" method="post">
            @csrf
            @foreach($typeOfRestaurants as $typeOfRestaurant)
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="exampleCheckbox" name="types[]" value="{{$typeOfRestaurant->id}}">

                        <label class="form-check-label text-white" for="exampleCheckbox">
                            <strong>{{$typeOfRestaurant->type}}</strong>
                        </label>

                    </div>
                </div>

            @endforeach
            <button type="submit" class="btn btn-warning mt-2">Submit</button>

        </form>

        <h3 class="text-white text-center">Selected Type Of Restaurant</h3>
        @foreach($restaurant->restaurantTypes as $restaurantType)
            <form action="/restaurant/{{$restaurant->name}}/setting/restaurant_type/{{$restaurantType->id}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="mb-3 text-white">
                    <h4>{{$restaurantType->typeOfRestaurant->type}}</h4>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        @endforeach

        @if($errors->any())
            <div class="alert alert-danger text-center">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $error)
                        <li class="text-warning">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
@endsection
