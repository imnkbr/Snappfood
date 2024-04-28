<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Models\Food;
use App\Models\Restaurant;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        return view('admin.discounts',[
            'foods' => $foods,
        ]);
    }

    public function delete(string $id)
    {
        Discount::find($id)->delete();

        return redirect()->route('admin.discounts');
    }

    public function store(DiscountRequest $request)
    {
        $validateData = $request->validated();

        $discount_rand = Str::random(20);


        if (!Discount::where('value' ,'LIKE',$discount_id)->first()){

            Discount::create([
                'value' => $discount_rand,
                'percent' => $validateData['percent'],
                'food_id' => $validateData['food_id']
            ]);
        }else{
        return redirect()->route('admin.discounts')->whithErrors('Error') ;
        }


        return redirect()->route('admin.discounts');
    }
}
