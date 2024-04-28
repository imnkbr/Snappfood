@extends('layouts.restaurant')

@section('content')
    <div class="container mt-3">

        <h3 class="text-white text-center">Choose Type Of Restaurant:</h3>

        <form action="/restaurant/{{$restaurant->name}}/settings/restaurant_type" method="post">
            @csrf
            @foreach($typeOfRestaurants as $typeOfRestaurant)
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="exampleCheckbox" name="types" value="{{$typeOfRestaurant->id}}">

                    <label class="form-check-label" for="exampleCheckbox">
                        <strong>{{$typeOfRestaurant->type}}</strong>
                    </label>

                </div>
            </div>
            @endforeach


        </form>

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
