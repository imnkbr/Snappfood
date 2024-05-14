<?php

namespace App\Models;

use App\Casts\WorkingDayCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantHour extends Model
{
    protected $fillable = ['day' , 'is_open' , 'open' , 'close' , 'restaurant_id'];

    use HasFactory;
}
