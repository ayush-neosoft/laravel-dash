<?php

Route::group([
	'namespace' => 'Auth',
  'middleware' => 'api'
], function ($router) {
		Route::post('register', 'ApiAuthController@register');
    Route::post('login', 'ApiAuthController@login');
    Route::post('logout', 'ApiAuthController@logout');
    Route::post('refresh', 'ApiAuthController@refresh');
    Route::post('me', 'ApiAuthController@me');
});