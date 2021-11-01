<?php
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout')->middleware('auth:sanctum');
    route::apiResource('product', 'ProductController')->except('update');
    route::apiResource('order', 'OrderController')->except('update');

    Route::middleware('auth:sanctum')->name('admin.')->prefix('admin')->group(function () {
        Route::get('read-notification', 'AuthController@readNotification');
        Route::post('logout', 'AuthController@logout');
        route::post('product/update/{product}', 'ProductController@update');
        route::post('order/status/{order}', 'OrderController@status');
        route::post('order/update/{order}', 'OrderController@update');
        route::apiResource('user', 'UserController');
    });
});



