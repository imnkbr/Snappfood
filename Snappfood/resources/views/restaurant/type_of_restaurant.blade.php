@extends('layouts.restaurant')

@section('content')

<div class="container mt-3">
    <div class="text-center">
        <h2 class="text-white">Type Of Restaurant</h2>
    </div>
    <h4>Choose Restaurant Type:</h4>
    <form action="restaurant/{{$restaurant->name}}/setting/type_of_restaurant" method="post">

        @csrf
        @foreach



    </form>





</div>

@endsection
