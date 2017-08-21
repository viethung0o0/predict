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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'as' => 'admin.'], function () {

    require __DIR__ . '/web/backend/auth.php';

    Route::group(['middleware' => 'auth:admin_web'], function () {

        Route::get('/', 'HomeController@index');

        Route::resource('admin-managements', 'AdminController');

        Route::resource('team-managements', 'TeamController');
    });
});


Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    require __DIR__ . '/web/frontend/football.php';
    require __DIR__ . '/web/frontend/auth.php';
});