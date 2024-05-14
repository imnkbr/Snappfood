<?php


namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantType;
use App\Models\TypeOfRestaurant;
use App\Rules\TypeOfRestaurantRule;
use Illuminate\Http\Request;


class RestaurantTypeController extends Controller
{
    public function index(string $name)
    {
        $restaurant = Restaurant::where('name' , $name)->first();
        $typeOfRestaurants = TypeOfRestaurant::all();

        return view('restaurant.restaurant_type')->with(['restaurant' => $restaurant ,'typeOfRestaurants' => $typeOfRestaurants]);
    }

    public function create(string $name , Request $request)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        $request->validate([
            'types' => ['required',new TypeOfRestaurantRule]
        ]);

        RestaurantType::create([
            'type_of_restaurant_id' => $request->input('types'),
            'restaurant_id' => $restaurant->id
        ]);
        return redirect()->back();

    }

    public function delete(string $name , int $id)
    {
        RestaurantType::where('id' , $id)->delete();

        $restaurant = Restaurant::where('name' , $name)->first();

        return redirect()->back();
    }

}
