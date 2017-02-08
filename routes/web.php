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

use App\Agenda;

Route::get('/', function () {
    return view('index')->with('agendas', Agenda::orderBy('begin_at')->where('end_at', '>=', time())->get());
});
Route::resource('calendar', 'CalendarController');
