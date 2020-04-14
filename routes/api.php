<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'AuthController@register')->name('register');
        Route::post('login', 'AuthController@login')->name('login');
        Route::get('email/verify/{id}', 'AuthController@verify')->name('verificationapi.verify');
    });

    Route::middleware('VerifyJWTToken')->group(function () {
        Route::group(['namespace' => 'Auth'], function () {
            Route::get('me', 'AuthController@me')->name('me');
            Route::get('email/resend/{user_id}', 'AuthController@resend')->name('verificationapi.resend');
            Route::get('logout', 'AuthController@logout')->name('logout');
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
