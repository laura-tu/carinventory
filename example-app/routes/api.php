<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;

// API routes for cars
Route::get('/cars', [CarController::class, 'index']);
Route::post('/cars', [CarController::class, 'store']);
Route::get('/cars/{car}', [CarController::class, 'show']);
Route::put('/cars/{car}', [CarController::class, 'update']);
Route::delete('/cars/{car}', [CarController::class, 'destroy']);

// API routes for parts
Route::get('/parts', [PartController::class, 'index']);
Route::post('/parts', [PartController::class, 'store']);
Route::get('/parts/{part}', [PartController::class, 'show']);
Route::put('/parts/{part}', [PartController::class, 'update']);
Route::delete('/parts/{part}', [PartController::class, 'destroy']);
