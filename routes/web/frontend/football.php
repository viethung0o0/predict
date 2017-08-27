<?php

// Routeentication Routes...
Route::get('predict/{slug}', 'PredictController@showPredict')->name('predict');
Route::post('predict/{slug}', 'PredictController@predict');
