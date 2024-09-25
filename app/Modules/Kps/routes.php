<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Kps\Controllers\KpsController;

Route::controller(KpsController::class)->middleware(['web','auth'])->name('kps.')->group(function(){
	// route custom
	Route::post('/kps/simpan_batas', 'simpan_batas')->name('simpan_batas.store');

	Route::get('/kps', 'index')->name('index');
	Route::get('/kps/data', 'data')->name('data.index');
	Route::get('/kps/create', 'create')->name('create');
	Route::post('/kps', 'store')->name('store');
	Route::get('/kps/{kps}', 'show')->name('show');
	Route::get('/kps/{kps}/edit', 'edit')->name('edit');
	Route::patch('/kps/{kps}', 'update')->name('update');
	Route::get('/kps/{kps}/delete', 'destroy')->name('destroy');
});