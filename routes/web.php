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
// |
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::group(['namespace'=>'Front','middleware'=>'auth:client-web'], function (){
Route::group(['namespace' => 'Front'], function () {
    Route::get('/', [MainController::class, 'home']);

    Route::get('client-register', [AuthController::class, 'register'])->name('client-register');
    Route::post('register.save', [AuthController::class, 'registerSave'])->name('register.save');
    Route::get('signin-account', [AuthController::class, 'signin'])->name('signin-account');
    Route::post('/signin-save', [AuthController::class, 'signInSave'])->name('signin.Save');
    Route::get('forget-password', [AuthController::class, 'forgetPassword'])->name('forget-password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::get('new-password', [AuthController::class, 'newPassword'])->name('new-password');
    Route::post('new-password', [AuthController::class, 'newPasswordConfirm'])->name('new-password-confirm');
    Route::get('articles', [MainController::class, 'articles'])->name('articles');
    Route::get('article-details/{id}', [MainController::class, 'articleDetails'])->name('article-details');
    Route::get('who-are-us', [MainController::class, 'whoAreUs'])->name('who-are-us');
    Route::get('donations', [MainController::class, 'donationRequests'])->name('donations');
    Route::get('inside-request/{id}', [MainController::class, 'insideRequest'])->name('inside-request');



    Route::group(['middleware' => 'auth:client-web'], function () {

        Route::post('toggle-favourite', [MainController::class, 'toggleFavourite'])->name('toggle-favourite');
        Route::get('/logout-client', [AuthController::class, 'logout'])->name('logout.client');
        Route::get('/client-profile', [AuthController::class, 'profile'])->name('client-profile');
        Route::post('/client-profile', [AuthController::class, 'editProfile'])->name('edit-profile');
        Route::get('articles-favourite', [MainController::class, 'articlesFavourite'])->name('articles-favourite');
        Route::get('create-donation-request', [MainController::class, 'formCreateDonation'])->name('get-create-donation');
        Route::post('create-donation', [MainController::class, 'createDonation'])->name('create-donation');
        Route::get('notisettings', [MainController::class, 'notificationsSettings'])->name('notisettings');
        Route::post('notifications-settings-save', [MainController::class, 'notificationsSettingsSave'])->name('notifications-settings-save');
        Route::get('my-notifications', [MainController::class, 'myNotifications'])->name('my-notifications');
        Route::get('contact-us', [MainController::class, 'contactUs'])->name('contact-us');
        Route::post('contact-Send', [MainController::class, 'contactSend'])->name('contact-Send');
    });
});



Auth::routes([
    "register" => false
]);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');


    Route::resource('governorates', GovernorateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);


    Route::get('clients-activate/{id}', [ClientController::class, 'activate'])->name('clients.activate');
    Route::get('clients-deactivate/{id}', [ClientController::class, 'deactivate'])->name('clients.deactivate');  
    Route::resource('clients', ClientController::class);


    Route::resource('contacts', ContactController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('donation-requests', DonationRequestController::class);

    
});


Route::group(['middleware' => ['auth']], function () {

    Route::get('users/reset-password', [UserController::class, 'changePassword'])->name('users.reset-password');
    Route::post('users/reset-password', [UserController::class, 'changePasswordSave'])->name('users.reset-password-save');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
