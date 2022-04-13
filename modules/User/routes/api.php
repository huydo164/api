<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('send-contact', 'UserController@sendContactEmail');
    Route::post('logout', 'UserController@logout');
    Route::get('me', 'UserController@getProfile');
    Route::post('me', 'UserController@setting');
});

Route::group(['middleware' => ['guest:api']], function () {
    Route::post('login', 'UserController@login')->name('login');
    Route::post('register', 'UserController@register')->name('register');
});

Route::group(['middleware' => ['set_lang']], function () {
    Route::post('check-email', 'UserController@checkEmailUnique');
});
