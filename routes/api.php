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

Route::get('/user/{id}', 'Api\UserController@get')->middleware('auth.api');
Route::get('/auth-user/', 'Api\UserController@authUser')->middleware('auth.api');
Route::post('/user/create', 'Api\UserController@create')->name('user.create');

Route::middleware(['auth.api'])->group(function () {
    Route::get('/hymns/all', 'Api\HymnListController@all')->name('hymns.all');
    Route::get('/sunday-school/all', 'Api\SundaySchoolController@all')->name('sunday_school.all');
});


