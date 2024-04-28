@extends('layouts.admin')
@section('content')
    <div class="container mt-4">

        <h2>Create Discount</h2>
        <form action="/admin/discounts" method="post">
            @csrf

            <div class="mb-3">
                <label for="food_id" class="form-label">Select Food:</label>
                <select class="form-select" name="food_id">
                    @foreach($foods as $food)
                        <option value="{{ $food->id }}">{{ $food->name }} from {{ $food->restaurant->name}} restaurant</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="percent" class="form-label">Percent:</label>
                <input type="number" class="form-control" name="percent">
            </div>


            <button type="submit" class="btn btn-primary">Create Discount</button>
        </form>
    </div>
    <br><br>
    @if($errors)
            <div class="mt-4 text-left">
                @foreach($errors->all() as $error)
                    <li class="text-danger">
                        {{$error}}
                    </li>
                @endforeach
            </div>
    @endif
@endsection
