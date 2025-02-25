<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Kabupaten\Controllers\KabupatenController;

Route::controller(KabupatenController::class)->middleware(['web','auth'])->name('kabupaten.')->group(function(){
	// custom routes
	Route::get('/kabupaten/get_kabupaten', 'get_kabupaten')->name('get_kabupaten.index');
	Route::get('/kabupaten/get_kabupaten_tematik', 'get_kabupaten_tematik')->name('get_kabupaten_tematik.index');
	
	
	Route::get('/kabupaten', 'index')->name('index');
	Route::get('/kabupaten/data', 'data')->name('data.index');
	Route::get('/kabupaten/create', 'create')->name('create');
	Route::post('/kabupaten', 'store')->name('store');
	Route::get('/kabupaten/{kabupaten}', 'show')->name('show');
	Route::get('/kabupaten/{kabupaten}/edit', 'edit')->name('edit');
	Route::patch('/kabupaten/{kabupaten}', 'update')->name('update');
	Route::get('/kabupaten/{kabupaten}/delete', 'destroy')->name('destroy');
});