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


Auth::routes();

Route::group(['prefix' => '', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect('/admin');
    });
    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin']);
        Route::resource('/article', 'ArticleController');
    });
});

