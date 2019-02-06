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
    //return view('welcome');
    return redirect('admin/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('test-broadcast', function () {
    event(new \App\Events\ExampleEvent("value"));
//    broadcast(new \App\Events\ExampleEvent);
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
