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

    Route::group(['middleware' => ['api', 'language']], function () {

        Route::get('banners', 'SelectsController@getBanners');
        Route::get('brands', 'SelectsController@getBrands');
        Route::get('cities', 'SelectsController@getcities');
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

        Route::post('users/reset-password', 'AuthApi@resetPassword');

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
                Route::post('rating/add', 'RateApi@add');
                Route::post('orders/choose-offer', 'OrdersApi@chooseOffer');
                Route::get('orders/cancel', 'OrdersApi@cancelOrder');
            });


                  Route::group(['middleware' => ['delivery']], function () {
                  Route::group(['middleware' => ['active']], function () {
                Route::post('delivery/update-profile', 'UsersAPI@updateDeliveryProfile');
                Route::post('delivery/update-car', 'UsersAPI@updateDeliveryCar');
                Route::post('delivery/update-bank', 'UsersAPI@updateDeliverybank');
                Route::post('delivery/update-status', 'UsersAPI@updateDeliveryStatus');

                Route::get('orders/finish', 'OrdersApi@finish');

                Route::get('delivery/orders/new', 'OrdersApi@newOrders');
                Route::get('delivery/orders', 'OrdersApi@DeliveryOrders');
                Route::post('delivery/make-offer', 'OrdersApi@makeOffer');
            }); });
            Route::group(['middleware' => ['admin'], 'prefix' => '/backend'], function () {

                Route::get('orders', 'OrdersApi@all');
                //users
                Route::get('users', 'UsersAPI@all');
                Route::get('users/active', 'UsersAPI@active');
                Route::get('users/special', 'UsersAPI@special');
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
Route::group(['namespace' => 'App\Http\Controllers\apis\admin', 'prefix' => 'backend'], function () {
    Route::post('login', 'AuthApi@login');
    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['middleware' => ['admin']], function () {
            Route::get('myaccount', 'AuthApi@myacount');
            //banners
            Route::get('banners', 'BannersController@index');
            Route::post('banners/create', 'BannersController@add');
            Route::post('banners/edit', 'BannersController@edit');
            Route::get('banners/show', 'BannersController@display');
            Route::get('banners/delete', 'BannersController@delete');

            //brands
            Route::get('brands', 'BrandsController@all');
            Route::post('brands/create', 'BrandsController@create');
            Route::post('brands/edit', 'BrandsController@edit');
            Route::post('brands/show', 'BrandsController@show');
            Route::post('brands/delete', 'BrandsController@delete');

            //cities
            Route::get('cities', 'CitiesController@all');
            Route::post('cities/create', 'CitiesController@create');
            Route::post('cities/edit', 'CitiesController@edit');
            Route::post('cities/show', 'CitiesController@show');
            Route::post('cities/delete', 'CitiesController@delete');

            //main specialists
            Route::get('main-specialists', 'MainSpecialistsController@all');
            Route::post('main-specialists/reorder', 'MainSpecialistsController@reOrder');
            Route::post('main-specialists/create', 'MainSpecialistsController@create');
            Route::post('main-specialists/edit', 'MainSpecialistsController@edit');
            Route::post('main-specialists/show', 'MainSpecialistsController@show');
            Route::post('main-specialists/delete', 'MainSpecialistsController@delete');

            //secondary specialists
            Route::get('secondary-specialists', 'SecondarySpecialistsController@all');
            Route::post('secondary-specialists/create', 'SecondarySpecialistsController@create');
            Route::post('secondary-specialists/edit', 'SecondarySpecialistsController@edit');
            Route::post('secondary-specialists/show', 'SecondarySpecialistsController@show');
            Route::post('secondary-specialists/delete', 'SecondarySpecialistsController@delete');

            //clients (users of type 1)
            Route::get('clients', 'ClientsController@all');
            Route::post('clients/show', 'ClientsController@show');

            //delivery users (users of type 2)
            Route::get('deliveries', 'DeliveriesController@all');
            Route::post('deliveries/show', 'DeliveriesController@show');

            //settings
            Route::post('settings/update', 'AppSettingController@update');
        });
    });
});
