<?php

use Illuminate\Http\Request;

//use Auth;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/user', function () {

    return response()->json([$user]);
})->middleware('auth.api');

Route::middleware(['auth.api'])->group(function () {
    Route::post('/add-record', 'RecordController@add');
    Route::get('/fetch', 'RecordController@fetch');
    Route::get('/get/{id}', 'RecordController@get');
    Route::post('/create-hymn','HymnController@createHymn');
});


