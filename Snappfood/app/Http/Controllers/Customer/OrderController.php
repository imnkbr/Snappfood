<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;


class OrderController extends Controller
{
    private static $user;

    public function __construct()
    {
        $this::$user = auth()->guard('sanctum')->user();
    }

    public function getOrders()
    {
        if ($this::$user->customer->orders->count() == 0) {
            return response()->json(['error' => 'no order found'], 404);
        }
            return response()->json(['orders' => OrderResource::collection($this::$user->customer->orders)]);
    }

    public function addToOrder(Request $request)
    {

        $user = $this::$user;
        $customer = $user->customer;
        $order = $customer->orders->last();

        $foodId = $request->input('food_id');
        $quantity = $request->input('quantity');




        if ($order && !$order->is_finished) {
            $firstFood = $order->orderItems->first()->food;


            if ($firstFood->restaurant->name != Food::find($foodId)->restaurant->name) {
                return response()->json(['error' => 'This food belongs to another restaurant'], 403);
            }
        }


        if (!$order || !$order->is_finished || $firstFood->restaurant->name == Food::find($foodId)->restaurant->name) {
            $sumAmount = $order ? $order->sum_amount : 0;

            if (!$order) {

                $order = Order::create([
                    'customer_id' => $customer->id,
                    'sum_amount' => Food::find($foodId)->price * $quantity,
                ]);
            }


            OrderItem::create([
                'quantity' => $quantity,
                'food_id' => $foodId,
                'order_id' => $order->id,
            ]);


            $sumAmount += Food::find($foodId)->price * $quantity;
            $order->update(['sum_amount' => $sumAmount]);

            return response()->json(['msg' => 'Food added to cart successfully', 'cart_id' => $order->id]);
        }

        return response()->json(['error' => 'Unable to add food to cart.'], 403);

    }

    public function updateOrder(Request $request)
    {
        $user = $this::$user;
        $customer = $user->customer;
        $order = $customer->orders->last();
        $foodId = $request->input('food_id');
        $newQuantity = $request->input('quantity');



        if ($order && !$order->is_finished) {

            $orderItem = $order->orderItems()->where('food_id', $foodId)->first();

            if ($orderItem) {

                $orderItem->update(['quantity' => $newQuantity]);

                $order->update(['sum_amount' => Food::find($foodId)->price * $newQuantity]);

                return response()->json(['msg' => 'Cart updated successfully', 'cart_id' => $order->id]);
            } else {
                return response()->json(['error' => 'Food item not found in the cart'], 404);
            }
        }

        return response()->json(['error' => 'Unable to update cart.'], 403);
    }

    public function getSingleOrder(string $id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return response()->json(['error' => 'order Not found'], 404);
        }

        if($order->customer_id == $this::$user->customer->id ){
            return response()->json(['order' => OrderResource::make($order)]);
        }else{
            return response()->json(['error' => 'Forbidden'] , 403);
        }
    }

    public function pay(string $id)
    {
        $order = Order::find($id);

        if ($order == null){
            return response()->json(['error' => 'Not Found'] , 404);
        }

        if ($order->is_finished){
            return response()->json(['error' => 'You payed for this order before'] , 422);
        }

        if ($order->customer_id != $this::$user->customer->id){
            return response()->json(['error' => 'This Order Belongs To Another Person'] , 403);
        }



        $order->update([
            'is_finished' => true
        ]);

        return response()->json(['msg' => 'Payment was successful']);

    }
}
