<?php

use Illuminate\Support\Facades\Route;
use App\Modules\BentukKups\Controllers\BentukKupsController;

Route::controller(BentukKupsController::class)->middleware(['web','auth'])->name('bentukkups.')->group(function(){
	Route::get('/bentukkups', 'index')->name('index');
	Route::get('/bentukkups/data', 'data')->name('data.index');
	Route::get('/bentukkups/create', 'create')->name('create');
	Route::post('/bentukkups', 'store')->name('store');
	Route::get('/bentukkups/{bentukkups}', 'show')->name('show');
	Route::get('/bentukkups/{bentukkups}/edit', 'edit')->name('edit');
	Route::patch('/bentukkups/{bentukkups}', 'update')->name('update');
	Route::get('/bentukkups/{bentukkups}/delete', 'destroy')->name('destroy');
});