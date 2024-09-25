<?php

use Illuminate\Support\Facades\Route;
use App\Modules\KelasKups\Controllers\KelasKupsController;

Route::controller(KelasKupsController::class)->middleware(['web','auth'])->name('kelaskups.')->group(function(){
	Route::get('/kelaskups', 'index')->name('index');
	Route::get('/kelaskups/data', 'data')->name('data.index');
	Route::get('/kelaskups/create', 'create')->name('create');
	Route::post('/kelaskups', 'store')->name('store');
	Route::get('/kelaskups/{kelaskups}', 'show')->name('show');
	Route::get('/kelaskups/{kelaskups}/edit', 'edit')->name('edit');
	Route::patch('/kelaskups/{kelaskups}', 'update')->name('update');
	Route::get('/kelaskups/{kelaskups}/delete', 'destroy')->name('destroy');
});