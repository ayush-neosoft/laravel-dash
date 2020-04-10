<?php

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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::any('/return', function (Request $request) {
    echo "return";
    echo "<pre>";
    print_r($request->all());
    exit;
});

Route::any('/cancel', function (Request $request) {
    echo "cancel";
    echo "<pre>";
    print_r($request->all());
    exit;
});

Route::any('/notify', function (Request $request) {
    echo "notify";
    echo "<pre>";
    print_r($request->all());
    exit;
});
