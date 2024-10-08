<?php

use Illuminate\Support\Facades\Route;
use App\Modules\KoordSurvey\Controllers\KoordSurveyController;

Route::controller(KoordSurveyController::class)->middleware(['web','auth'])->name('koordsurvey.')->group(function(){
	// custom route
	Route::post('/koordsurvey/simpan_koord_tracking', 'simpan_koord_tracking')->name('simpan_koord_tracking.store');



	
	Route::get('/koordsurvey/{survey}', 'index')->name('index');
	Route::get('/koordsurvey/data', 'data')->name('data.index');
	Route::get('/koordsurvey/create/baru', 'create')->name('create');
	Route::post('/koordsurvey', 'store')->name('store');
	Route::get('/koordsurvey/{koordsurvey}/detail', 'show')->name('show');
	Route::get('/koordsurvey/{koordsurvey}/edit', 'edit')->name('edit');
	Route::patch('/koordsurvey/{koordsurvey}', 'update')->name('update');
	Route::get('/koordsurvey/{koordsurvey}/delete', 'destroy')->name('destroy');
});