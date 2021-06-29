<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'App\Http\Controllers\apis'], function () {

    Route::group(['middleware' => ['api','language']], function () {
   
        Route::get('banners', 'SelectsController@getBanners');
        Route::get('brands', 'SelectsController@getBrands');
        Route::get('jobs', 'SelectsController@getJobs');
                Route::get('specialists', 'SelectsController@getMainspecialists');
                        Route::get('secondary_specialists', 'SelectsController@getSecondaryspecialists');
        Route::get('colors', 'SelectsController@getColors');
        Route::post('users/register', 'AuthApi@register');
        Route::post('maintaner/register', 'AuthApi@mainanerRegister');
//        Route::post('delivery/register', 'AuthApi@DeliveryRegister');
        Route::get('users/send-sms', 'AuthApi@send');
        Route::get('users/confirm', 'AuthApi@confirm');
        Route::get('users/register', 'AuthApi@register');
        Route::post('delivery/register', 'AuthApi@delivaryRegister');
        Route::post('users/login', 'AuthApi@login');

        Route::group(['middleware' => ['auth:api']], function () {
            Route::get('users/myaccount', 'UsersAPI@myacount');
            Route::get('users/notifications', 'UsersAPI@notifications');
            Route::get('users/notifications/read', 'UsersAPI@readNotifications');
            Route::get('users/update-device-id', 'UsersAPI@updateDeviceId');
            Route::post('users/update-password', 'UsersAPI@updatePassword');
            Route::get('profile/logout', 'UsersAPI@logout');
            Route::group(['middleware' => ['client']], function () {
                Route::post('users/update-profile', 'UsersAPI@updateProfile');
               

          

                Route::post('checkout', 'OrdersApi@index');
                Route::get('orders', 'OrdersApi@userOrders');
              
                Route::get('orders/show', 'UsersAPI@showOrder');
                Route::post('orders/choose-offer', 'OrdersApi@chooseOffer');
                Route::get('orders/cancel', 'OrdersApi@cancelOrder');

               
            });

           
            Route::group(['middleware' => ['delivery']], function () {
                                Route::post('delivery/update-profile', 'UsersAPI@updateDeliveryProfile');
                                Route::post('delivery/update-car', 'UsersAPI@updateDeliveryCar');
                                Route::post('delivery/update-bank', 'UsersAPI@updateDeliverybank');

            
                Route::get('delivery/orders/new', 'OrdersApi@newOrders');
                Route::get('delivery/orders', 'OrdersApi@DeliveryOrders');
                Route::post('delivery/make-offer', 'OrdersApi@makeOffer');
           
                
            });
            Route::group(['middleware' => ['admin'], 'prefix' => '/backend'], function () {
            
                Route::get('orders', 'OrdersApi@all');
                //users
                Route::get('users', 'UsersApi@all');
                Route::get('users/active', 'UsersApi@active');
                Route::get('users/special', 'UsersApi@special');
                //categories
                Route::get('categories', 'CategoriesController@index');
                Route::post('categories/add', 'CategoriesController@add');
                Route::post('categories/edit', 'CategoriesController@edit');
                Route::get('categories/show', 'CategoriesController@display');
                Route::get('categories/delete', 'CategoriesController@delete');
                //banners
                Route::get('banners', 'BannersController@index');
                Route::post('banners/add', 'BannersController@add');
                Route::post('banners/edit', 'BannersController@edit');
                Route::get('banners/show', 'BannersController@display');
                Route::get('banners/delete', 'BannersController@delete');
            });
        });
    });
});
    
//Backend
Route::group(['namespace' => 'App\Http\Controllers\apis\admin','prefix'=>'backend'], function () {
          Route::post('login','AuthApi@login');
      Route::group(['middleware' => ['auth:api']], function () {
      Route::group(['middleware' => ['admin']], function () {
          Route::get('myaccount','AuthApi@myacount');
          //banners
          Route::get('banners','BannersController@index');
          Route::post('banners/create','BannersController@add');
          Route::post('banners/edit','BannersController@edit');
          Route::get('banners/show','BannersController@display');
          Route::get('banners/delete','BannersController@delete');

       
          //settings
          Route::post('settings/update','AppSettingController@update');
      });
      });
          
      });
