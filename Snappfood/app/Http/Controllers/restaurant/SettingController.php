<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\TypeOfRestaurant;
use App\Models\RestaurantType;
use App\Http\Requests\RestaurantDetailsRequest;

class SettingController extends  Controller
{
    public function index(string $name)
    {
        $restaurant = Restaurant::where('name' , $name)->first();
        $typesOfRestaurant = TypeOfRestaurant::all();

        return view('restaurant.setting')->with(['restaurant' => $restaurant ,'typesOfRestaurant' => $typesOfRestaurant]);

    }

    public function completeRestaurantDetails(string $name , Request $request)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        $request->validate([
            'name' =>'required',
            'phone_number' => 'required',
            'address' => 'required',
            'account_number' => 'required',
        ]);

        $restaurant->update([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'account_number' => $request->input('account_number'),
            ]);

        $restaurant->is_completed = true;
        $restaurant->save();

        return view('restaurant.setting')->with(['restaurant' => $restaurant]);
    }

    public function restaurantStatus(string $name)
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        if ($restaurant->is_open == 'open'){
            $restaurant->update([
            'is_open' => 'close'
            ]);
        }else{
            $restaurant->update([
            'is_open' => 'open'
            ]);
        }
        return redirect()->back();
    }


}
