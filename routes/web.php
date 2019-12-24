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

Auth::routes();

Route::get('/home', 'AbsencesController@index')->name('home');
Route::get('/auth/redirect/{provider}', 'UsersController@redirect');
Route::get('/callback/{provider}', 'UsersController@callback');

Route::resource('absences', 'AbsencesController');

Route::resources([
    'absences' => 'AbsencesController',
    'users' => 'UsersController'
]);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('absences/{absence}/accept', 'AbsencesController@accept')->name('absences.accept');
    Route::post('absences/{absence}/reject', 'AbsencesController@reject')->name('absences.reject');
    Route::post('absences/{absence}/undo', 'AbsencesController@undo')->name('absences.undo');
    Route::post('users/{user}/make-admin', 'UsersController@makeAdmin')->name('users.make-admin');
    Route::post('users/{user}/remove-admin', 'UsersController@removeAdmin')->name('users.remove-admin');
    Route::get('/calender', 'AbsencesController@calender')->name('calender');
});