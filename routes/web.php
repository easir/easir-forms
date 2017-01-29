<?php

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


// EASI'R Oauth
Route::get('/',      'AuthController@index');
Route::get('/easir', 'AuthController@easir');
Route::get('/logout', function() {
    app('session')->clear();
    return redirect('/');
});

Route::get('/builder',  'BuilderController@builder')->middleware('auth.easir');
Route::post('/builder', 'BuilderController@builderPost')->middleware('auth.easir');
