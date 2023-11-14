<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AnakAsuhController;
use App\Http\Controllers\Api\PenyakitController;
use App\Http\Controllers\Api\KesehatanAnakController;
use App\Http\Controllers\Api\PendidikanAnakController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/anak-asuh', App\Http\Controllers\Api\AnakAsuhController::class);
Route::apiResource('/data-penyakit', App\Http\Controllers\Api\PenyakitController::class);
Route::apiResource('/kesehatan-anak', App\Http\Controllers\Api\KesehatanAnakController::class);
Route::apiResource('/pendidikan-anak', App\Http\Controllers\Api\PendidikanAnakController::class);
Route::apiResource('/prestasi-anak', App\Http\Controllers\Api\PrestasiAnakController::class);
