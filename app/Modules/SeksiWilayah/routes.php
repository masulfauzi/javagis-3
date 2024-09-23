<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SeksiWilayah\Controllers\SeksiWilayahController;

Route::controller(SeksiWilayahController::class)->middleware(['web','auth'])->name('seksiwilayah.')->group(function(){
	Route::get('/seksiwilayah', 'index')->name('index');
	Route::get('/seksiwilayah/data', 'data')->name('data.index');
	Route::get('/seksiwilayah/create', 'create')->name('create');
	Route::post('/seksiwilayah', 'store')->name('store');
	Route::get('/seksiwilayah/{seksiwilayah}', 'show')->name('show');
	Route::get('/seksiwilayah/{seksiwilayah}/edit', 'edit')->name('edit');
	Route::patch('/seksiwilayah/{seksiwilayah}', 'update')->name('update');
	Route::get('/seksiwilayah/{seksiwilayah}/delete', 'destroy')->name('destroy');
});