<?php

use App\Http\Controllers\Api\TamuController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('tamu')->group(function () {
    // Menampilkan semua data tamu
    Route::get('/', [TamuController::class, 'index']);

    // Menyimpan data tamu baru
    Route::post('/', [TamuController::class, 'store']);

    // Menampilkan data tamu berdasarkan ID
    Route::get('{id}', [TamuController::class, 'show']);

    // Memperbarui data tamu berdasarkan ID
    Route::put('{id}', [TamuController::class, 'update']);

    // Menghapus data tamu berdasarkan ID
    Route::delete('{id}', [TamuController::class, 'destroy']);
});
