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
  Route::get('response', 'CompaniesController@response');
    Route::group(['middleware' => ['api', 'language']], function () {

        Route::get('banners', 'admin\BannersController@index');
        Route::get('services', 'admin\ServicesController@index');
        Route::get('saudi_harbors', 'admin\SaudiHarborsController@index');
        Route::get('china_harbors', 'admin\ChinaHarborsController@index');
        Route::get('testimonials', 'admin\TestimonialsController@index');
        Route::get('shipment_types', 'admin\ShipmentTypesController@index');
        Route::get('get-companies', 'CompaniesController@index');
          Route::get('international_companies', 'admin\InternationalCompaniesController@index');
        Route::post('contact', 'HomePageApi@contact');

        Route::post('users/register', 'AuthApi@register');
        Route::any('users/sms/send', 'AuthApi@sendSms');
        Route::any('users/sms/confirm', 'AuthApi@confirm');
        Route::any('users/checkphone', 'AuthApi@sendSms');
        Route::any('users/reset_password', 'AuthApi@resetPassword');
        Route::post('users/login', 'AuthApi@login');

        Route::post('users/reset-password', 'AuthApi@resetPassword');

        Route::group(['middleware' => ['auth:api']], function () {
            Route::post('users/active', 'AuthApi@active');
            Route::get('users/myaccount', 'UsersAPI@myacount');
            Route::post('users/update-profile', 'UsersAPI@updateProfile');
            Route::get('users/notifications', 'UsersAPI@notifications');
            Route::get('users/notifications/read', 'UsersAPI@readNotifications');
            Route::get('users/update-device-id', 'UsersAPI@updateDeviceId');
            Route::post('users/update-password', 'UsersAPI@updatePassword');
            Route::get('profile/logout', 'UsersAPI@logout');
          Route::get('orders/check-promo','CompaniesController@checkPromo');
            Route::post('companies/add-booking', 'CompaniesController@bookCompany');
            Route::get('orders', 'CompaniesController@getUserOrders');
            Route::get('orders/cancel', 'CompaniesController@cancel');
            Route::post('orders/acceptChange', 'CompaniesController@acceptChange');
            Route::post('orders/pay', 'CompaniesController@pay');
            Route::post('orders/pay-remain', 'CompaniesController@payRemain');

            //cards
            Route::get('users/cards','CardsController@index');
            Route::post('users/cards/add','CardsController@add');
            Route::post('users/cards/edit','CardsController@edit');
            Route::get('users/cards/show','CardsController@show');
            Route::get('users/cards/active','CardsController@active');
            Route::get('users/cards/delete','CardsController@delete');




             
         


             
        
        });
    });
});

