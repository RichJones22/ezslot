<?php

/*
 * --------------------------------------------------------------------------------------------------------------------
 * API Docs (Swagger)
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/api-docs', 'ApiDocController@index');
Route::get('/api-docs/getdocs', 'ApiDocController@getDocs');

