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

Route::get('/', function () {
    return view('welcome');
});


//Login Routes
Route::get('login', 'AuthController@index');
Route::post('post-login', 'AuthController@postLogin');
//Register Routes
// Route::get('register', 'AuthController@register');
// Route::post('post-register', 'AuthController@postRegister');
// Route::get('dashboard', 'AuthController@dashboard');
//Logout Route
Route::get('logout', 'AuthController@logout');

Route::get('/home', 'HomeController@index')->name('home');
