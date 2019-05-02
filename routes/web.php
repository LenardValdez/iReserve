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

Route::get('/', 'DashboardController@index');

Auth::routes();

Route::get('/Dashboard', 'DashboardController@index')->name('Dashboard');
Route::view('/History', 'pages.history')->name('History');
Route::view('/Reserve', 'pages.reservation')->name('Reserve');



Route::get('/room/display', 'RoomController@index')->name('roomdisplay'); //Display all rooms
Route::get('/room/add', 'RoomController@create')->name('addroom'); //Display form to add room
Route::post('/room/add', 'RoomController@store')->name('processaddroom'); //Process ng form to add room
Route::post('/Reserve','RoomController@destroy')->name('processdelroom'); //Process ng form to del room