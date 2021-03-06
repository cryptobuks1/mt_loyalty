<?php
use App\Store;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::bind('user', function ($value) {
    return User::find($value) ?? abort(404);
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function() {
        return view('home');
    })->name('home');

    Route::get('user/ChangePassword', 'UsersController@ChangePassword');
    Route::post('user/ChangePasswords', 'UsersController@ChangePasswords');
    Route::any('user_feedback','UserFeedBackController@index');

    Route::group(['middleware' => ['permission:admin module']], function () {
        Route::post('user/GetDataById', 'UsersController@GetDataById');
        Route::resource('user', 'UsersController');

    });

    Route::group(['middleware' => ['permission:merchant module']], function (){

        Route::resource('coupon', 'CouponController');
        Route::post('coupon/GetDataById', 'CouponController@GetDataById');

        Route::get('get-store','OfferController@getstore');
        Route::resource('offer', 'OfferController');
        Route::post('offer/GetDataById', 'OfferController@GetDataById');

        Route::get('get-merchant','StoreController@getmerchant');
        Route::post('store/GetDataById', 'StoreController@GetDataById');
        Route::resource('store', 'StoreController');
        Route::bind('store', function ($value) {
            return Store::find($value) ?? abort(404);
        });

        Route::resource('store_reward', 'StoreRewardController');
    });
});
