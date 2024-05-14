<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantHour;
use Illuminate\Http\Request;


class RestaurantWorkingHoursController extends Controller
{
    public function index(string $name)
    {
        $restaurant = Restaurant::where('name' , $name)->first();
        $daysOfWeek = ['sunday' , 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $restaurantHours =  RestaurantHour::all();

        return view('restaurant.working_hours')->with(['restaurant'=>$restaurant , 'restaurantHours'=>$restaurantHours , 'daysOfWeek'=>$daysOfWeek]);
    }

    public function create(string $name , Request $request)
    {
        $restaurant = Restaurant::where('name' , $name)->first();


        $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($daysOfWeek as $day) {

            $isOpenKey = $day . 'is_open';
            $openTimeKey = $day . 'open';
            $closeTimeKey = $day . 'close';

            if ($request->has($isOpenKey)) {
                $isOpen = $request->input($isOpenKey);
                $openTime = $request->input($openTimeKey);
                $closeTime = $request->input($closeTimeKey);

                $workingHour = RestaurantHour::where('day', $day)->first();

                if ($workingHour) {
                    $workingHour->update([
                        'is_open' => $isOpen,
                        'open' => $openTime,
                        'close' => $closeTime,
                        'restaurant_id' => $restaurant->id
                    ]);
                } else {
                    // Create a new record
                    RestaurantHour::create([
                        'day' => $day,
                        'is_open' => $isOpen,
                        'open' => $openTime,
                        'close' => $closeTime,
                        'restaurant_id' => $restaurant->id
                    ]);
                }
            }
        }


            return redirect()->back();
        }


}
