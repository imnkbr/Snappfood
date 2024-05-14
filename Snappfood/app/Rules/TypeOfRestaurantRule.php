<?php

namespace App\Rules;

use Closure;
use App\Models\RestaurantType;
use Illuminate\Contracts\Validation\ValidationRule;

class TypeOfRestaurantRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(RestaurantType::where('type_of_restaurant_id', $value)->exists() and RestaurantType::where('restaurant_id', auth()->user()->restaurant->id)->exists()){
            $fail('you selected this type already');
        }

    }
}
