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


Route::get('/login','Auth\LoginController@view')->name('login');
Route::post('/login','Auth\LoginController@login')->name('login.post');
Route::get('/logout','Auth\LoginController@logout')->name('logout');
//Route::get('/home','DashboardController@index')->middleware('auth');

Route::get('/home/{vue_capture?}', "DashboardController@index")->middleware('auth')->where('vue_capture', '[\/\w\.-]*')->name('home');
