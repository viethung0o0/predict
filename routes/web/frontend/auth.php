<?php

Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function () {
    Route::get('google/redirect', 'LoginController@redirectToProvider')->name('redirect');
    Route::get('google/oauth2callback', 'LoginController@handleProviderCallback')->name('google.callback');

    Route::get('logout', function () {
       auth()->logout();
       return redirect()->back();
    })->name('logout');
});