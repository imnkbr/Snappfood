@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h2 class="text-center mt-3">FOOD TYPES:</h2>
    </div>
    @foreach($types as $type)
        <div class="container mt-3">

            <div class="text-white col-md-6 m-auto text-end d-flex justify-content-around">
                <div class="row">
                    <h2>{{$type->type}}</h2>
                </div>
                <form action="/admin/food_types/{{$type->id}}" method="POST">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
                <form action="/admin/food_types/{{$type->id}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="text" name="type">
                    <button type="submit" class=" mb-1 btn-sm btn btn-info btn-link text-decoration-none text-white ms-2">Edit</button>
                </form>
            </div>
    @endforeach
        <div class="col-md-6">
            <div class="col-12 mt-3 mb-3">
                <h4>Add new food type:</h4>
                <form action="/admin/food_types" method="POST">
                    @csrf
                    <input  type="text" name="type">
                    <button  class="mb-1 btn btn-info btn-sm btn-link text-decoration-none text-white">Add</button>
                </form>
            </div>
        </div>
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
