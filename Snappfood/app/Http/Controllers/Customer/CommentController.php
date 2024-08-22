<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Food;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    private function sendErrorResponse($errors, $status = 422)
    {
        return response()->json(['errors' => $errors], $status);
    }

    public function getComments(Request $request)
    {
        $food_id = $request->input('food_id');
        $restaurant_id = $request->input('restaurant_id');

        if ($food_id == null and $restaurant_id == null) {
            return response()->json(['error' => 'You must enter a value at least']);
        }

        if ($food_id != null and $restaurant_id == null){
            if (Food::find($food_id) == null) {
                return response()->json(['error' => 'Not Found'] , 404);
            }

            $comments = Comment::whereHas('order.orderItems.food', function ($query) use ($food_id) {
                $query->where('foods.id', $food_id);
            })->where('is_confirmed' , true)->get();

            return response(['comments' =>CommentResource::collection($comments)]);
        }

       if ($restaurant_id != null and $food_id == null){
           if (Restaurant::find($restaurant_id) == null){
                return response()->json(['error' => 'Not Found'] , 404);
           }

           $comments = Comment::whereHas('order.orderItems.food.restaurant', function ($query) use ($restaurant_id) {
               $query->where('restaurants.id', $restaurant_id);
           })->where('is_confirmed' , true)->get();

           return response(['comments' =>CommentResource::collection($comments)]);

       }

       if ($restaurant_id != null and $food_id!= null){

           $comments = Comment::whereHas('order.orderItems.food.restaurant', function ($query) use ($restaurant_id , $food_id) {
               $query->where('restaurants.id', $restaurant_id)->where('foods.id' , $food_id);
           })->where('is_confirmed' , true)->get();

           return response(['comments' =>CommentResource::collection($comments)]);
       }

       return response()->json(['error' => 'internal server error'] , 500);

    }

    public function addComment(Request $request)
    {
        try {
            $rules = [
                'order_id' => 'required',
                'score' => 'required|integer|min:0|max:5',
                'opinion' => 'required|string|min:5|max:100'
            ];

            $validatedData = $request->validate($rules);


            $order = Order::find($validatedData['order_id']);

            if ($order == null){
                return response()->json(['error' => 'Order not found'] , 404);
            }

            if ($order->customer_id != auth()->guard('sanctum')->user()->customer->id){
                return response()->json(['error' => 'This order belongs to another person'] , 403);
            }

            if (!$order->is_finished){
                return response()->json(['error' => 'you must finish order first'] , 401);
            }

            Comment::create([
                'order_id' => $validatedData['order_id'],
                'score' => $validatedData['score'],
                'opinion' => $validatedData['opinion'],
                'customer_id' => auth()->guard('sanctum')->user()->customer->id

            ]);

            return response()->json(['msg' => 'comment added successfully']);
        }catch (ValidationException $e){
            return $this->sendErrorResponse($e->errors() , $e->status);
        }
    }
}
