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

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::middleware('gestion')->group(function(){
    Route::name('gestion.')->group(function(){
        Route::prefix('gestion')->group(function(){
            Route::get('/', 'GestionController@index')->name('index');
            Route::post('/{quartier}/stock', 'QuartierController@stock')->name('post');
            Route::get('/{quartier}', 'GestionController@show')->name('show');
        });
    });
});

//Login Routes
Route::get('login', 'AuthController@index')->name('login')->middleware('guest');
Route::post('login', 'AuthController@authenticate');
//Register Routes
// Route::get('register', 'AuthController@register');
// Route::post('post-register', 'AuthController@postRegister');
// Route::get('dashboard', 'AuthController@dashboard');
//Logout Route
Route::get('/logout','Authcontroller@logout')->name('logout');
