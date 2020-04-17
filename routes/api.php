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

Route::any('/adverts/create', 'AdvertController@createAdvert');
Route::get('/adverts/get-advert/{id}', 'AdvertController@getAdvert');
Route::get('/adverts/get-adverts', 'AdvertController@getAdverts');

Route::fallback(function(){
    return response()->json([
        'success' => 0,
        'message' => 'Page not found'
    ], 404);
});