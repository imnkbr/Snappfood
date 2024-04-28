<?php

namespace App\Models;

use App\Casts\RestauranStatusCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'phone_number',
        'address',
        'account_number',
        'is_open',
        'food_sending_price',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function restaurantHoures()
    {
        return $this->hasMany(RestaurantHour::class);
    }

    public function restaurantTypes()
    {
        return $this->hasMany(RestaurantType::class);
    }


}
