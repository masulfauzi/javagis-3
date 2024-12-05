<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Survey\Controllers\SurveyController;

Route::controller(SurveyController::class)->middleware(['web','auth'])->name('survey.')->group(function(){
	// custom routes
	Route::get('/survey/form_marker/{kps}', 'form_marker')->name('form_marker.create');
	Route::get('/survey/form_survey/{kps}', 'form_survey')->name('form_survey.create');
	Route::get('/survey/form_line/{kps}', 'form_line')->name('form_line.create');
	Route::get('/survey/export/{survey}', 'export_survey')->name('export.show');
	Route::post('/survey/save_image', 'save_image')->name('save_image.store');
	Route::get('/survey/print/{survey}', 'print')->name('print.show');
	Route::get('/survey/tracking/{survey}', 'tracking')->name('tracking.show');
	Route::get('/survey/marker/{survey}', 'marker')->name('marker.show');
	Route::get('/survey/marker/start/{survey}', 'marker_start')->name('marker.start.show');
	Route::get('/survey/marker/manual/{survey}', 'marker_manual')->name('marker.manual.show');
	Route::get('/survey/polygon/start/{survey}', 'polygon_start')->name('polygon.start.show');
	Route::get('/survey/polygon/{survey}', 'polygon')->name('polygon.show');
	Route::get('/survey/polyline/{survey}', 'polyline')->name('polyline.show');
	Route::post('/survey/simpan_luas', 'simpan_luas')->name('simpan_luas.store');
	Route::post('/survey/simpan_polygon_manual', 'simpan_polygon_manual')->name('simpan_polygon_manual.store');
	Route::get('/survey/form_polygon_manual', 'form_polygon_manual')->name('form_polygon_manual.create');
	Route::get('/survey/form_polyline_manual', 'form_polyline_manual')->name('form_polyline_manual.create');
	Route::post('/survey/simpan_polyline_manual', 'simpan_polyline_manual')->name('simpan_polyline_manual.store');
	Route::get('/survey/polyline/start/{survey}', 'polyline_start')->name('polyline.start.show');
	Route::get('/survey/polyline/tracking/{survey}', 'polyline_tracking')->name('polyline.tracking.show');

	
	
	
	Route::get('/survey', 'index')->name('index');
	Route::get('/survey/data', 'data')->name('data.index');
	Route::get('/survey/create', 'create')->name('create');
	Route::post('/survey', 'store')->name('store');
	Route::get('/survey/{survey}', 'show')->name('show');
	Route::get('/survey/{survey}/edit', 'edit')->name('edit');
	Route::patch('/survey/{survey}', 'update')->name('update');
	Route::get('/survey/{survey}/delete', 'destroy')->name('destroy');
});