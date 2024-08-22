<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Snappfood</title>
</head>
<body style="background-image: url({{asset('pictures/restaurant_background.jpg')}});
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, Helvetica, sans-serif" class="bg-dark">
@if($restaurant->is_completed == false)
<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <div class="container-fluid">
        <a class="navbar-brand text-uppercase">Snappfood</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="/restaurant/{{$restaurant->name}}/setting">Restaurant Settings </a>
                </li>
            </ul>
        </div>
        <div>
            <form action="/admin/logout" method="POST">
                @csrf
                <button class="btn-sm btn btn-danger btn-link text-decoration-none text-white" type="submit">Logout</button>
            </form>

        </div>
    </div>
</nav>
@else
<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <div class="container-fluid">
        <a class="navbar-brand text-uppercase">Snappfood</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="/restaurant/{{$restaurant->name}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="/restaurant/{{$restaurant->name}}/foods">Foods</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="/restaurant/{{$restaurant->name}}/comments">Comments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="/restaurant/{{$restaurant->name}}/setting">Restaurant Settings </a>
                </li>
            </ul>
        </div>
        <div>
            <form action="/admin/logout" method="POST">
                @csrf
                <button class="btn-sm btn btn-danger btn-link text-decoration-none text-white" type="submit">Logout</button>
            </form>

        </div>
    </div>
</nav>
@endif
@yield('content')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script></html>

