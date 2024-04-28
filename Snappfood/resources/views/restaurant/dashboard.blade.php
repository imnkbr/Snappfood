@extends('layouts.restaurant')
@section('content')
    <div class=" p-4 mb-4 text-center">
        <h1 class="text-white">ORDERS:</h1>
    </div>

    <div class="container">
        @foreach($orders as $order)
            @if($order->orderItems->first()->food->restaurant->name == $restaurant->name)
                <div class="bg-light p-3 mb-3 rounded">
                    <ul class="list-unstyled">
                        <li class="mb-2">Customer Name: {{$order->customer->user->name}}</li>
                        <ul class="list-unstyled">
                            @foreach($order->orderItems as $orderItem)
                                <li class="mb-2">Foods:{{$orderItem->food->name}}</li>
                                <li class="mb-2">Quantity:{{$orderItem->quantity}}</li>
                            @endforeach
                        </ul>
                        <li class="mb-2">Sum Amount: {{$order->sum_amount}}</li>
                        <li class="mb-2">Status: {{$order->status}}</li>
                    </ul>
                </div>
            @endif
        @endforeach
    </div>

@endsection
