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

Route::get('/', 'PageController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', 'PageController@index')->name('Dashboard');
    Route::get('/reserve', 'RoomController@index')->name('Reserve');

    Route::post('/reserve/cancel', 'RoomController@cancel')->name('cancelrequest');
    Route::post('/reserve/new', 'RoomController@reserve')->name('reserveroom');

    Route::get('/read/{id}', 'NotificationController@readNotif')->name('readnotification');
    Route::get('/readAll', 'NotificationController@readAllNotif')->name('readallnotifs');

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

    Route::get('/schedule/template', 'ClassScheduleController@download')->name('template');
    Route::post('/schedule/new', 'ClassScheduleController@store')->name('insertschedule');
    Route::post('/schedule/del','ClassScheduleController@destroy')->name('deleteschedule');
});

Route::group(['middleware' => ['auth', 'staff']], function() {
    Route::get('/history', 'PageController@historyList')->name('History');
});