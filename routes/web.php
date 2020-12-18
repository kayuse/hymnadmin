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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', 'Auth\LoginController@view')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.post');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/download-hymns', 'HymnController@download')->name('download');
//Route::get('/home','DashboardController@index')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'portal'], function () {
        Route::get('dashboard', 'Portal\DashboardController@index')->name('portal.dashboard');
        Route::get('hymns', 'Portal\HymnController@index')->name('portal.hymns.all');
        Route::get('hymns/{id}/details', 'Portal\HymnController@details')->name('portal.hymns.details');
        Route::get('hymns/new', 'Portal\HymnController@viewNew')->name('portal.hymns.new.get');
        Route::post('hymns/new', 'Portal\HymnController@new')->name('portal.hymns.new.post');
        Route::get('hymns/{id}/edit', 'Portal\HymnController@viewEdit')->name('portal.hymns.edit.get');
        Route::post('hymns/{id}/edit', 'Portal\HymnController@edit')->name('portal.hymns.edit.post');
        Route::get('hymns/{id}/upload', 'Portal\HymnController@viewUpload')->name('portal.hymns.upload.get');
        Route::post('hymns/{id}/upload', 'Portal\HymnController@upload')->name('portal.hymns.upload.post');
        Route::get('hymn/{id}/verses', 'Portal\HymnController@verses')->name('portal.hymns.verses');
        /**
         * Sunday School Details route
         */
        Route::get('sunday-school/', 'Portal\SundaySchoolController@index')->name('portal.sundayschool.all');
        Route::get('download/{file}', 'S3Controller@download')->name('portal.download');
    });

});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
