<?php

use Illuminate\Support\Facades\Route;
use App\Modules\BalaiPskl\Controllers\BalaiPsklController;

Route::controller(BalaiPsklController::class)->middleware(['web','auth'])->name('balaipskl.')->group(function(){
	Route::get('/balaipskl', 'index')->name('index');
	Route::get('/balaipskl/data', 'data')->name('data.index');
	Route::get('/balaipskl/create', 'create')->name('create');
	Route::post('/balaipskl', 'store')->name('store');
	Route::get('/balaipskl/{balaipskl}', 'show')->name('show');
	Route::get('/balaipskl/{balaipskl}/edit', 'edit')->name('edit');
	Route::patch('/balaipskl/{balaipskl}', 'update')->name('update');
	Route::get('/balaipskl/{balaipskl}/delete', 'destroy')->name('destroy');
});