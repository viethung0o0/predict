<?php

// Routeentication Routes...
Route::get('predict/{slug}', 'FootballController@showPredictPosition')->name('predict.football.champion');
Route::post('predict/{slug}', 'FootballController@predictPosition');
