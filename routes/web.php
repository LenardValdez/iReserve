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
Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

Route::get('/', 'PagesController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', 'PagesController@index')->name('Dashboard');
    Route::get('/history', 'RoomController@historyList')->name('History');
    Route::get('/reserve', 'RoomController@list')->name('Reserve');

    Route::post('/reserve/cancel', 'RoomController@cancel')->name('cancelrequest');
    Route::post('/reserve/new', 'RoomController@reserve')->name('reserveroom');

    Route::get('/read/{id}', 'RoomController@readNotif')->name('readnotification');
    Route::get('/readAll', 'RoomController@readAllNotif')->name('readallnotifs');

    Route::get('/rooms/6th-floor', 'JsonController@flr6');
    Route::get('/rooms/7th-floor', 'JsonController@flr7');
    Route::get('/rooms/8th-floor', 'JsonController@flr8');
    Route::get('/rooms/9th-floor', 'JsonController@flr9');
    Route::get('/rooms/10th-floor', 'JsonController@flr10');
    Route::get('/rooms/ground-floor', 'JsonController@grdflr');
});

Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::post('/reserve/add', 'RoomController@store')->name('processaddroom');
    Route::post('/reserve/del','RoomController@destroy')->name('processdelroom');

    Route::get('/dashboard/approve/{id}', 'RoomController@approve')->name('approverequest');
    Route::get('/dashboard/reject/{id}', 'RoomController@reject')->name('rejectrequest');

    Route::post('/schedule/new', 'ClassScheduleController@store')->name('insertschedule');
    Route::post('/schedule/del','ClassScheduleController@destroy')->name('deleteschedule');
});