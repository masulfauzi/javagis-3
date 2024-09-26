<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SeksiWilayah\Controllers\SeksiWilayahController;

Route::controller(SeksiWilayahController::class)->middleware(['web','auth'])->name('seksiwilayah.')->group(function(){
	// custom routes
	Route::get('/seksiwilayah/get_seksi_wilayah', 'get_seksi_wilayah')->name('get_seksi_wilayah.index');

	
	
	Route::get('/seksiwilayah', 'index')->name('index');
	Route::get('/seksiwilayah/data', 'data')->name('data.index');
	Route::get('/seksiwilayah/create', 'create')->name('create');
	Route::post('/seksiwilayah', 'store')->name('store');
	Route::get('/seksiwilayah/{seksiwilayah}', 'show')->name('show');
	Route::get('/seksiwilayah/{seksiwilayah}/edit', 'edit')->name('edit');
	Route::patch('/seksiwilayah/{seksiwilayah}', 'update')->name('update');
	Route::get('/seksiwilayah/{seksiwilayah}/delete', 'destroy')->name('destroy');
});