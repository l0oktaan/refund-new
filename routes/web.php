<?php

use Illuminate\Support\Facades\Auth;
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
Route::group(['middleware' => ['XSS']], function () {
Route::any('/{any?}', function (){
    return view('index');
})->where('any', '[\/\w\.-]*')->name('app');
});
/* Route::any('/admin', function (){
    return view('admin');
})->where('any', '[\/\w\.-]*')->name('app'); */

//Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
