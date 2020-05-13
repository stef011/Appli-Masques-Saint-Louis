<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Fragment\RoutableFragmentRenderer;

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

// Route::get('error', 'HomeController@error')->name('error');
Route::get('/', 'HomeController@index')->name('accueil');

// TODO: Remove Test Route
Route::get('/test', function(){
    return view('inscription.show');
});


// Routes d'inscription
Route::group(['prefix'=>'inscription', 'as'=>'inscription.'], function()
{
    Route::get('/', 'InscriptionController@index')->name('index');
    Route::post('/add', 'InscriptionController@add')->name('add');
    Route::get('{membre}/remove', 'InscriptionController@remove')->name('remove');
    Route::get('/show', 'InscriptionController@showGet')->name('show');
    Route::post('/show', 'InscriptionController@show')->name('show');
    Route::get('/confirmed', 'InscriptionController@confirm')->name('confirm');
    Route::get('/get', 'InscriptionController@get')->name('get');
    Route::post('/get', 'InscriptionController@get')->name('get');
    Route::get('/{inscription:numero}/edit', 'InscriptionController@edit')->name('edit');
    Route::put('/{inscription:numero}/edit', 'InscriptionController@editPut')->name('edit');

});



Route::middleware(['gestion','auth'])->group(function(){
    Route::name('gestion.')->group(function(){
        Route::prefix('gestion')->group(function(){
            Route::get('/', 'GestionController@index')->name('index');
            Route::post('/{quartier}/stock', 'QuartierController@stock')->name('post');
            Route::get('/{quartier}', 'GestionController@show')->name('show');
        });
    });
});

// Distribution
Route::group(['prefix' => 'distribution', 'as'=>'distribution.', 'middleware'=> ['userQuartier','auth']], function () {
    Route::get('/', 'DistributionController@index')->name('index');
    Route::get('/{quartier:id}', 'DistributionController@show')->name('show');
    Route::post('/{quartier:id}/create', 'DistributionController@create')->name('create');
    Route::post('/{quartier:id}/demande', 'DistributionController@new')->name('demande');
});

// Admin Routes
Route::group(['prefix'=>'admin', 'as'=>'admin.','middleware'=>['adminCheck','auth']],function (){
    Route::get('/', 'AdminController@index')->name('index');
    Route::get('/{user:id}/password', 'AdminController@password')->name('password');
    Route::post('/{user:id}/password', 'AdminController@passwordChange')->name('password');
    Route::get('/{user:id}/edit', 'AdminController@edit')->name('edit');
    Route::put('/{user:id}/update', 'AdminController@update')->name('update');
    Route::get('/add', 'AdminController@addUser')->name('add');
    Route::post('/add', 'AdminController@createUser')->name('add');
    Route::get('/{user:id}/delete', 'AdminController@delete')->name('delete');
});

// Preinscription routes
Route::group(['prefix'=>'preinscription', 'as'=>'preinscription.', 'middleware'=>['auth', 'preinscriptionCheck']], function(){
    Route::get('/', 'PreinscriptionController@index')->name('index');
    Route::get('/show', 'PreinscriptionController@showGet')->name('show');
    Route::post('/show', 'PreinscriptionController@show')->name('show');
    Route::post('/add', 'PreinscriptionController@add')->name('add');
    Route::get('/{membre}/remove', 'PreinscriptionController@remove')->name('remove');
    Route::get('/confirmed', 'PreinscriptionController@confirm')->name('confirm');
    Route::get('/list', 'PreinscriptionController@list')->name('list');
    Route::post('/search', 'PreinscriptionController@search')->name('search');
    Route::get('/search', 'PreinscriptionController@list')->name('search');
});


// Autocomplete Route
Route::post('/citoyens', 'CitoyenController@get')->name('citoyens');
Route::post('/rues', 'RueController@get')->name('rues');

// Check Citoyen route
Route::post('citoyen', 'CitoyenController@check')->name('citoyen');

//Login Routes
Route::get('login', 'AuthController@index')->name('login')->middleware('guest');
Route::post('login', 'AuthController@authenticate');
//Register Routes
// Route::get('register', 'AuthController@register');
// Route::post('post-register', 'AuthController@postRegister');
// Route::get('dashboard', 'AuthController@dashboard');
//Logout Route
Route::get('/logout','Authcontroller@logout')->name('logout');
