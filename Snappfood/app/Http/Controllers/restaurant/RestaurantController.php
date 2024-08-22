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

        $this->authorize('orders', $restaurant);

        return view('restaurant.dashboard' , [
            'restaurant' => $restaurant,
            'orders' => $orders
        ]);

    }

    public function ordersUpdate(Request $request, string $name , int $id )
    {
        $restaurant = Restaurant::where('name' , $name)->first();

        $this->authorize('ordersUpdate', $restaurant);

        Order::where('id' , $id)->update([
            'status' => $request->input('status')
        ]);

        return redirect()->route('restaurant.dashboard' , [
            'name' => $name
            ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
