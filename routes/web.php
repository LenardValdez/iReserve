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
Auth::routes();

Route::get('/', 'DashboardController@index');

Route::get('/dashboard', 'DashboardController@index')->name('Dashboard');
Route::view('/history', 'pages.history')->name('History');
Route::get('/reserve', 'RoomController@list')->name('Reserve');
// Route::get('/reserve', 'RoomController@approve')->name('Reserve');

Route::post('/reserve/new', 'RoomController@reserve')->name('reserveroom');
Route::post('/reserve/add', 'RoomController@store')->name('processaddroom'); //Process ng form to add room
Route::post('/reserve/del','RoomController@destroy')->name('processdelroom'); //Process ng form to del room
Route::get('/dashboard/approve/{id}', 'RoomController@approve')->name('approverequest');
Route::get('/dashboard/reject/{id}', 'RoomController@reject')->name('rejectrequest');
