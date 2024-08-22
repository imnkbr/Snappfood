<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Customer\Controller;
use App\Http\Resources\AddressResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerAddress;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;

class AddressController extends Controller
{
    private static $user;

    public function __construct()
    {
        $this::$user = auth()->guard('sanctum')->user();
    }
    public function getUserAddress()
    {


        $addresses = $this::$user->customer->customerAddresses;

        $addressData = AddressResource::collection($addresses);

        return response()->json($addressData);
    }

    public function addAddress(Request $request)
    {
        try {
            $rules = [
                'address_title' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ];

            $validatedData = $request->validate($rules);

            CustomerAddress::create([
                'address_title' => $validatedData['address_title'],
                'address' => $validatedData['address'],
                'latitude' => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
                'is_default' => false,
                'customer_id' => $this::$user->customer->id
            ]);


            return response()->json(['msg' => 'address added successfully']);
        }
        catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function updateAddress($address_id)
    {

            $customerId = Auth::user()->customer->id;

            if (!$customerId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            if(!CustomerAddress::where('customer_id', $customerId)->where('id', $address_id)->exists()){
                return response()->json([
                    'msg' => 'Unauthourize',
                    'status' => 401
                ] ,401);
            };
            
            $address = CustomerAddress::where('id', $address_id)
            ->where('customer_id', $customerId)
            ->first();

            if (!$address) {
                return response()->json([
                    'message' => 'Address not found or you are not authorized to update it.'
                ], 404);
            }

            if ($address->customer_id != $customerId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            } else {

                CustomerAddress::where('customer_id', $customerId)
                    ->where('is_default', true)
                    ->update([
                        'is_default' => false
                    ]);


                $address->update([
                    'is_default' => true
                ]);

                return response()->json([
                    'message' => 'Address updated successfully.',
                    'address' => $address
                ], 200);

            }



    }
}
