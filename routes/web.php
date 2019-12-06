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

Route::resource('absences', 'AbsencesController');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('absences/{absence}/accept', 'AbsencesController@accept')->name('absences.accept');
    Route::post('absences/{absence}/reject', 'AbsencesController@reject')->name('absences.reject');
});