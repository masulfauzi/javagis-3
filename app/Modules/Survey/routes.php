<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Survey\Controllers\SurveyController;

Route::controller(SurveyController::class)->middleware(['web','auth'])->name('survey.')->group(function(){
	// custom routes
	Route::get('/survey/form_marker/{kps}', 'form_marker')->name('form_marker.create');
	Route::get('/survey/form_survey/{kps}', 'form_survey')->name('form_survey.create');

	
	
	
	Route::get('/survey', 'index')->name('index');
	Route::get('/survey/data', 'data')->name('data.index');
	Route::get('/survey/create', 'create')->name('create');
	Route::post('/survey', 'store')->name('store');
	Route::get('/survey/{survey}', 'show')->name('show');
	Route::get('/survey/{survey}/edit', 'edit')->name('edit');
	Route::patch('/survey/{survey}', 'update')->name('update');
	Route::get('/survey/{survey}/delete', 'destroy')->name('destroy');
});