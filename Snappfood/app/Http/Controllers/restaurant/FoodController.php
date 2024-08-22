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

    public function create(string $name)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        $typeOfFoods = TypeOfFood::all();

        $this->authorize('foodCreate' , $restaurant);

        return view('restaurant.foods_create',[
            'restaurant' => $restaurant,
            'typeOfFoods' => $typeOfFoods
        ]);
    }

    public function addFood(string $name , Request $request)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        $this->authorize('foodCreate' , $restaurant);

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


    public function edit( string $name , string $id)
    {
        $typeOfFoods = TypeOfFood::all();

        $restaurant = Restaurant::where('name' , $name)->first();

        $this->authorize('foodUpdate' , $restaurant);

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

        $this->authorize('foodUpdate' , $restaurant);

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

    public function delete(string $name,string $id)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        $this->authorize('foodDelete' , $restaurant);

        Food::find($id)->update([
            'is_deleted' => true
        ]);
        return redirect("/restaurant/$restaurant->name/foods")->with(['restaurant' => $restaurant]);
    }

    public function search(Request $request)
    {
        $name = $request->input('search_name');


        $restaurant = Restaurant::where('name' , $name)->first();



        $type = $request->input('search_type');

        $query = Food::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($type) {
            $query->where('type_of_food_id', $type);
        }

        $foods = $query->get();
        $typeOfFoods = TypeOfFood::all();

        return view('restaurant.foods',[
            'restaurant'=>$restaurant ,
            'foods' =>$foods,
            'typeOfFoods' => $typeOfFoods
        ]);
    }
}
