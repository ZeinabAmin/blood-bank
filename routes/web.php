<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Front\MainController;
use App\Http\Controllers\Front\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::group(['namespace'=>'Front','middleware'=>'auth:client-web'], function (){
Route::group(['namespace'=>'Front'], function (){
Route::get('/',[MainController::class,'home']);
//Route::get('about',[MainController::class,'about']);
Route::post('toggle-favourite',[MainController::class,'toggleFavourite'])->name('toggle-favourite');

Route::get('client-register',[AuthController::class,'register'])->name('client-register');
Route::get('signin-account',[AuthController::class,'signin'])->name('signin-account');
Route::post('/signin-save', [AuthController::class, 'signInSave'])->name('signin.Save');
Route::get('/logout-client', [AuthController::class, 'logout'])->name('logout.client');
Route::get('article-details',[MainController::class,'articles'])->name('article-details');
//Route::get('article-details',[MainController::class,'articleDetails'])->name('article-details');

Route::get('donation-requests',[MainController::class,'donationRequests'])->name('donationsclient');
Route::get('who-are-us',[MainController::class,'whoAreUs'])->name('who-are-us');
Route::get('contact-us',[MainController::class,'contactUs'])->name('contact-us');



});


Auth::routes([
    "register" => false
]);

Route::group(['middleware'=>'auth'], function (){

Route::get('/home', [HomeController::class,'index'])->name('home');


Route::resource('governorates', GovernorateController::class);
Route::resource('cities', CityController::class);
  Route::resource('categories', CategoryController::class);
  Route::resource('posts', PostController::class);

  Route::resource('clients', ClientController::class);


  Route::resource('contacts', ContactController::class);
  Route::resource('settings', SettingController::class);
  Route::resource('donation-requests',DonationRequestController::class);

Route::get('clients-activate/{id}',[ClientController::class,'activate'])->name('clients.activate');
Route::get('clients-deactivate/{id}',[ClientController::class,'deactivate'])->name('clients.deactivate');



});


Route::group(['middleware' => ['auth']], function() {

    Route::get('users/reset-password', [UserController::class,'changePassword'])->name('users.reset-password');
    Route::post('users/reset-password', [UserController::class,'changePasswordSave'])->name('users.reset-password-save');

    Route::resource('roles',RoleController::class);
    Route::resource('users', UserController::class);




    });
