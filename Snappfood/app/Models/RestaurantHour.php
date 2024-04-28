<?php

namespace App\Models;

use App\Casts\DayCast;
use App\Casts\RestauranStatusCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantHour extends Model
{
    use HasFactory;
}
