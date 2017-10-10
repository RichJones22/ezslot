<?php

/*
 * --------------------------------------------------------------------------------------------------------------------
 * barryvdh testing routes.
 *
 * - these need to be converted to a testing controller, and view to show tests to run...
 *
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/testSymbolsUnique','SymbolsController@testSymbolsUnique');
Route::get('/testPopulateSymbolsTable','SymbolsController@testPopulateSymbolsTable');

Route::post('/welcomeEmail', 'EmailController@welcomeEmail');
Route::get('/getAllWelcomeEmailLeads', 'EmailController@getAllWelcomeEmailLeads');
