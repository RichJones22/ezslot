<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('splash');
});
//
Route::get('/home', 'HomeController@show');

Route::get('/test','SymbolsController@testSymbols');


/*
 * --------------------------------------------------------------------------------------------------------------------
 * API Docs (Swagger
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/api-docs', 'ApiDocController@index');
Route::get('/api-docs/getdocs', 'ApiDocController@getDocs');


