@extends('layouts.restaurant')
@section('content')


<div class=" p-4 mb-4 text-center">
        <h1 class="text-white">Comments</h1>
</div>

    <div class="container">
        @foreach($comments as $comment)
        @if($comment->order->orderItems->first()->food->restaurant->name == $restaurant->name)
        <div class="bg-light p-3 mb-3 rounded">
            <ul class="list-unstyled">
                <li>Customer Name: <strong>{{$comment->customer->user->name}}</strong></li>
                <li>Score: {{$comment->score}}</li>
                <li>Opinion: {{$comment->opinion}}</li>
                <li>response : {{$comment->response}}</li>
                <ul class="list-unstyled mt-2">
                    <h3>Order Items:</h3>
                    @foreach($comment->order->orderItems as $orderItem)
                        <li>Food Name: {{$orderItem->food->name}}</li>
                        <li>Quantity: {{$orderItem->quantity}}</li>
                    @endforeach
                </ul>
            </ul>

            <form action="/restaurant/{{ $restaurant->name }}/comments/{{$comment->id}}" method="POST" class="d-inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger btn-sm me-2">Delete</button>
            </form>

            <form action="/restaurant/{{ $restaurant->name }}/comments/{{$comment->id}}" method="POST" class="d-inline">
                @method('PUT')
                @csrf
                <button type="submit" class="btn btn-primary btn-sm me-2">Confirm</button>
            </form>
            
            <form action="/restaurant/{{ $restaurant->name }}/comments/{{$comment->id}}" method="POST" class="d-inline">
                @method('POST')
                @csrf
                <div class="input-group mt-2">

                    <button type="submit" class="btn btn-info btn-sm text-white">Send Response</button>
                    <input type="text" name="response" class="form-control">

                </div>
            </form>

        </div>
        @endif
        @endforeach
    </div>

@endsection
