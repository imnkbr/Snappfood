<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RestaurantController extends Controller
{
    public function index(string $name)
    {
        $orders = Order::where('is_finished' , false)->where('status', '!=' , 'delivered' )->get();
        $restaurant = Restaurant::where('name' , $name)->first();

        return view('restaurant.dashboard' , [
            'restaurant' => $restaurant,
            'orders' => $orders
        ]);

    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
