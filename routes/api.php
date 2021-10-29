<?php

use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout')->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->name('admin.')->prefix('admin')->group(function () {
        Route::get('read-notification', 'AuthController@readNotification');
        Route::post('logout', 'AuthController@logout');
        route::apiResource('product', 'ProductController');
        route::apiResource('order', 'OrderController');
    });
});
