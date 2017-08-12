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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    require __DIR__ . '/web/admin/auth.php';

    Route::group(['middleware' => 'auth:admin_web'], function () {

        Route::get('/', function () {
            return 'Hello World';
        });
    });
});