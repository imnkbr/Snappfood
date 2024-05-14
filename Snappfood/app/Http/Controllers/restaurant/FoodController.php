<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Food;
use App\Models\TypeOfFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function index(string $name)
    {
        $restaurant = Restaurant::where('name' , $name)->first();
        $typeOfFoods = TypeOfFood::all();
        $foods = Food::where('restaurant_id' , $restaurant->id)->where('is_deleted',false)->get();

        return view('restaurant.foods',[
            'restaurant'=>$restaurant ,
            'foods' =>$foods,
            'typeOfFoods' => $typeOfFoods]);
    }


    public function edit( string $name , string $id)
    {
        $typeOfFoods = TypeOfFood::all();
        $restaurant = Restaurant::where('name' , $name)->first();

        $food = Food::find($id);
        return view('restaurant.foods_edit' , [
            'restaurant' => $restaurant,
            'food' => $food,
            'typeOfFoods' => $typeOfFoods
        ]);
    }

    public function update( string $name , string $id , Request $request)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        Food::where('id' , $id)->update([
            'name' => $request->input('name'),
            'material' => $request->input('material'),
            'price' => $request->input('price'),
            'type_of_food_id' => TypeOfFood::where('type',$request->input('type_of_food'))->first()->id,
            'restaurant_id' => $restaurant->id,
            'is_deleted' => false
        ]);

        return redirect("/restaurant/$restaurant->name/foods")->with(['restaurant' => $restaurant]);
    }

    public function create(string $name)
    {
        $restaurant = Restaurant::where('name' , $name)->first();
        $typeOfFoods = TypeOfFood::all();

        return view('restaurant.foods_create',[
            'restaurant' => $restaurant,
            'typeOfFoods' => $typeOfFoods
        ]);
    }

    public function addFood( string $name , Request $request)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        Food::create([
            'name' => $request->input('name'),
            'material' => $request->input('material'),
            'price' => $request->input('price'),
            'type_of_food_id' => TypeOfFood::where('type',$request->input('type_of_food'))->first()->id,
            'restaurant_id' => $restaurant->id,
            'is_deleted' => false
        ]);

        return redirect("/restaurant/$restaurant->name/foods")->with(['restaurant' => $restaurant]);
    }

    public function delete(string $name,string $id)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        Food::find($id)->update([
            'is_deleted' => true
        ]);
        return redirect("/restaurant/$restaurant->name/foods")->with(['restaurant' => $restaurant]);
    }

    public function search(Request $request)
    {
        $foodNames = Food::distinct()->pluck('name')->toArray();
        $foodTypes = TypeOfFood::distinct()->pluck('type')->toArray();

        $searchName = $request->input('search_name');
        $searchType = $request->input('search_type');

        $foodsQuery = Food::query();
        $foodsTypeQuery = TypeOfFood::query();

        if ($searchName) {
            $foodsQuery->where('name', $searchName);
        }

        if ($searchType) {
            $foodsTypeQuery->where('type', $searchType);
        }

        $foods = $foodsQuery->paginate(10);

        return view('foods.index', compact('foods', 'searchName', 'searchType', 'foodNames', 'foodTypes'));
    }
}
