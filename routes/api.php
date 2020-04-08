<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('signup', 'AuthController@signup')->name('register');
        Route::post('signin', 'AuthController@signin')->name('login');
    });
    Route::middleware('VerifyJWTToken')->group(function () {
        Route::group(['namespace' => 'Auth'], function () {
            Route::post('logout', 'AuthController@logout')->name(('logout'));
        });

        Route::group(['namespace' => 'Dashboard'], function () {
            Route::get('plans', 'DashboardController@dashboardPlans')->name(('plans'));
            Route::post('plan-details', 'DashboardController@planDetails')->name(('planDetails'));
        });
    });
});
