<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SkemaPs\Controllers\SkemaPsController;

Route::controller(SkemaPsController::class)->middleware(['web','auth'])->name('skemaps.')->group(function(){
	Route::get('/skemaps', 'index')->name('index');
	Route::get('/skemaps/data', 'data')->name('data.index');
	Route::get('/skemaps/create', 'create')->name('create');
	Route::post('/skemaps', 'store')->name('store');
	Route::get('/skemaps/{skemaps}', 'show')->name('show');
	Route::get('/skemaps/{skemaps}/edit', 'edit')->name('edit');
	Route::patch('/skemaps/{skemaps}', 'update')->name('update');
	Route::get('/skemaps/{skemaps}/delete', 'destroy')->name('destroy');
});