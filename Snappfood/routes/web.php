<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DiscountController;
use App\Http\Controllers\admin\TypeOfFoodController;
use App\Http\Controllers\admin\TypeOfRestaurantController;
use App\Http\Controllers\restaurant\RestaurantController;
use App\Http\Controllers\restaurant\SettingController;
use App\Http\Controllers\restaurant\RestaurantTypeController;
use App\Http\Controllers\restaurant\RestaurantWorkingHoursController;
use App\Http\Controllers\restaurant\FoodController;
use App\Http\Controllers\restaurant\CommentController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RestaurantMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HomeController::class , 'index'] );
Route::get('/login' , [LoginController::class , 'index'])->name('login');
Route::post('/login' , [LoginController::class , 'login']);
Route::get('/register' , [RegisterController::class , 'index'])->name('register');
Route::post('/register' , [RegisterController::class , 'register']);


Route::group(['middleware' => 'admin'],function (){

    Route::get('/admin',[AdminController::class , 'index'])->name('admin.home');
    Route::post('admin/logout' , [AdminController::class , 'logout']);
    Route::delete('/admin/{id}' , [AdminController::class , 'deleteComment']);

    Route::get('/admin/food_types' , [TypeOfFoodController::class , 'index'])->name('admin.food_types');
    Route::post('/admin/food_types' , [TypeOfFoodController::class , 'store']);
    Route::delete('/admin/food_types/{id}' , [TypeOfFoodController::class , 'delete']);
    Route::put('/admin/food_types/{id}', [TypeOfFoodController::class , 'update']);

    Route::get('/admin/restaurant_types' , [TypeOfRestaurantController::class , 'index'])->name('admin.restaurant_types');
    Route::post('/admin/restaurant_types' , [TypeOfRestaurantController::class , 'store']);
    Route::delete('/admin/restaurant_types/{id}' , [TypeOfRestaurantController::class , 'delete']);
    Route::put('/admin/restaurant_types/{id}', [TypeOfRestaurantController::class , 'update']);

    Route::get('/admin/discounts/' , [DiscountController::class , 'index'])->name('admin.discounts');
    Route::post('admin/discounts',[DiscountController::class , 'store']);
    Route::delete('/admin/discounts/{id}' , [DiscountController::class , 'delete']);



});

Route::group(['middleware' => 'restaurant'],function (){

    Route::get('/restaurant/{name}',[RestaurantController::class,'index'])->name('restaurant.dashboard');
    Route::put('restaurant/{name}/{id}',[RestaurantController::class , 'ordersUpdate']);
    Route::post('admin/{name}/logout' , [RestaurantController::class , 'logout']);

    Route::get('/restaurant/{name}/setting', [SettingController::class , 'index'])->name('restaurant.setting');

    Route::post('/restaurant/{name}/setting/complete_restaurant_details',[SettingController::class , 'completeRestaurantDetails']);

    Route::put('/restaurant/{name}/setting/status', [SettingController::class , 'restaurantStatus']);

    Route::get('/restaurant/{name}/setting/restaurant_type' , [RestaurantTypeController::class , 'index']);

    Route::post('/restaurant/{name}/setting/restaurant_type' , [RestaurantTypeController::class , 'create']);

    Route::delete('/restaurant/{name}/setting/restaurant_type/{id}' , [RestaurantTypeController::class , 'delete']);

    Route::get('restaurant/{name}/setting/restaurant_working_hours',[RestaurantWorkingHoursController::class , 'index'])->name('restaurant.working_hours');

    Route::post('restaurant/{name}/setting/restaurant_working_hours',[RestaurantWorkingHoursController::class , 'create']);

    Route::get('restaurant/{name}/foods',[FoodController::class , 'index'])->name('restaurant.foods');

    Route::get('restaurant/{name}/foods/foods_create',[FoodController::class , 'create']);

    Route::post('restaurant/{name}/foods/foods_create',[FoodController::class , 'addFood']);

    Route::get('/restaurant/{name}/foods/{id}',[FoodController::class , 'edit']);

    Route::put('/restaurant/{name}/foods/{id}',[FoodController::class , 'update']);

    Route::delete('/restaurant/{name}/foods/{id}' , [FoodController::class  , 'delete']);

    Route::get('/restaurant/{name}/foods/search', [FoodController::class, 'search'])->name('foods.search');

    Route::get('restaurant/{name}/comments' , [CommentController::class , 'index']);

    Route::delete('restaurant/{name}/comments/{id}' , [CommentController::class , 'delete']);

    Route::post('restaurant/{name}/comments/{id}' , [CommentController::class , 'response']);

    Route::put('restaurant/{name}/comments/{id}' , [CommentController::class , 'confirm']);
});

