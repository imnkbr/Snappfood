@extends('layouts.auth')

@section('content')
    <section class="container-sm">
        <div class="m-5 py-2 bg-light">
            <h1 class=" text-center fs-1 mt-2 text-dark">Welcome to the snappfood</h1>
        </div>
        <div class="m-5 py-2 bg-light">
            <p class="text-center text-danger fs-4 mt-2">Sign up for free and start ordering now!</p>
        </div>

        <div class="d-flex justify-content-between my-5 mx-auto pt-auto " style="width: 500px">
            <button class="btn btn-lg btn-secondary" style="width: 200px">
                <a href="/login" class="text-light">Login</a>
            </button>
            <button class="btn btn-lg btn-secondary" style="width: 200px ">
                <a href="/register" class="text-light">Register</a>
            </button>
        </div>
    </section>
@endsection

