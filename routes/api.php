<?php
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MainController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix'=>'v1'], function () {
    Route::get('/governorates',[MainController::class,'governorates']);
    Route::get('/cities',[MainController::class,'cities']);
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::get('/categories',[MainController::class,'categories']);
    Route::get('/settings',[MainController::class,'settings']);
    Route::get('/blood-types',[MainController::class,'bloodTypes']);
    Route::post('/reset-password',[AuthController::class,'resetPassword']);
    Route::post('/new-password',[AuthController::class,'newPassword']);
    Route::post('/contact',[MainController::class,'contact']);


Route::group(['middleware'=>'auth:api'], function (){
    Route::get('/posts',[MainController::class,'posts']);
    Route::get('/post',[MainController::class,'post']);
    Route::post('/contact',[MainController::class,'contact']);
    Route::post('/profile',[AuthController::class,'profile']);
    Route::post('/post-favourite',[MainController::class,'postFavourite']);
    Route::get('/my-favourites',[MainController::class,'myFavourites']);
    Route::post('/register-token',[AuthController::class,'registerToken']);
    Route::post('/remove-token',[AuthController::class,'removeToken']);
    Route::post('/donation-request-create',[MainController::class,'donationRequestCreate']);
    Route::get('/donations',[MainController::class,'donations']);
    Route::get('/notifications',[MainController::class,'notifications']);
    Route::get('/notifications-settings',[AuthController::class,'notificationsSettings']);


  });

});












