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

Auth::routes(); // authentication

Route::get('/home', 'HomeController@index')->name('home');
// CRUD
Route::post('/storeDeveloper', 'DevelopersController@store');
Route::get('/readDeveloper', 'DevelopersController@show');
Route::post('/editDeveloper/{id?}', 'DevelopersController@update');
Route::post('/deleteDeveloper/{id?}', 'DevelopersController@destroy');
// Allow multiple delete
Route::post('/deleteDevelopers/{id?}','DevelopersController@delete_developers');