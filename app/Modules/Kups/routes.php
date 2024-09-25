<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Kups\Controllers\KupsController;

Route::controller(KupsController::class)->middleware(['web','auth'])->name('kups.')->group(function(){
	Route::get('/kups', 'index')->name('index');
	Route::get('/kups/data', 'data')->name('data.index');
	Route::get('/kups/create', 'create')->name('create');
	Route::post('/kups', 'store')->name('store');
	Route::get('/kups/{kups}', 'show')->name('show');
	Route::get('/kups/{kups}/edit', 'edit')->name('edit');
	Route::patch('/kups/{kups}', 'update')->name('update');
	Route::get('/kups/{kups}/delete', 'destroy')->name('destroy');
});