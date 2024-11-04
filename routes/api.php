<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::delete('/delete', [AuthController::class, 'delete'])->name('delete');
        Route::put('/update', [AuthController::class, 'update'])->name('update');
    });
});

Route::get('produk', [ProductController::class, 'index']); // Mendapatkan semua produk
Route::post('produk', [ProductController::class, 'store']); // Menambahkan produk baru
Route::get('produk/{id}', [ProductController::class, 'show']); // Mendapatkan detail produk berdasarkan ID
Route::put('produk/{id}', [ProductController::class, 'update']); // Mengupdate produk berdasarkan ID
Route::delete('produk/{id}', [ProductController::class, 'destroy']); // Menghapus produk berdasarkan ID
