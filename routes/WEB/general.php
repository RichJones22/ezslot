<?php

// spark '/login' and '/register' are suppressed for first deploy.
//Route::get( '/login', function() {
//    return view('splash');
//});
//Route::get( '/register', function() {
//    return view('splash');
//});


Route::get('/', function () {
    return view('splash');
});

Route::get('/errorThis', function(){
    throw new Exception('testing if errors are coming through...');
});


Route::get('/home', 'HomeController@show');




