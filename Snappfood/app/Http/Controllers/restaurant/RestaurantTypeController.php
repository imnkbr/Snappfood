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

        return view('restaurant.type_of_restaurant')->with(['restaurant' => $restaurant ,'typeOfRestaurants' => $typeOfRestaurants]);
    }

    public function create(string $name , Request $request)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        $request->validate([
            'types' => ['required',new TypeOfRestaurantRule]
        ]);

    }

}
