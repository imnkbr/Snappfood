@extends('layouts.restaurant')

@section('content')
    <div class="container mt-4">

        <form action="/restaurant/{{$restaurant->name}}/setting/status" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label mt-4 text-white bg-info text-uppercase">RESTAURANT IS {{ $restaurant->is_open}}</label>
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                </svg>
                <i class="bi bi-arrow-right"></i>
                <button type="submit" class="btn btn-warning mx-2 p-sm-1">Change</button>
            </div>

        </form>


        <form action="/restaurant/{{$restaurant->name}}/setting/complete_restaurant_details" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <h3 class="text-white">Complete Restaurant Details:</h3>

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ $restaurant->name }}">
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input id="phone_number" name="phone_number" type="number" class="form-control" value="{{ $restaurant->phone_number }}">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <textarea id="address" name="address" class="form-control">{{$restaurant->address}}</textarea>
            </div>

            <div class="mb-3">
                <label for="account_number" class="form-label">Account Number:</label>
                <input id="account_number" name="account_number" type="number" class="form-control" value="{{ $restaurant->account_number }}">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <h3 class="text-white mt-4 mb-2">Complete Restaurant Type & Working Hours Of Restaurant:</h3>

        <div class="d-flex justify-content-evenly m-3">
            <a href="/restaurant/{{$restaurant->name}}/setting/working_hours" class="btn btn-secondary text-white">Working Hours</a>
            <a href="/restaurant/{{$restaurant->name}}/setting/type_of_restaurant" class="btn btn-secondary text-white">Type Of Restaurant</a>
        </div>


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
