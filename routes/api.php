<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataGuruController;
use App\Http\Controllers\Api\AuthController;

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

Route::prefix('guru')->group(function () {
    Route::get('/', [DataGuruController::class, 'index']); // Menampilkan daftar guru
    Route::post('/', [DataGuruController::class, 'store']); // Menambahkan guru baru
    Route::get('/{id}', [DataGuruController::class, 'show']); // Menampilkan detail guru
    Route::put('/{id}', [DataGuruController::class, 'update']); // Memperbarui data guru
    Route::delete('/{id}', [DataGuruController::class, 'destroy']); // Menghapus data guru
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']); // Registrasi
    Route::post('/login', [AuthController::class, 'login']); // Login
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']); // Data pengguna
        Route::post('/logout', [AuthController::class, 'logout']); // Logout
    });
});