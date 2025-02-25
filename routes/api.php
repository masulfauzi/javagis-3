<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [LoginController::class, 'login']);
Route::get('/kps', [ApiController::class, 'get_kps'])->middleware('auth:sanctum');
Route::get('/kps/{kps}', [ApiController::class, 'detail_kps'])->middleware('auth:sanctum');
Route::post('/survei/start', [ApiController::class, 'start_survei'])->middleware('auth:sanctum');
Route::post('/survei/update', [ApiController::class, 'update_survei'])->middleware('auth:sanctum');