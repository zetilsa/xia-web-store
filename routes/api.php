<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);
Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->middleware('auth:sanctum');
Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show']);
Route::put('/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->middleware('auth:sanctum');
Route::post('/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
