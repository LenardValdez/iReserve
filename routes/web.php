<?php
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PagesController@index');

Route::get('/dashboard', 'PagesController@index')->name('Dashboard');
Route::get('/history', 'RoomController@historyList')->name('History');
Route::get('/reserve', 'RoomController@list')->name('Reserve');

Route::get('/history/cancel/{id}', 'RoomController@cancel')->name('cancelrequest');
Route::post('/reserve/new', 'RoomController@reserve')->name('reserveroom');
Route::post('/reserve/add', 'RoomController@store')->name('processaddroom'); //Process ng form to add room
Route::post('/reserve/del','RoomController@destroy')->name('processdelroom'); //Process ng form to del room
Route::get('/dashboard/approve/{id}', 'RoomController@approve')->name('approverequest');
Route::get('/dashboard/reject/{id}', 'RoomController@reject')->name('rejectrequest');
Route::get('/read/{id}', 'RoomController@readNotif')->name('readnotification');
Route::get('/readAll', 'RoomController@readAllNotif')->name('readallnotifs');

Route::get('/rooms/8th-floor', 'JsonController@flr8');
Route::get('/rooms/9th-floor', 'JsonController@flr9');
Route::get('/rooms/cl-10th-floor', 'JsonController@cl10');