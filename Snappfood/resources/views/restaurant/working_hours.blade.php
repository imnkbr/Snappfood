@extends('layouts.restaurant')

@section('content')
    <div class="container mt-3">

        <h3 class="text-white text-center">Choose Your Restaurant Working Hours</h3>

        <form action="/restaurant/{{$restaurant->name}}/setting/restaurant_working_hours" method="POST">
            @csrf
            @method('POST')

            @foreach ($daysOfWeek as $day)
            <div class="mb-5">
                <div class="form-group row">
                    <label for="{{ $day }}is_open" class="col-md-4 col-form-label text-md-right text-white">{{ ucfirst($day) }}:</label>

                    <div class="col-md-6">
                        <input type="checkbox" id="{{ $day }}is_open" name="{{ $day }}is_open" value="1" {{ old($day . 'is_open') ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="{{ $day }}open" class="col-md-4 col-form-label text-md-right text-white">Open Time:</label>

                    <div class="col-md-6">
                        <input type="time" id="{{ $day }}open" name="{{ $day }}open" value="{{ old($day . 'open') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="{{ $day }}close" class="col-md-4 col-form-label text-md-right text-white">Close Time:</label>

                    <div class="col-md-6">
                        <input type="time" id="{{ $day }}close" name="{{ $day }}close" value="{{ old($day . 'close') }}">
                    </div>
                </div>
            </div>
            @endforeach


            <!-- Repeat for other days -->

            <button type="submit" class="btn btn-warning mt-2">Submit</button>
        </form>
@endsection