//Backend
Route::group(['namespace' => 'App\Http\Controllers\apis\admin', 'prefix' => 'backend'], function () {
    Route::post('login', 'AuthApi@login');
    Route::group(['middleware' => ['auth:admin']], function () {
        
            Route::get('myaccount', 'AuthApi@myacount');
            Route::post('update-profile', 'UsersAPI@updateProfile');
            Route::post('update-password', 'UsersAPI@updatePassword');

            //admins
            Route::get('backend_admins', 'BackendAdminsController@index');
            Route::post('backend_admins/create', 'BackendAdminsController@add');
            Route::get('admins', 'AdminsController@index');
            Route::post('admins/create', 'AdminsController@add');
            Route::post('admins/edit', 'AdminsController@edit');
            Route::get('admins/show', 'AdminsController@display');
            Route::get('admins/delete', 'AdminsController@delete');
            //banners
            Route::get('banners', 'BannersController@index');
            Route::post('banners/create', 'BannersController@add');
            Route::post('banners/edit', 'BannersController@edit');
            Route::get('banners/show', 'BannersController@display');
            Route::get('banners/delete', 'BannersController@delete');
            //brands
            Route::get('brands', 'BrandsController@index');
            Route::post('brands/create', 'BrandsController@add');
            Route::post('brands/edit', 'BrandsController@edit');
            Route::get('brands/show', 'BrandsController@display');
            Route::get('brands/delete', 'BrandsController@delete');
            //shipment_types
            Route::get('shipment_types', 'ShipmentTypesController@index');
            Route::post('shipment_types/create', 'ShipmentTypesController@add');
            Route::post('shipment_types/edit', 'ShipmentTypesController@edit');
            Route::get('shipment_types/show', 'ShipmentTypesController@display');
            Route::get('shipment_types/delete', 'ShipmentTypesController@delete');
            //services
            Route::get('services', 'ServicesController@index');
            Route::post('services/create', 'ServicesController@add');
            Route::post('services/edit', 'ServicesController@edit');
            Route::get('services/show', 'ServicesController@display');
            Route::get('services/delete', 'ServicesController@delete');
            //companies
            Route::get('companies', 'CompaniesController@index');
            Route::post('companies/create', 'CompaniesController@add');
            Route::post('companies/harbors/edit', 'CompaniesController@updateHarbours');
            Route::post('companies/edit', 'CompaniesController@edit');
            Route::get('companies/show', 'CompaniesController@display');
            Route::get('companies/delete', 'CompaniesController@delete');
            //international companies
            Route::get('international_companies', 'InternationalCompaniesController@index');
            Route::post('international_companies/create', 'InternationalCompaniesController@add');
            Route::post('international_companies/edit', 'InternationalCompaniesController@edit');
            Route::get('international_companies/show', 'InternationalCompaniesController@display');
            Route::get('international_companies/delete', 'InternationalCompaniesController@delete');
            //china_harbors
            Route::get('china_harbors', 'ChinaHarborsController@index');
            Route::post('china_harbors/create', 'ChinaHarborsController@add');
            Route::post('china_harbors/edit', 'ChinaHarborsController@edit');
            Route::get('china_harbors/show', 'ChinaHarborsController@display');
            Route::get('china_harbors/delete', 'ChinaHarborsController@delete');
            //saudi_harbors
            Route::get('saudi_harbors', 'SaudiHarborsController@index');
            Route::post('saudi_harbors/create', 'SaudiHarborsController@add');
            Route::post('saudi_harbors/edit', 'SaudiHarborsController@edit');
            Route::get('saudi_harbors/show', 'SaudiHarborsController@display');
            Route::get('saudi_harbors/delete', 'SaudiHarborsController@delete');
            //promo_codes
            Route::get('promo_codes', 'PromocodeController@index');
            Route::post('promo_codes/create', 'PromocodeController@add');
            Route::post('promo_codes/edit', 'PromocodeController@edit');
            Route::get('promo_codes/show', 'PromocodeController@display');
            Route::get('promo_codes/delete', 'PromocodeController@delete');
            //testimonials
            Route::get('testimonials', 'TestimonialsController@index');
            Route::post('testimonials/create', 'TestimonialsController@add');
            Route::post('testimonials/edit', 'TestimonialsController@edit');
            Route::get('testimonials/show', 'TestimonialsController@display');
            Route::get('testimonials/delete', 'TestimonialsController@delete');

                       //clients (users of type 1)
            Route::get('clients', 'UsersAPI@all');
            Route::post('clients/active', 'UsersAPI@active');

            Route::get('transactions','OrdersController@transactions');
            Route::get('orders','OrdersController@index');
            Route::post('orders/change-deliever','OrdersController@changToDeliver');
            Route::post('orders/confirm','OrdersController@confirmOrder');
            Route::post('orders/cancel','OrdersController@cancelOrder');
            Route::post('orders/receive-china','OrdersController@recieveChina');
            Route::post('orders/check-price','OrdersController@checkPrice');
            Route::post('orders/change-status','OrdersController@changeStatus');
            Route::post('orders/finish','OrdersController@finish');
            //settings
            Route::post('settings/update', 'AppSettingController@update');
     
    });
});
