<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Tematik\Controllers\TematikController;

Route::controller(TematikController::class)->middleware(['web','auth'])->name('tematik.')->group(function(){
	Route::get('/tematik', 'index')->name('index');
	Route::get('/tematik/data', 'data')->name('data.index');
	Route::get('/tematik/create', 'create')->name('create');
	Route::post('/tematik', 'store')->name('store');
	Route::get('/tematik/{tematik}', 'show')->name('show');
	Route::get('/tematik/{tematik}/edit', 'edit')->name('edit');
	Route::patch('/tematik/{tematik}', 'update')->name('update');
	Route::get('/tematik/{tematik}/delete', 'destroy')->name('destroy');
});