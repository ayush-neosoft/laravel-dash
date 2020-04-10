<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('signup', 'AuthController@signup')->name('register');
        Route::post('signin', 'AuthController@signin')->name('login');
    });
    Route::middleware('VerifyJWTToken')->group(function () {
        Route::group(['namespace' => 'Auth'], function () {
            Route::post('logout', 'AuthController@logout')->name('logout');
        });

        /* Plan CRUD */
        Route::group(['namespace' => 'Dashboard'], function () {
            Route::get('plans', 'PlanController@dashboardPlans')->name('plans');
            Route::post('plan-details', 'PlanController@planDetails')->name('planDetails');
            Route::post('plan', 'PlanController@plan')->name('Plan');
            Route::post('development-area', 'PlanController@developmentArea')->name('DevelopmentArea');
            Route::post('activity', 'PlanController@activity')->name('Activity');
            Route::post('activity-status', 'PlanController@completeActivity')->name('ActivityCompleteStatus');
            Route::post('reflection', 'PlanController@reflection')->name('Reflection');
        });
    });
});
