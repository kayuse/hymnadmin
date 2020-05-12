<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/user/{id}', 'Api\UserController@get')->middleware('auth.api');
Route::get('/auth-user/', 'Api\UserController@authUser')->middleware('auth.api');
Route::post('/user/create', 'Api\UserController@create')->name('user.create');

Route::middleware(['auth.api'])->group(function () {
    Route::get('/hymns/all', 'Api\HymnListController@all')->name('hymns.all');
    Route::get('/sunday-school/all', 'Api\SundaySchoolController@all')->name('sunday_school.all');
});

Route::get('inspiration/all', 'Api\InspirationController@index');
Route::get('inspiration/show/{id}', 'Api\InspirationController@get');
Route::post('inspiration/save', 'Api\InspirationController@store');
Route::post('inspiration/update/{id}', 'Api\InspirationController@update');
Route::delete('inspiration/delete/{id}', 'Api\InspirationController@delete');
Route::get('daily/quotes', 'Api\InspirationDisplayController@getTodaysInspiration');
Route::post('file', 'Api\HymnDownloadController@upload');
Route::get('file/{hymn}/{version}', 'Api\HymnDownloadController@download');
