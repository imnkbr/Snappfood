<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Http\Resources\RestaurantResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Comment;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Cache;

class RestaurantController extends Controller
{
    public function getSingleRestaurant(string $id)
    {
        try {

            $restaurant = Restaurant::findOrFail($id);


            $restaurantData = RestaurantResource::make($restaurant);

            return response()->json([
                'status' => 'success',
                'data' => $restaurantData
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Restaurant not found',
            ], 404);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function getRestaurants(Request $request)
    {


        try {

            $is_open = $request->query('is_open');

            $type = $request->query('type');

            $score = $request->query('score');

            $query = Restaurant::query();

            // Apply 'is_open' filter if provided
            if (!is_null($is_open) && in_array($is_open, ['open', 'close'])) {
                $query->where('is_open', $is_open);
            }

            // Apply 'type' filter if provided
            if (!is_null($type)) {
                $query->whereHas('restaurantTypes.typeOfRestaurant', function ($query) use ($type) {
                    $query->where('type', 'like', '%' . $type . '%');
                });
            }

            // Apply 'score' filter if provided
            if (!is_null($score) && is_numeric($score) && $score >= 0 && $score <= 5) {
                $query->whereHas('foods.orderItems.order.comments', function ($query) use ($score) {
                    $query->where('score', $score);
                });
            }

            // Get the filtered results
            $restaurants = $query->get();

            return response()->json([
                'status' => 'success',
                'data' => $restaurants
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getFoods(string $id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant not found'], 404);
        }

        $restaurant->load('foods.typeOfFood');

        $foodTypes = $restaurant->foods->pluck('typeOfFood.type','typeOfFood.id')->unique();

        $result = $foodTypes->map(function ($type , $id) use ($restaurant){
        $foodsForType = $restaurant->foods->where('type_of_food_id', $id)->where('is_deleted' , false);

            return [
              'id' => $id,
              'type' => $type,
                'foods' => FoodResource::collection($foodsForType),
            ];
        })->values()->toArray();

        return response()->json($result);
    }
}
