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
    Route::apiResource('event', 'EventController');
    Route::post('event/{event}/set-success', 'EventController@updateStatusEvent');
    Route::get('download-event/{event}', 'EventController@downloadPdf');
});
