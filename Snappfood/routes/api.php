<?php

use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\CommentController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\RestaurantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/addresses' , [AddressController::class , 'getUserAddress']);
    Route::post('/addresses' , [AddressController::class , 'addAddress']);
    Route::post('/addresses/{id}',[AddressController::class , 'updateAddress']);
    Route::patch('/addresses/{id}',[AddressController::class , 'update']);

    Route::get('/orders' , [OrderController::class , 'getOrders']);
    Route::post('/orders/add' , [OrderController::class , 'addToOrder']);
    Route::patch('/orders/add' , [OrderController::class , 'updateOrder']);
    Route::get('/orders/{id}' , [OrderController::class , 'getSingleOrder']);
    Route::post('/orders/{id}/pay' , [OrderController::class , 'pay']);

    Route::post('/comments' , [CommentController::class , 'addComment']);


});

Route::get('/restaurants/{id}' , [RestaurantController::class , 'getSingleRestaurant']);
Route::get('/restaurants' , [RestaurantController::class , 'getRestaurants']);
Route::get('/restaurants/{id}/foods' , [RestaurantController::class , 'getFoods']);

Route::get('/comments' , [CommentController::class , 'getComments']);


