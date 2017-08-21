<?php

// Routeentication Routes...
Route::get('predict/{slug}', 'FootballController@showPredictPosition')->name('predict.football');
Route::post('predict/{slug}', 'FootballController@predictPosition');
