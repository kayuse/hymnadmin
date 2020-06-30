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
Route::post('/user/authenticate', 'Api\UserController@authenticate')->name('user.authenticate');

Route::middleware(['auth.api'])->group(function () {
    Route::get('/hymns/all', 'Api\HymnListController@all')->name('hymns.all');
    Route::get('/hymns/{id}/download', 'Api\HymnMediaController@download')->name('hymns.download');
    Route::get('/hymns/categories', 'Api\HymnListController@categories')->name('hymns.categories');
    Route::post('/hymns/media/add', 'Api\HymnMediaController@add')->name('hymns.add');
    Route::get('/sunday-school/all', 'Api\SundaySchoolController@all')->name('sunday_school.all');
    Route::get('/sunday-school/categories', 'Api\SundaySchoolController@categories')->name('sunday_school.categories');
    Route::get('/sunday-school/topic/{id}', 'Api\SundaySchoolController@getTopic')->name('sunday_school.topic');
    Route::post('sunday-school/add-podcast', 'Api\PodcastController@addPodcast')->name('sunday_school.podcast.new');
    Route::get('/sunday-school/download-podcast/{id}', 'Api\PodcastController@downloadPodCast')->name('sunday_school.podcast.download');
    Route::post('sunday-school/podcast/add-comment', 'Api\PodcastCommentController@addComment')->name('podcast.add_comment');
    Route::get('sunday-school/podcast/{id}/comments', 'Api\PodcastCommentController@getComments')->name('podcast.add_comment');
});


