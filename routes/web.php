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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'clients'], function () {

    // ** Additional Improvements **
    // Give all routes a name e.g.  Route::get('/create', 'ClientsController@create')->name('clients.create');
    // Use Controller class definition instead of string e.g. Route::get('/', [ClientsController::class, 'index'])->name('clients.index');
    // Replace /{client} with {id} or {clientId} (better readability)
    Route::get('/', 'ClientsController@index')->name('clients.index');
    Route::get('/create', 'ClientsController@create');
    Route::post('/', 'ClientsController@store');
    Route::get('/{client}', 'ClientsController@show');
    Route::delete('/{client}', 'ClientsController@destroy');

    Route::get('/{client}/journals', 'JournalsController@index');
    Route::post('/{client}/journals', 'JournalsController@store');
    Route::delete('/{client}/journals/{journal}', 'JournalsController@destroy');
});
